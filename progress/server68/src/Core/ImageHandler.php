<?php
/**
 * Scanbox.ro - Gestionarea imaginilor
 *
 * Proceseaza incarcarea imaginilor: validare, redimensionare, generare
 * thumbnailuri si conversie WebP. Suporta formatele JPEG, PNG, WebP si GIF.
 * Dimensiune maxima: 5 MB.
 *
 * @package Scanbox\Core
 * @version 1.0.0
 */

declare(strict_types=1);

namespace Scanbox\Core;

class ImageHandler
{
    /** @var int Latimea maxima pentru imaginile redimensionate */
    private int $maxWidth;

    /** @var int Inaltimea maxima pentru imaginile redimensionate */
    private int $maxHeight;

    /** @var int Latimea thumbnailurilor */
    private int $thumbWidth;

    /** @var int Inaltimea thumbnailurilor */
    private int $thumbHeight;

    /** @var int Dimensiunea maxima a fisierului in bytes */
    private int $maxFileSize;

    /** @var array Tipurile MIME permise */
    private array $allowedMimes;

    /** @var int Calitatea JPEG/WebP (0-100) */
    private int $quality = 85;

    /**
     * Constructor - initializeaza configurarile din constante
     */
    public function __construct()
    {
        $this->maxWidth = defined('IMAGE_MAX_WIDTH') ? IMAGE_MAX_WIDTH : 1920;
        $this->maxHeight = defined('IMAGE_MAX_HEIGHT') ? IMAGE_MAX_HEIGHT : 1080;
        $this->thumbWidth = defined('THUMBNAIL_WIDTH') ? THUMBNAIL_WIDTH : 400;
        $this->thumbHeight = defined('THUMBNAIL_HEIGHT') ? THUMBNAIL_HEIGHT : 300;
        $this->maxFileSize = defined('MAX_IMAGE_SIZE') ? MAX_IMAGE_SIZE : 5 * 1024 * 1024;

        $this->allowedMimes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/gif',
        ];
    }

    /**
     * Incarca si proceseaza o imagine
     *
     * Valideaza fisierul, genereaza un nume unic bazat pe hash,
     * il muta in directorul destinatie, il redimensioneaza daca e necesar
     * si genereaza un thumbnail.
     *
     * @param array $file Array-ul $_FILES pentru fisierul incarcat
     * @param string $subDir Subdirectorul din uploads/ (ex: 'blog', 'portfolio')
     * @param bool $generateThumb Daca sa genereze thumbnail
     * @return array|false Informatii despre fisier sau false in caz de eroare
     */
    public function upload(array $file, string $subDir = '', bool $generateThumb = true): array|false
    {
        /** Validam fisierul */
        $validation = $this->validate($file);
        if ($validation !== true) {
            return false;
        }

        /** Generam un nume unic bazat pe hash-ul continutului */
        $extension = $this->getExtension($file['name']);
        $hashName = $this->generateHashName($file['tmp_name'], $extension);

        /** Construim calea destinatie */
        $uploadDir = rtrim(UPLOADS_PATH, '/') . '/';
        if (!empty($subDir)) {
            $uploadDir .= rtrim($subDir, '/') . '/';
        }

        /** Cream directorul daca nu exista */
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destPath = $uploadDir . $hashName;

        /** Mutam fisierul incarcat */
        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            error_log(sprintf(
                '[%s] Eroare la mutarea fisierului incarcat: %s -> %s',
                date('Y-m-d H:i:s'),
                $file['tmp_name'],
                $destPath
            ));
            return false;
        }

        /** Setam permisiunile corecte */
        chmod($destPath, 0644);

        /** Redimensionam daca imaginea depaseste dimensiunile maxime */
        $this->resize($destPath);

        /** Construim calea relativa pentru baza de date */
        $relativePath = (!empty($subDir) ? $subDir . '/' : '') . $hashName;

        $result = [
            'file_name'     => $hashName,
            'original_name' => $file['name'],
            'file_path'     => $relativePath,
            'full_path'     => $destPath,
            'mime_type'     => $file['type'],
            'file_size'     => filesize($destPath),
        ];

        /** Generam thumbnail daca este cerut */
        if ($generateThumb) {
            $thumbDir = $uploadDir . 'thumbs/';
            if (!is_dir($thumbDir)) {
                mkdir($thumbDir, 0755, true);
            }

            $thumbPath = $thumbDir . $hashName;
            if ($this->thumbnail($destPath, $thumbPath)) {
                $result['thumbnail_path'] = (!empty($subDir) ? $subDir . '/' : '') . 'thumbs/' . $hashName;
            }
        }

        /** Convertim in WebP daca GD este disponibil si formatul sursa nu e deja WebP */
        if ($extension !== 'webp' && function_exists('imagewebp')) {
            $webpName = pathinfo($hashName, PATHINFO_FILENAME) . '.webp';
            $webpPath = $uploadDir . $webpName;

            if ($this->convertToWebP($destPath, $webpPath)) {
                $result['webp_path'] = (!empty($subDir) ? $subDir . '/' : '') . $webpName;
            }
        }

        return $result;
    }

    /**
     * Valideaza un fisier imagine incarcat
     *
     * Verifica: erori de incarcare, dimensiune maxima, tip MIME,
     * si ca fisierul este o imagine reala.
     *
     * @param array $file Array-ul $_FILES pentru fisier
     * @return bool|string True daca e valid, mesaj de eroare altfel
     */
    public function validate(array $file): bool|string
    {
        /** Verificam erori de incarcare */
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE   => 'Fisierul depaseste dimensiunea maxima permisa de server.',
                UPLOAD_ERR_FORM_SIZE  => 'Fisierul depaseste dimensiunea maxima permisa de formular.',
                UPLOAD_ERR_PARTIAL    => 'Fisierul a fost incarcat doar partial.',
                UPLOAD_ERR_NO_FILE    => 'Niciun fisier nu a fost incarcat.',
                UPLOAD_ERR_NO_TMP_DIR => 'Directorul temporar lipseste.',
                UPLOAD_ERR_CANT_WRITE => 'Nu s-a putut scrie fisierul pe disc.',
                UPLOAD_ERR_EXTENSION  => 'O extensie PHP a oprit incarcarea.',
            ];

            $errorCode = $file['error'] ?? -1;
            return $errorMessages[$errorCode] ?? 'Eroare necunoscuta la incarcarea fisierului.';
        }

        /** Verificam dimensiunea fisierului */
        if ($file['size'] > $this->maxFileSize) {
            $maxMb = round($this->maxFileSize / (1024 * 1024), 1);
            return sprintf('Fisierul depaseste dimensiunea maxima de %s MB.', $maxMb);
        }

        /** Verificam tipul MIME */
        if (!in_array($file['type'], $this->allowedMimes, true)) {
            return 'Tipul fisierului nu este permis. Formate acceptate: JPEG, PNG, WebP, GIF.';
        }

        /** Verificam ca fisierul este o imagine reala */
        $imageInfo = @getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            return 'Fisierul nu este o imagine valida.';
        }

        /** Verificam tipul MIME real al imaginii */
        if (!in_array($imageInfo['mime'], $this->allowedMimes, true)) {
            return 'Tipul real al imaginii nu corespunde cu extensia fisierului.';
        }

        return true;
    }

    /**
     * Redimensioneaza o imagine la dimensiunile maxime
     *
     * Pastreaza proportiile originale. Daca imaginea este deja
     * mai mica decat dimensiunile maxime, nu o modifica.
     *
     * @param string $filePath Calea catre imaginea de redimensionat
     * @param int|null $maxWidth Latimea maxima (default: din constante)
     * @param int|null $maxHeight Inaltimea maxima (default: din constante)
     * @return bool True daca redimensionarea a reusit sau nu a fost necesara
     */
    public function resize(string $filePath, ?int $maxWidth = null, ?int $maxHeight = null): bool
    {
        $maxWidth = $maxWidth ?? $this->maxWidth;
        $maxHeight = $maxHeight ?? $this->maxHeight;

        $imageInfo = @getimagesize($filePath);
        if ($imageInfo === false) {
            return false;
        }

        [$origWidth, $origHeight] = $imageInfo;
        $mime = $imageInfo['mime'];

        /** Daca imaginea este deja in dimensiunile permise, nu facem nimic */
        if ($origWidth <= $maxWidth && $origHeight <= $maxHeight) {
            return true;
        }

        /** Calculam noile dimensiuni pastrand proportiile */
        $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);
        $newWidth = (int) round($origWidth * $ratio);
        $newHeight = (int) round($origHeight * $ratio);

        /** Cream imaginea sursa */
        $sourceImage = $this->createImageFromFile($filePath, $mime);
        if ($sourceImage === false) {
            return false;
        }

        /** Cream imaginea destinatie */
        $destImage = imagecreatetruecolor($newWidth, $newHeight);
        if ($destImage === false) {
            imagedestroy($sourceImage);
            return false;
        }

        /** Pastram transparenta pentru PNG si WebP */
        if ($mime === 'image/png' || $mime === 'image/webp') {
            imagealphablending($destImage, false);
            imagesavealpha($destImage, true);
            $transparent = imagecolorallocatealpha($destImage, 0, 0, 0, 127);
            imagefill($destImage, 0, 0, $transparent);
        }

        /** Redimensionam cu resampling de calitate */
        imagecopyresampled($destImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        /** Salvam imaginea redimensionata */
        $result = $this->saveImage($destImage, $filePath, $mime);

        /** Eliberam memoria */
        imagedestroy($sourceImage);
        imagedestroy($destImage);

        return $result;
    }

    /**
     * Genereaza un thumbnail crop centrat
     *
     * Creeaza un thumbnail cu dimensiunile specificate, taiat din centrul
     * imaginii originale pentru a pastra cea mai importanta parte.
     *
     * @param string $sourcePath Calea catre imaginea sursa
     * @param string $destPath Calea unde se salveaza thumbnail-ul
     * @param int|null $width Latimea thumbnail-ului (default: din constante)
     * @param int|null $height Inaltimea thumbnail-ului (default: din constante)
     * @return bool True daca generarea a reusit
     */
    public function thumbnail(string $sourcePath, string $destPath, ?int $width = null, ?int $height = null): bool
    {
        $width = $width ?? $this->thumbWidth;
        $height = $height ?? $this->thumbHeight;

        $imageInfo = @getimagesize($sourcePath);
        if ($imageInfo === false) {
            return false;
        }

        [$origWidth, $origHeight] = $imageInfo;
        $mime = $imageInfo['mime'];

        /** Calculam zona de crop centrata */
        $srcRatio = $origWidth / $origHeight;
        $dstRatio = $width / $height;

        if ($srcRatio > $dstRatio) {
            /** Imaginea originala e mai lata - cropam pe latime */
            $cropHeight = $origHeight;
            $cropWidth = (int) round($origHeight * $dstRatio);
            $cropX = (int) round(($origWidth - $cropWidth) / 2);
            $cropY = 0;
        } else {
            /** Imaginea originala e mai inalta - cropam pe inaltime */
            $cropWidth = $origWidth;
            $cropHeight = (int) round($origWidth / $dstRatio);
            $cropX = 0;
            $cropY = (int) round(($origHeight - $cropHeight) / 2);
        }

        /** Cream imaginea sursa */
        $sourceImage = $this->createImageFromFile($sourcePath, $mime);
        if ($sourceImage === false) {
            return false;
        }

        /** Cream imaginea thumbnail */
        $thumbImage = imagecreatetruecolor($width, $height);
        if ($thumbImage === false) {
            imagedestroy($sourceImage);
            return false;
        }

        /** Pastram transparenta */
        if ($mime === 'image/png' || $mime === 'image/webp') {
            imagealphablending($thumbImage, false);
            imagesavealpha($thumbImage, true);
            $transparent = imagecolorallocatealpha($thumbImage, 0, 0, 0, 127);
            imagefill($thumbImage, 0, 0, $transparent);
        }

        /** Copiem si redimensionam din zona cropata */
        imagecopyresampled(
            $thumbImage,
            $sourceImage,
            0,
            0,
            $cropX,
            $cropY,
            $width,
            $height,
            $cropWidth,
            $cropHeight
        );

        /** Salvam thumbnail-ul */
        $result = $this->saveImage($thumbImage, $destPath, $mime);

        /** Eliberam memoria */
        imagedestroy($sourceImage);
        imagedestroy($thumbImage);

        return $result;
    }

    /**
     * Converteste o imagine in format WebP
     *
     * Foloseste extensia GD pentru conversie. Daca GD nu suporta WebP,
     * returneaza false fara a genera eroare.
     *
     * @param string $sourcePath Calea catre imaginea sursa
     * @param string $destPath Calea unde se salveaza fisierul WebP
     * @param int $quality Calitatea WebP (0-100, default 85)
     * @return bool True daca conversia a reusit
     */
    public function convertToWebP(string $sourcePath, string $destPath, int $quality = 85): bool
    {
        if (!function_exists('imagewebp')) {
            return false;
        }

        $imageInfo = @getimagesize($sourcePath);
        if ($imageInfo === false) {
            return false;
        }

        $mime = $imageInfo['mime'];

        $sourceImage = $this->createImageFromFile($sourcePath, $mime);
        if ($sourceImage === false) {
            return false;
        }

        /** Pastram transparenta */
        imagealphablending($sourceImage, true);
        imagesavealpha($sourceImage, true);

        $result = imagewebp($sourceImage, $destPath, $quality);
        imagedestroy($sourceImage);

        if ($result) {
            chmod($destPath, 0644);
        }

        return $result;
    }

    /**
     * Sterge o imagine si fisierele asociate (thumbnail, WebP)
     *
     * @param string $filePath Calea relativa a fisierului (din uploads/)
     * @return bool True daca stergerea a reusit
     */
    public function delete(string $filePath): bool
    {
        $fullPath = rtrim(UPLOADS_PATH, '/') . '/' . $filePath;

        $success = true;

        /** Stergem fisierul principal */
        if (file_exists($fullPath)) {
            $success = unlink($fullPath);
        }

        /** Stergem thumbnail-ul */
        $dir = dirname($fullPath);
        $filename = basename($fullPath);
        $thumbPath = $dir . '/thumbs/' . $filename;
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }

        /** Stergem varianta WebP */
        $webpPath = $dir . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp';
        if (file_exists($webpPath)) {
            unlink($webpPath);
        }

        return $success;
    }

    /**
     * Creeaza o resursa imagine GD din fisier
     *
     * @param string $filePath Calea catre fisier
     * @param string $mime Tipul MIME al imaginii
     * @return \GdImage|false Resursa imagine GD sau false
     */
    private function createImageFromFile(string $filePath, string $mime): \GdImage|false
    {
        return match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($filePath),
            'image/png'  => imagecreatefrompng($filePath),
            'image/webp' => imagecreatefromwebp($filePath),
            'image/gif'  => imagecreatefromgif($filePath),
            default      => false,
        };
    }

    /**
     * Salveaza o resursa imagine GD in fisier
     *
     * @param \GdImage $image Resursa imagine GD
     * @param string $filePath Calea de salvare
     * @param string $mime Tipul MIME dorit
     * @return bool True daca salvarea a reusit
     */
    private function saveImage(\GdImage $image, string $filePath, string $mime): bool
    {
        $result = match ($mime) {
            'image/jpeg' => imagejpeg($image, $filePath, $this->quality),
            'image/png'  => imagepng($image, $filePath, 6),
            'image/webp' => imagewebp($image, $filePath, $this->quality),
            'image/gif'  => imagegif($image, $filePath),
            default      => false,
        };

        if ($result) {
            chmod($filePath, 0644);
        }

        return $result;
    }

    /**
     * Genereaza un nume de fisier unic bazat pe hash-ul continutului
     *
     * Combina hash-ul SHA-256 al fisierului cu un timestamp si
     * un string aleator pentru unicitate garantata.
     *
     * @param string $filePath Calea catre fisierul temporar
     * @param string $extension Extensia fisierului
     * @return string Numele unic al fisierului
     */
    private function generateHashName(string $filePath, string $extension): string
    {
        $hash = hash_file('sha256', $filePath);
        $uniquePart = substr($hash, 0, 16) . '_' . time() . '_' . bin2hex(random_bytes(4));
        return $uniquePart . '.' . $extension;
    }

    /**
     * Extrage extensia din numele fisierului
     *
     * @param string $fileName Numele fisierului
     * @return string Extensia in litere mici
     */
    private function getExtension(string $fileName): string
    {
        return strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    }
}
