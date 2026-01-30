<?php
session_start();

require_once __DIR__ . '/../../config/db-connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? null;
$db = getDB();

if (!$db) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

try {
    switch ($action) {
        case 'list':
            $category = $_GET['category'] ?? 'all';
            $status = $_GET['status'] ?? 'active';
            
            $sql = "SELECT * FROM portfolios WHERE status = ?";
            $params = [$status];
            
            if ($category !== 'all') {
                $sql .= " AND category = ?";
                $params[] = $category;
            }
            
            $sql .= " ORDER BY display_order ASC";
            
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $portfolios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($portfolios as &$p) {
                if ($p['technologies']) {
                    $p['technologies'] = json_decode($p['technologies'], true);
                }
            }
            
            echo json_encode($portfolios);
            break;

        case 'get':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception('ID is required');
            }
            
            $stmt = $db->prepare("SELECT * FROM portfolios WHERE id = ?");
            $stmt->execute([$id]);
            $portfolio = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$portfolio) {
                http_response_code(404);
                echo json_encode(['error' => 'Portfolio not found']);
                exit;
            }
            
            if ($portfolio['technologies']) {
                $portfolio['technologies'] = json_decode($portfolio['technologies'], true);
            }
            
            echo json_encode($portfolio);
            break;

        case 'create':
            $data = json_decode(file_get_contents('php://input'), true);
            
            $required = ['title', 'category', 'thumbnail'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new Exception("$field is required");
                }
            }
            
            $stmt = $db->prepare("
                INSERT INTO portfolios 
                (title, description, category, thumbnail, thumbnail_local_path, project_url, 
                 demo_type, internal_demo_url, image_alt_text, technologies, client_name, 
                 completion_date, featured, display_order, status, created_by)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $technologies = isset($data['technologies']) ? json_encode($data['technologies']) : null;
            
            $stmt->execute([
                $data['title'],
                $data['description'] ?? null,
                $data['category'],
                $data['thumbnail'],
                $data['thumbnail_local_path'] ?? null,
                $data['project_url'] ?? null,
                $data['demo_type'] ?? 'external',
                $data['internal_demo_url'] ?? null,
                $data['image_alt_text'] ?? null,
                $technologies,
                $data['client_name'] ?? null,
                $data['completion_date'] ?? null,
                $data['featured'] ? 1 : 0,
                $data['display_order'] ?? 0,
                $data['status'] ?? 'active',
                $_SESSION['user_id']
            ]);
            
            echo json_encode(['success' => true, 'id' => $db->lastInsertId()]);
            break;

        case 'update':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new Exception('ID is required');
            }
            
            $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            
            $updates = [];
            $params = [];
            $allowedFields = ['title', 'description', 'category', 'thumbnail', 'thumbnail_local_path', 
                            'project_url', 'demo_type', 'internal_demo_url', 'image_alt_text', 
                            'technologies', 'client_name', 'completion_date', 'featured', 
                            'display_order', 'status'];
            
            foreach ($allowedFields as $field) {
                if (isset($data[$field])) {
                    if ($field === 'technologies') {
                        $updates[] = "$field = ?";
                        $params[] = is_array($data[$field]) ? json_encode($data[$field]) : $data[$field];
                    } else {
                        $updates[] = "$field = ?";
                        $params[] = $data[$field];
                    }
                }
            }
            
            if (empty($updates)) {
                throw new Exception('No fields to update');
            }
            
            $params[] = $id;
            $sql = "UPDATE portfolios SET " . implode(', ', $updates) . " WHERE id = ?";
            
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            
            echo json_encode(['success' => true, 'updated' => $stmt->rowCount()]);
            break;

        case 'delete':
            $id = $_GET['id'] ?? $_POST['id'] ?? null;
            if (!$id) {
                throw new Exception('ID is required');
            }
            
            $stmt = $db->prepare("DELETE FROM portfolios WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode(['success' => true, 'deleted' => $stmt->rowCount()]);
            break;

        case 'reorder':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['items']) || !is_array($data['items'])) {
                throw new Exception('items array is required');
            }
            
            $stmt = $db->prepare("UPDATE portfolios SET display_order = ? WHERE id = ?");
            
            foreach ($data['items'] as $order => $id) {
                $stmt->execute([$order, $id]);
            }
            
            echo json_encode(['success' => true]);
            break;

        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
