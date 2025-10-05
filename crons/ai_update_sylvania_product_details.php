<?php

$apiKey = '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'; // ← cheia ta OpenAI

$prompt = "Spune-mi un salut random și scurt.";

$data = [
    "model" => "gpt-3.5-turbo", // sau "gpt-3.5-turbo" dacă nu ai acces la gpt-4
    "messages" => [
        ["role" => "user", "content" => $prompt]
    ],
    "temperature" => 0.7
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// ⚠️ Dezactivăm verificarea SSL doar pentru development:
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode === 200) {
    $result = json_decode($response, true);
    echo "✅ Conexiune reușită!\n\n";
    echo "ChatGPT răspunde:\n" . $result['choices'][0]['message']['content'];
} else {
    echo "❌ Eroare la conectare. Cod HTTP: $httpcode\n";
    echo "Răspuns complet:\n$response";
}
