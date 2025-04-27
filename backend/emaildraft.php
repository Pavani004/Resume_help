<?php
$resume_text = $_POST['resumeText'];
$jd_text = $_POST['jdText'];
$experience = $_POST['experience'];

$huggingface_token = 'YOUR_HUGGINGFACE_TOKEN_HERE';

$prompt = "Draft a professional email applying for a job. Here is the Job Description:\n$jd_text\nMy experience:\n$experience";

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
$emailDraft = $responseData[0]['generated_text'] ?? 'No email draft.';

echo json_encode([
    'emailDraft' => $emailDraft
]);
?>
