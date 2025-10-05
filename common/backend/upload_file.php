<?php
require_once('../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";

// creează folderul dacă nu există (optional, dar util)
if (!is_dir($target_dir)) {
    @mkdir($target_dir, 0775, true);
}

// VALIDARE: trebuie să existe input-ul "file"
if (!isset($_FILES['file'])) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status'   => 0,
        'error'    => 'Missing file input "file".',
        'reminder' => 'Ensure your form uses enctype="multipart/form-data" and input name="file".'
    ]);
    exit;
}

// mapare erori PHP upload (ENGLEZĂ)
$uploadErrors = [
    UPLOAD_ERR_OK         => 'OK',
    UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
    UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.',
    UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
    UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder on the server.',
    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
    UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
];

// dacă PHP a raportat o eroare de upload
if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status'   => 0,
        'error'    => $uploadErrors[$_FILES['file']['error']] ?? 'Unknown upload error.',
        'code'     => (int) $_FILES['file']['error'],
        'reminder' => 'If you hit size limits, align Dropzone maxFilesize with server limits: update php.ini (upload_max_filesize, post_max_size) and your web server (Nginx client_max_body_size or Apache LimitRequestBody).',
    ]);
    exit;
}

// securitate: confirmă că fișierul chiar provine dintr-un upload HTTP
if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status'   => 0,
        'error'    => 'Invalid uploaded file (not from HTTP POST).',
        'reminder' => 'Make sure the file is sent via a standard multipart/form-data POST request.',
    ]);
    exit;
}

// nume fișier safe: păstrăm extensia, curățăm numele
$original     = $_FILES['file']['name'] ?? 'upload';
$cleanBase    = preg_replace('/[^A-Za-z0-9._-]/', '-', pathinfo($original, PATHINFO_FILENAME));
$ext          = strtolower(pathinfo($original, PATHINFO_EXTENSION));
$timestamp    = time();
$uploadedName = $cleanBase . ($ext ? '.' . $ext : '');
$filename     = $timestamp . '_' . $uploadedName;

// mută fișierul din /tmp în /uploads
if (move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $filename)) {
    // Păstrăm comportamentul tău inițial: la succes întoarcem DOAR numele fișierului
    // (fără JSON), ca text simplu.
    echo $filename;
    exit;
}

// dacă move_uploaded_file a eșuat:
http_response_code(500);
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'status'   => 0,
    'error'    => 'Failed to move the uploaded file to the uploads directory.',
    'reminder' => 'Check folder permissions for /uploads (web server user must be able to write). Also ensure php.ini limits and Nginx/Apache body size limits are not exceeded.',
]);
