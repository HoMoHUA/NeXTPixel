<?php
require_once __DIR__ . '/../../config/db-connection.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? 'list';
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
            $featured_only = isset($_GET['featured']) ? (bool)$_GET['featured'] : false;
            
            $sql = "SELECT * FROM portfolios WHERE status = 'active'";
            $params = [];
            
            if ($category !== 'all') {
                $sql .= " AND category = ?";
                $params[] = $category;
            }
            
            if ($featured_only) {
                $sql .= " AND featured = 1";
            }
            
            $sql .= " ORDER BY display_order ASC, created_at DESC";
            
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

        case 'featured':
            $limit = (int)($_GET['limit'] ?? 6);
            
            $stmt = $db->prepare("
                SELECT * FROM portfolios 
                WHERE status = 'active' AND featured = 1
                ORDER BY display_order ASC, created_at DESC
                LIMIT ?
            ");
            $stmt->execute([$limit]);
            $portfolios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($portfolios as &$p) {
                if ($p['technologies']) {
                    $p['technologies'] = json_decode($p['technologies'], true);
                }
            }
            
            echo json_encode($portfolios);
            break;

        case 'categories':
            $stmt = $db->prepare("
                SELECT DISTINCT category FROM portfolios 
                WHERE status = 'active'
                ORDER BY category
            ");
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            echo json_encode($categories);
            break;

        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
