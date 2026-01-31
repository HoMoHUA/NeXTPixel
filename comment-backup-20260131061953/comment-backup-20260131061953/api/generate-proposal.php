<?php
// Set headers to allow requests from your domain and return JSON
// IMPORTANT: Replace 'https://your-domain.com' with your actual website domain for security
header("Access-Control-Allow-Origin: *"); // For development. Use your domain in production.
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight request for CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// IMPORTANT: Do NOT hardcode your API key here.
// Use an environment variable on your server for security.
$apiKey = getenv('GEMINI_API_KEY'); 
if (!$apiKey) {
    // Fallback for development or if env var is not set.
    // Replace with your key only for testing, but it's not recommended for production.
    $apiKey = "AlzaSyCvMs3MYV2-Wk-p_LTQqwO6qTRVkil8Gys"; 
}

// Get data from the frontend
$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['userQuery']) || !isset($input['systemPrompt'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$userQuery = $input['userQuery'];
$systemPrompt = $input['systemPrompt'];

// Prepare the payload for Gemini API
$payload = [
    'contents' => [
        [
            'parts' => [['text' => $userQuery]]
        ]
    ],
    'systemInstruction' => [
        'parts' => [['text' => $systemPrompt]]
    ]
];

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=' . $apiKey;

// Use cURL to make the server-to-server request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Important for security
curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Set a 30-second timeout

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($httpcode !== 200) {
    http_response_code(500);
    // Create a user-friendly error message
    $user_error_message = [
        'candidates' => [
            [
                'content' => [
                    'parts' => [
                        [
                            'text' => "# خطای ارتباط\n\nمتاسفانه در حال حاضر امکان برقراری ارتباط با سرویس هوش مصنوعی وجود ندارد.\n\n- **راه حل پیشنهادی:** اگر در ایران هستید، لطفاً از یک ابزار تغییر IP (فیلترشکن) استفاده کرده و مجدداً تلاش نمایید.\n\nاگر مشکل همچنان پابرجا بود، لطفاً با پشتیبانی تماس بگیرید."
                        ]
                    ]
                ]
            ]
        ]
    ];
    echo json_encode($user_error_message);
    exit;
}

// Forward the response back to the frontend
http_response_code($httpcode);
echo $response;

?>

