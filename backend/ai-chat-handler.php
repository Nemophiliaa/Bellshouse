<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$message = $input['message'] ?? '';

if (empty($message)) {
    echo json_encode(['error' => 'Message is required']);
    exit;
}

// Database Connection
include 'connection.php';

// Fetch destinations for context
$query = mysqli_query($conn, "SELECT destinasi.*, kota.kota, provinsi.provinsi FROM destinasi 
                              JOIN kota ON destinasi.id_kota = kota.id 
                              JOIN provinsi ON kota.id_provinsi = provinsi.id");

$destinations = [];
while ($row = mysqli_fetch_assoc($query)) {
    $destinations[] = $row;
}

// Build Context
$context = "Kamu adalah BellsBot, asisten travel virtual untuk BellsHouse Travel yang membantu wisatawan menemukan destinasi wisata di Kalimantan Barat, Indonesia.\n\n";
$context .= "PENTING: Kamu harus selalu ramah, informatif, dan antusias. Gunakan emoji untuk membuat percakapan lebih hidup!\n\n";
$context .= "DATA DESTINASI WISATA YANG TERSEDIA:\n";

foreach ($destinations as $index => $dest) {
    $context .= ($index + 1) . ". " . $dest['nama_destinasi'] . " (ID: " . $dest['id'] . ")\n";
    $context .= "   - Lokasi: " . $dest['kota'] . ", " . $dest['provinsi'] . "\n";
    $context .= "   - Harga: Rp " . number_format($dest['harga'], 0, ',', '.') . " per malam\n\n";
}

$context .= "\nINSTRUKSI:\n";
$context .= "- Jika user bertanya tentang destinasi spesifik, berikan informasi detail dan sertakan ID destinasi dalam format [DEST:ID]\n";
$context .= "- Jika user meminta rekomendasi, sebutkan 2-4 destinasi yang relevan dengan ID-nya\n";
$context .= "- Jika user bertanya tentang harga, bandingkan dan rekomendasikan yang sesuai budget\n";
$context .= "- Selalu berikan respons yang ramah dan helpful\n";
$context .= "- Fokus hanya pada wisata Kalimantan Barat\n\n";

// Gemini API Configuration
$apiKey = 'AIzaSyBYkWzx17wWP5ZpJW6Vt72mqjKUtEbaTNc';
$model = 'gemini-2.0-flash'; 
$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$data = [
    'contents' => [
        [
            'role' => 'user',
            'parts' => [
                ['text' => $context . "User bertanya: \"" . $message . "\"\n\nBerikan respons yang ramah, informatif, dan helpful:"]
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Curl error: ' . curl_error($ch)]);
} else {
    $decoded = json_decode($response, true);
    if ($httpCode !== 200) {
         echo json_encode(['error' => 'API Error', 'details' => $decoded]);
    } else {
        $text = $decoded['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya sedang mengalami gangguan. Silakan coba lagi nanti.';
        echo json_encode(['text' => $text]);
    }
}
curl_close($ch);
?>
