<?php
// includes/upload_helper.php

if (!defined('MAX_IMAGE_SIZE_BYTES')) {
    define('MAX_IMAGE_SIZE_BYTES', 2 * 1024 * 1024); // 2 MB
}

if (!defined('ALLOWED_IMAGE_EXTENSIONS')) {
    define('ALLOWED_IMAGE_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg']);
}

/**
 * Validates an uploaded file for size and extension.
 * 
 * @param array $file The $_FILES['fieldname'] item
 * @param string $maxSizeFormatted Human-friendly max size string (e.g., '2 MB')
 * @param int $maxSizeBytes Maximum allowed size in bytes
 * @param array $allowedExts Array of allowed extension strings (lowercase)
 * @return array ['valid' => bool, 'error' => string|null, 'ext' => string|null]
 */
function validate_uploaded_file($file, $maxSizeFormatted = '2 MB', $maxSizeBytes = MAX_IMAGE_SIZE_BYTES, $allowedExts = ALLOWED_IMAGE_EXTENSIONS) {
    if (!isset($file) || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['valid' => true, 'error' => null, 'ext' => null];
    }

    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE || (isset($file['size']) && $file['size'] > $maxSizeBytes)) {
        $actualSizeStr = isset($file['size']) && $file['size'] > 0 ? ' (' . number_format($file['size'] / (1024 * 1024), 2) . ' MB)' : '';
        return [
            'valid' => false,
            'error' => "File size{$actualSizeStr} exceeds the maximum allowed limit of {$maxSizeFormatted}. Please upload a smaller file.",
            'ext' => null
        ];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [
            'valid' => false,
            'error' => "File upload failed with error code {$file['error']}. Please try uploading again.",
            'ext' => null
        ];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!empty($allowedExts) && !in_array($ext, $allowedExts)) {
        return [
            'valid' => false,
            'error' => "Invalid file extension '.{$ext}'. Allowed formats: " . strtoupper(implode(', ', $allowedExts)) . ".",
            'ext' => $ext
        ];
    }

    return ['valid' => true, 'error' => null, 'ext' => $ext];
}
