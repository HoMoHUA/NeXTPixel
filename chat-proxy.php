<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['contents']) || !isset($input['systemInstruction'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$apiKey = 'YOUR_API_KEY_HERE'; 
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";

$ch = curl_init($apiUrl);

$payload = json_encode([
    'contents' => $input['contents'],
    'systemInstruction' => $input['systemInstruction']
]);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(['error' => 'Curl error: ' . curl_error($ch)]);
} else {
    http_response_code($httpCode);
    echo $response;
}

curl_close($ch);
?>