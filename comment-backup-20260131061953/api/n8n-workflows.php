<?php


header('Content-Type: application/json');


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'لطفا ابتدا وارد شوید']);
    exit;
}


require_once __DIR__ . '/../config/n8n-config.php';

$baseUrl = rtrim(N8N_BASE_URL, '/');
$apiKey = N8N_API_KEY;


function sendN8NRequest($url, $method = 'GET', $data = null) {
    global $apiKey;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, N8N_TIMEOUT);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    $headers = ['Content-Type: application/json'];
    
    
    if (!empty($apiKey)) {
        $headers[] = 'X-N8N-API-KEY: ' . $apiKey;
    }
    
    
    if (!empty(N8N_USERNAME) && !empty(N8N_PASSWORD)) {
        curl_setopt($ch, CURLOPT_USERPWD, N8N_USERNAME . ':' . N8N_PASSWORD);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    }
    
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    
    if (isset($_COOKIE) && !empty($_COOKIE)) {
        $cookieString = '';
        foreach ($_COOKIE as $key => $value) {
            $cookieString .= $key . '=' . $value . '; ';
        }
        if (!empty($cookieString)) {
            curl_setopt($ch, CURLOPT_COOKIE, rtrim($cookieString, '; '));
        }
    }
    
    if ($data !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return ['error' => $error, 'http_code' => $httpCode];
    }
    
    return [
        'data' => json_decode($response, true),
        'http_code' => $httpCode,
        'raw' => $response
    ];
}


$action = $_GET['action'] ?? ($_POST['action'] ?? null);


if (!$action && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? null;
}

try {
    switch ($action) {
        case 'list':
            
            $result = sendN8NRequest($baseUrl . '/api/v1/workflows');
            
            if (isset($result['error'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'خطا در دریافت workflows: ' . $result['error']
                ]);
                exit;
            }
            
            $workflows = $result['data'] ?? [];
            
            
            $formattedWorkflows = [];
            if (is_array($workflows)) {
                foreach ($workflows as $workflow) {
                    $formattedWorkflows[] = [
                        'id' => $workflow['id'] ?? null,
                        'name' => $workflow['name'] ?? 'بدون نام',
                        'description' => $workflow['description'] ?? '',
                        'active' => $workflow['active'] ?? false,
                        'nodes' => count($workflow['nodes'] ?? []),
                        'created_at' => $workflow['createdAt'] ?? null,
                        'updated_at' => $workflow['updatedAt'] ?? null
                    ];
                }
            }
            
            echo json_encode([
                'success' => true,
                'workflows' => $formattedWorkflows
            ]);
            break;
            
        case 'get':
            
            $workflowId = $_GET['id'] ?? null;
            
            if (!$workflowId) {
                echo json_encode(['success' => false, 'message' => 'ID workflow مشخص نشده است']);
                exit;
            }
            
            $result = sendN8NRequest($baseUrl . '/api/v1/workflows/' . $workflowId);
            
            if (isset($result['error'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'خطا در دریافت workflow: ' . $result['error']
                ]);
                exit;
            }
            
            $workflow = $result['data'] ?? null;
            
            if (!$workflow) {
                echo json_encode(['success' => false, 'message' => 'Workflow یافت نشد']);
                exit;
            }
            
            echo json_encode([
                'success' => true,
                'workflow' => [
                    'id' => $workflow['id'] ?? null,
                    'name' => $workflow['name'] ?? 'بدون نام',
                    'description' => $workflow['description'] ?? '',
                    'active' => $workflow['active'] ?? false,
                    'nodes' => $workflow['nodes'] ?? [],
                    'connections' => $workflow['connections'] ?? [],
                    'settings' => $workflow['settings'] ?? []
                ]
            ]);
            break;
            
        case 'create':
            
            $input = json_decode(file_get_contents('php://input'), true);
            
            $workflowData = [
                'name' => $input['name'] ?? 'New Workflow',
                'nodes' => [],
                'connections' => [],
                'active' => $input['active'] ?? false,
                'settings' => []
            ];
            
            if (isset($input['description'])) {
                $workflowData['settings']['description'] = $input['description'];
            }
            
            $result = sendN8NRequest($baseUrl . '/api/v1/workflows', 'POST', $workflowData);
            
            if (isset($result['error'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'خطا در ساخت workflow: ' . $result['error']
                ]);
                exit;
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Workflow با موفقیت ساخته شد',
                'workflow' => $result['data']
            ]);
            break;
            
        case 'update':
            
            $input = json_decode(file_get_contents('php://input'), true);
            $workflowId = $input['workflow_id'] ?? null;
            
            if (!$workflowId) {
                echo json_encode(['success' => false, 'message' => 'ID workflow مشخص نشده است']);
                exit;
            }
            
            
            $getResult = sendN8NRequest($baseUrl . '/api/v1/workflows/' . $workflowId);
            
            if (isset($getResult['error'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'خطا در دریافت workflow: ' . $getResult['error']
                ]);
                exit;
            }
            
            $workflow = $getResult['data'] ?? [];
            
            
            if (isset($input['name'])) {
                $workflow['name'] = $input['name'];
            }
            if (isset($input['description'])) {
                $workflow['settings']['description'] = $input['description'];
            }
            if (isset($input['active'])) {
                $workflow['active'] = $input['active'];
            }
            
            $result = sendN8NRequest($baseUrl . '/api/v1/workflows/' . $workflowId, 'PUT', $workflow);
            
            if (isset($result['error'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'خطا در به‌روزرسانی workflow: ' . $result['error']
                ]);
                exit;
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Workflow با موفقیت به‌روزرسانی شد',
                'workflow' => $result['data']
            ]);
            break;
            
        case 'activate':
            
            $input = json_decode(file_get_contents('php://input'), true);
            $workflowId = $input['workflow_id'] ?? null;
            
            if (!$workflowId) {
                echo json_encode(['success' => false, 'message' => 'ID workflow مشخص نشده است']);
                exit;
            }
            
            $result = sendN8NRequest($baseUrl . '/api/v1/workflows/' . $workflowId . '/activate', 'POST');
            
            if (isset($result['error'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'خطا در فعال کردن workflow: ' . $result['error']
                ]);
                exit;
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Workflow با موفقیت فعال شد'
            ]);
            break;
            
        case 'deactivate':
            
            $input = json_decode(file_get_contents('php://input'), true);
            $workflowId = $input['workflow_id'] ?? null;
            
            if (!$workflowId) {
                echo json_encode(['success' => false, 'message' => 'ID workflow مشخص نشده است']);
                exit;
            }
            
            $result = sendN8NRequest($baseUrl . '/api/v1/workflows/' . $workflowId . '/deactivate', 'POST');
            
            if (isset($result['error'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'خطا در غیرفعال کردن workflow: ' . $result['error']
                ]);
                exit;
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Workflow با موفقیت غیرفعال شد'
            ]);
            break;
            
        case 'delete':
            
            $input = json_decode(file_get_contents('php://input'), true);
            $workflowId = $input['workflow_id'] ?? null;
            
            if (!$workflowId) {
                echo json_encode(['success' => false, 'message' => 'ID workflow مشخص نشده است']);
                exit;
            }
            
            $result = sendN8NRequest($baseUrl . '/api/v1/workflows/' . $workflowId, 'DELETE');
            
            if (isset($result['error'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'خطا در حذف workflow: ' . $result['error']
                ]);
                exit;
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Workflow با موفقیت حذف شد'
            ]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Action نامعتبر است']);
            break;
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'خطا: ' . $e->getMessage()
    ]);
}
?>



