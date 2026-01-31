<?php


header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}



$logDirectory = __DIR__ . '/leads/';
if (!is_dir($logDirectory)) {
    mkdir($logDirectory, 0755, true);
}


$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['summary'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}


$summary = $input['summary'];
$summary = str_replace(['[START_LEAD_SUMMARY]', '[END_LEAD_SUMMARY]'], '', $summary);
$summary = trim($summary);


date_default_timezone_set('Asia/Tehran');
$filename = $logDirectory . 'lead_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.txt';


$fileContent = "تاریخ و زمان (تهران): " . date('Y-m-d H:i:s') . "\n";
$fileContent .= "IP کاربر: " . $_SERVER['REMOTE_ADDR'] . "\n";
$fileContent .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
$fileContent .= "--------------------------------------------------\n\n";
$fileContent .= $summary;


if (file_put_contents($filename, $fileContent)) {
    echo json_encode(['status' => 'success', 'message' => 'Lead saved']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to write to file on server. Check permissions for /api/leads/']);
}
?>


