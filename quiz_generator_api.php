<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$notes = trim($input['notes'] ?? '');

if (!$notes) {
    echo json_encode(["error" => "No study notes provided."]);
    exit;
}

$apiKey = "AIzaSyAmpiNC6GB9vwIAP0oz8JS0On8iKETxX8Q"; // ✅ your Gemini key
$model = "gemini-2.5-flash";
$url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey";

$prompt = <<<PROMPT
You are an educational AI for South African learners.

From the notes below, generate 3–5 multiple-choice quiz questions.
Each question should test a key concept from the content.

Notes:
"$notes"

Return ONLY valid JSON structured as:
[
  {
    "question": "Question text",
    "options": ["Option A", "Option B", "Option C", "Option D"],
    "answer": 0
  }
]
PROMPT;

$payload = json_encode(["contents" => [["parts" => [["text" => $prompt]]]]]);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_TIMEOUT => 25,
]);
$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) { echo json_encode(["error" => "cURL error: $error"]); exit; }
if (!$response) { echo json_encode(["error" => "No response from Gemini API."]); exit; }

$data = json_decode($response, true);

$text = '';
if (isset($data['candidates'][0]['content']['parts'])) {
    foreach ($data['candidates'][0]['content']['parts'] as $p) {
        if (isset($p['text'])) $text .= $p['text'] . "\n";
    }
}
if (!$text) {
    echo json_encode(["error" => "Empty AI response. Raw data: " . substr(json_encode($data), 0, 400)]);
    exit;
}

$clean = preg_replace('/^[^{[]+/', '', $text);
$clean = preg_replace('/```(?:json)?|```/', '', $clean);
$clean = trim($clean);

try {
    $parsed = json_decode($clean, true);
    if (!is_array($parsed)) throw new Exception("Invalid JSON format.");

    $questions = [];
    foreach ($parsed as $q) {
        $question = $q['question'] ?? null;
        $options = $q['options'] ?? [];
        $answer = $q['answer'] ?? 0;
        if ($question && count($options) >= 2) {
            $questions[] = ["question" => $question, "options" => array_values($options), "answer" => intval($answer)];
        }
    }

    echo json_encode(["questions" => $questions]);
} catch (Exception $e) {
    echo json_encode(["error" => "Parsing failed: " . substr($text, 0, 300)]);
}
?>
