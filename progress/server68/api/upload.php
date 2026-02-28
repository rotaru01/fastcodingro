<?php
/**
 * API: Upload imagine
 * POST /api/upload
 *
 * Parametri:
 *   - file: fișier imagine (multipart)
 *   - gallery_id: (opțional) ID-ul galeriei
 *   - type: (opțional) tipul de upload (blog, portfolio, gallery, testimonials, clients, settings)
 *
 * Returnează JSON cu informații despre fișierul încărcat
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

// Verificare autentificare
session_start();
if (empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Autentificare necesară.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Verificare metodă
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Metoda nu este permisă.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Verificare existență fișier
if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE   => 'Fișierul depășește dimensiunea maximă permisă de server.',
        UPLOAD_ERR_FORM_SIZE  => 'Fișierul depășește dimensiunea maximă permisă.',
        UPLOAD_ERR_PARTIAL    => 'Fișierul a fost încărcat parțial.',
        UPLOAD_ERR_NO_FILE    => 'Niciun fișier selectat.',
        UPLOAD_ERR_NO_TMP_DIR => 'Director temporar lipsă.',
        UPLOAD_ERR_CANT_WRITE => 'Eroare la scrierea fișierului.',
    ];

    $errorCode = $_FILES['file']['error'] ?? UPLOAD_ERR_NO_FILE;
    $errorMsg = $errorMessages[$errorCode] ?? 'Eroare necunoscută la încărcarea fișierului.';

    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $errorMsg,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$file = $_FILES['file'];
$type = $_POST['type'] ?? 'gallery';

// Validare tip fișier
$allowedMimes = [
    'image/jpeg',
    'image/png',
    'image/webp',
    'image/gif',
];

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedMimes, true)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Tip de fișier neacceptat. Sunt permise: JPG, PNG, WebP, GIF.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validare dimensiune (max 5 MB)
$maxSize = defined('MAX_IMAGE_SIZE') ? MAX_IMAGE_SIZE : 5 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Fișierul depășește dimensiunea maximă de ' . round($maxSize / 1024 / 1024) . ' MB.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Determinare director upload
$uploadDirs = [
    'blog'         => 'blog/',
    'portfolio'    => 'portfolio/',
    'gallery'      => 'gallery/',
    'testimonials' => 'testimonials/',
    'clients'      => 'clients/',
    'settings'     => 'settings/',
];

$subDir = $uploadDirs[$type] ?? 'gallery/';
$uploadsBase = defined('UPLOADS_PATH') ? UPLOADS_PATH : __DIR__ . '/../public/uploads/';
$uploadDir = $uploadsBase . $subDir;

// Creare director dacă nu există
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Nu s-a putut crea directorul de upload.',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

// Generare nume unic
$extension = match ($mimeType) {
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
    'image/gif'  => 'gif',
    default      => 'jpg',
};

$filename = date('Y-m-d') . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
$filepath = $uploadDir . $filename;

// Mutare fișier
if (!move_uploaded_file($file['tmp_name'], $filepath)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Eroare la salvarea fișierului.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Creare thumbnail
$thumbFilename = 'thumb_' . $filename;
$thumbPath = $uploadDir . $thumbFilename;
$thumbnailCreated = false;

try {
    $imageInfo = getimagesize($filepath);
    if ($imageInfo !== false) {
        $origWidth = $imageInfo[0];
        $origHeight = $imageInfo[1];
        $thumbWidth = defined('THUMBNAIL_WIDTH') ? THUMBNAIL_WIDTH : 400;
        $thumbHeight = defined('THUMBNAIL_HEIGHT') ? THUMBNAIL_HEIGHT : 300;

        // Calculare dimensiuni thumbnail păstrând proporțiile
        $ratio = min($thumbWidth / $origWidth, $thumbHeight / $origHeight);
        $newWidth = (int) round($origWidth * $ratio);
        $newHeight = (int) round($origHeight * $ratio);

        $source = match ($mimeType) {
            'image/jpeg' => imagecreatefromjpeg($filepath),
            'image/png'  => imagecreatefrompng($filepath),
            'image/webp' => imagecreatefromwebp($filepath),
            'image/gif'  => imagecreatefromgif($filepath),
            default      => false,
        };

        if ($source !== false) {
            $thumb = imagecreatetruecolor($newWidth, $newHeight);

            // Păstrare transparență pentru PNG și WebP
            if (in_array($mimeType, ['image/png', 'image/webp'])) {
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
            }

            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

            match ($mimeType) {
                'image/jpeg' => imagejpeg($thumb, $thumbPath, 85),
                'image/png'  => imagepng($thumb, $thumbPath, 8),
                'image/webp' => imagewebp($thumb, $thumbPath, 85),
                'image/gif'  => imagegif($thumb, $thumbPath),
                default      => false,
            };

            imagedestroy($source);
            imagedestroy($thumb);
            $thumbnailCreated = true;
        }
    }
} catch (\Throwable $e) {
    error_log('Eroare creare thumbnail: ' . $e->getMessage());
}

// Construire URL-uri
$uploadsUrl = defined('UPLOADS_URL') ? UPLOADS_URL : '/uploads/';
$fullUrl = $uploadsUrl . $subDir . $filename;
$thumbUrl = $thumbnailCreated ? $uploadsUrl . $subDir . $thumbFilename : $fullUrl;

// Salvare în baza de date dacă este pentru o galerie
$imageId = null;
if (!empty($_POST['gallery_id'])) {
    try {
        require_once __DIR__ . '/../config/config.php';
        require_once __DIR__ . '/../config/constants.php';
        require_once __DIR__ . '/../src/Core/Database.php';
        require_once __DIR__ . '/../src/Models/GalleryItem.php';

        $galleryItemModel = new \Scanbox\Models\GalleryItem();
        $imageId = $galleryItemModel->create([
            'gallery_id'        => (int) $_POST['gallery_id'],
            'type'              => 'image',
            'file_path'         => $fullUrl,
            'thumbnail'         => $thumbUrl,
            'original_filename' => $file['name'],
            'alt_text'          => $_POST['alt_text'] ?? '',
            'title'             => $_POST['title'] ?? '',
            'sort_order'        => 999,
            'is_active'         => 1,
        ]);
    } catch (\Throwable $e) {
        error_log('Eroare salvare în baza de date: ' . $e->getMessage());
    }
}

echo json_encode([
    'success' => true,
    'data' => [
        'id'        => $imageId,
        'filename'  => $filename,
        'thumbnail' => $thumbUrl,
        'full'      => $fullUrl,
        'size'      => $file['size'],
        'mime_type' => $mimeType,
    ],
], JSON_UNESCAPED_UNICODE);
