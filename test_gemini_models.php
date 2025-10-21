<?php
header('Content-Type: application/json');

// 🧩 Your Gemini API key
$apiKey = "AIzaSyAmpiNC6GB9vwIAP0oz8JS0On8iKETxX8Q";

// ✅ Endpoint to list models
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=$apiKey";

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_TIMEOUT => 30,
]);
$response = curl_exec($ch);
$error = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($error) {
    echo json_encode(["error" => "Curl Error", "details" => $error], JSON_PRETTY_PRINT);
    exit;
}

if (!$response) {
    echo json_encode(["error" => "No response received from Gemini API."], JSON_PRETTY_PRINT);
    exit;
}

// ✅ Decode and show available models
$data = json_decode($response, true);

if (isset($data['models'])) {
    echo json_encode([
        "success" => true,
        "http_code" => $httpCode,
        "available_models" => array_map(fn($m) => $m['name'] ?? "unknown", $data['models'])
    ], JSON_PRETTY_PRINT);
} else {
    echo json_encode([
        "error" => "Failed to retrieve model list.",
        "http_code" => $httpCode,
        "raw_response" => $data
    ], JSON_PRETTY_PRINT);
}
?>
