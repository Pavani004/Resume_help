<?php
include('db.php'); // include db connection

$resume_text = $_POST['resumeText'];
$jd_text = $_POST['jdText'];

$huggingface_token = ''; // Your HF Token

// Calculate Score (Real Matching)
$resume_words = array_unique(str_word_count(strtolower($resume_text), 1));
$jd_words = array_unique(str_word_count(strtolower($jd_text), 1));
$matches = array_intersect($jd_words, $resume_words);

$score = 0;
if (count($jd_words) > 0) {
    $score = round((count($matches) / count($jd_words)) * 100, 2);
}

// Get Suggestions from Huggingface
$prompt = "Suggest improvements for this resume:\n$resume_text\nbased on this job description:\n$jd_text";

$api_url = "https://api-inference.huggingface.co/models/bigscience/bloomz-560m";

$headers = [
    "Authorization: Bearer $huggingface_token",
    "Content-Type: application/json"
];

$payload = json_encode(["inputs" => $prompt]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($response, true);
$suggestions = $responseData[0]['generated_text'] ?? 'No suggestions.';

// Save to MySQL
$resumeId = uniqid("resume_");

$stmt = $conn->prepare("INSERT INTO resume_scores (resume_id, score, suggestions) VALUES (?, ?, ?)");
$stmt->bind_param("sds", $resumeId, $score, $suggestions);
$stmt->execute();
$stmt->close();

// Final Output
echo json_encode([
    'resumeId' => $resumeId,
    'score' => $score,
    'matchedKeywords' => array_values($matches),
    'suggestions' => $suggestions
]);
?>
