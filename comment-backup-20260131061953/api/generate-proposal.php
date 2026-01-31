<?php


header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}



$apiKey = getenv('GEMINI_API_KEY'); 
if (!$apiKey) {
    
    
    $apiKey = "AlzaSyCvMs3MYV2-Wk-p_LTQqwO6qTRVkil8Gys"; 
}


$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['userQuery']) || !isset($input['systemPrompt'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$userQuery = $input['userQuery'];
$systemPrompt = $input['systemPrompt'];


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


$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); 
curl_setopt($ch, CURLOPT_TIMEOUT, 30); 

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($httpcode !== 200) {
    http_response_code(500);
    
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


http_response_code($httpcode);
echo $response;

?>


