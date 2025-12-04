<?php namespace App\Services\Uploaders;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Exception;

trait FileSecurityValidation {

    /**
     * Dangerous file extensions that should never be allowed
     *
     * @var array
     */
    protected $dangerousExtensions = [
        'php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phps',
        'js', 'jsp', 'jspx', 'asp', 'aspx', 'ashx', 'asmx',
        'exe', 'bat', 'cmd', 'com', 'pif', 'scr', 'vbs', 'vbe',
        'sh', 'bash', 'csh', 'ksh', 'pl', 'py', 'rb', 'rpm',
        'deb', 'dmg', 'iso', 'bin', 'jar', 'war', 'ear',
        'sql', 'dll', 'so', 'dylib', 'htaccess', 'htpasswd',
        'ini', 'log', 'conf', 'config', 'env'
    ];

    /**
     * Dangerous MIME types that should never be allowed
     *
     * @var array
     */
    protected $dangerousMimeTypes = [
        'application/x-php',
        'application/x-executable',
        'application/x-msdownload',
        'application/x-sh',
        'application/x-shellscript',
        'text/x-php',
        'text/x-shellscript',
        'application/javascript',
        'application/x-javascript',
        'text/javascript',
        'application/x-msdos-program',
        'application/x-ms-wim',
        'application/x-ms-wim',
    ];

    /**
     * Maximum file size in bytes (default: 10MB)
     *
     * @var int
     */
    protected $maxFileSize = 10485760; // 10MB

    /**
     * Allowed MIME types for images
     *
     * @var array
     */
    protected $allowedImageMimeTypes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/bmp',
        'image/webp',
        'image/x-ms-bmp',
    ];

    /**
     * Allowed MIME types for documents
     *
     * @var array
     */
    protected $allowedDocumentMimeTypes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'text/plain',
        'text/csv',
    ];

    /**
     * Validate uploaded file for security
     *
     * @param UploadedFile $file
     * @param string $type 'image' or 'file'
     * @return void
     * @throws Exception
     */
    protected function validateFileSecurity(UploadedFile $file, $type = 'file')
    {
        // 1. Check file size
        $this->validateFileSize($file);

        // 2. Validate file extension
        $this->validateFileExtension($file);

        // 3. Validate MIME type
        $this->validateMimeType($file, $type);

        // 4. Validate actual file content (magic bytes)
        $this->validateFileContent($file, $type);

        // 5. Validate file name for SQL injection and path traversal
        $this->validateFileName($file);

        // 6. Check for double extensions
        $this->validateDoubleExtension($file);

        // 7. Scan file content for malicious patterns
        $this->scanFileContent($file);
    }

    /**
     * Validate file size
     *
     * @param UploadedFile $file
     * @return void
     * @throws Exception
     */
    protected function validateFileSize(UploadedFile $file)
    {
        if ($file->getSize() > $this->maxFileSize) {
            throw new Exception('File size exceeds maximum allowed size of ' . ($this->maxFileSize / 1048576) . 'MB');
        }

        if ($file->getSize() === 0) {
            throw new Exception('File is empty');
        }
    }

    /**
     * Validate file extension
     *
     * @param UploadedFile $file
     * @return void
     * @throws Exception
     */
    protected function validateFileExtension(UploadedFile $file)
    {
        $extension = strtolower($file->getClientOriginalExtension());

        // Check for dangerous extensions
        if (in_array($extension, $this->dangerousExtensions)) {
            throw new Exception('File extension "' . $extension . '" is not allowed for security reasons');
        }

        // Check for empty extension
        if (empty($extension)) {
            throw new Exception('File must have an extension');
        }

        // Check for hidden characters or null bytes
        if (preg_match('/[\x00-\x1F\x7F]/', $extension)) {
            throw new Exception('File extension contains invalid characters');
        }
    }

    /**
     * Validate MIME type
     *
     * @param UploadedFile $file
     * @param string $type
     * @return void
     * @throws Exception
     */
    protected function validateMimeType(UploadedFile $file, $type = 'file')
    {
        $mimeType = $file->getMimeType();
        $clientMimeType = $file->getClientMimeType();

        // Check for dangerous MIME types
        if (in_array($mimeType, $this->dangerousMimeTypes) || 
            in_array($clientMimeType, $this->dangerousMimeTypes)) {
            throw new Exception('File type "' . $mimeType . '" is not allowed for security reasons');
        }

        // Validate MIME type matches expected type
        if ($type === 'image') {
            if (!in_array($mimeType, $this->allowedImageMimeTypes)) {
                throw new Exception('File must be a valid image. Detected MIME type: ' . $mimeType);
            }
        } else {
            // For files, check if it's an image (should use image uploader) or document
            $allowedMimeTypes = array_merge($this->allowedImageMimeTypes, $this->allowedDocumentMimeTypes);
            if (!in_array($mimeType, $allowedMimeTypes)) {
                throw new Exception('File type "' . $mimeType . '" is not allowed');
            }
        }

        // Verify MIME type matches extension
        $this->validateMimeTypeMatchesExtension($file, $mimeType);
    }

    /**
     * Validate that MIME type matches file extension
     *
     * @param UploadedFile $file
     * @param string $mimeType
     * @return void
     * @throws Exception
     */
    protected function validateMimeTypeMatchesExtension(UploadedFile $file, $mimeType)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $expectedMimeTypes = $this->getMimeTypesForExtension($extension);

        if (!empty($expectedMimeTypes) && !in_array($mimeType, $expectedMimeTypes)) {
            throw new Exception('File MIME type "' . $mimeType . '" does not match file extension "' . $extension . '"');
        }
    }

    /**
     * Get expected MIME types for an extension
     *
     * @param string $extension
     * @return array
     */
    protected function getMimeTypesForExtension($extension)
    {
        $mimeMap = [
            'jpg' => ['image/jpeg', 'image/jpg'],
            'jpeg' => ['image/jpeg', 'image/jpg'],
            'png' => ['image/png'],
            'gif' => ['image/gif'],
            'bmp' => ['image/bmp', 'image/x-ms-bmp'],
            'webp' => ['image/webp'],
            'pdf' => ['application/pdf'],
            'doc' => ['application/msword'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'xls' => ['application/vnd.ms-excel'],
            'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
            'ppt' => ['application/vnd.ms-powerpoint'],
            'pptx' => ['application/vnd.openxmlformats-officedocument.presentationml.presentation'],
            'txt' => ['text/plain'],
            'csv' => ['text/csv', 'text/plain'],
        ];

        return isset($mimeMap[$extension]) ? $mimeMap[$extension] : [];
    }

    /**
     * Validate file content using magic bytes
     *
     * @param UploadedFile $file
     * @param string $type
     * @return void
     * @throws Exception
     */
    protected function validateFileContent(UploadedFile $file, $type = 'file')
    {
        $filePath = $file->getRealPath();
        
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new Exception('Cannot read file for content validation');
        }

        // Read first bytes to check magic bytes
        $handle = fopen($filePath, 'rb');
        if (!$handle) {
            throw new Exception('Cannot open file for content validation');
        }

        $firstBytes = fread($handle, 12);
        fclose($handle);

        if ($type === 'image') {
            $this->validateImageMagicBytes($firstBytes, $file);
        }

        // Check for PHP tags or script tags in file content
        $this->checkForScriptTags($filePath, $file);
    }

    /**
     * Validate image magic bytes
     *
     * @param string $firstBytes
     * @param UploadedFile $file
     * @return void
     * @throws Exception
     */
    protected function validateImageMagicBytes($firstBytes, UploadedFile $file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $isValidImage = false;

        // JPEG: FF D8 FF
        if (substr($firstBytes, 0, 3) === "\xFF\xD8\xFF" && in_array($extension, ['jpg', 'jpeg'])) {
            $isValidImage = true;
        }
        // PNG: 89 50 4E 47
        elseif (substr($firstBytes, 0, 4) === "\x89\x50\x4E\x47" && $extension === 'png') {
            $isValidImage = true;
        }
        // GIF: 47 49 46 38
        elseif (substr($firstBytes, 0, 4) === "GIF8" && $extension === 'gif') {
            $isValidImage = true;
        }
        // BMP: 42 4D
        elseif (substr($firstBytes, 0, 2) === "BM" && $extension === 'bmp') {
            $isValidImage = true;
        }
        // WebP: RIFF...WEBP
        elseif (substr($firstBytes, 0, 4) === "RIFF" && substr($firstBytes, 8, 4) === "WEBP" && $extension === 'webp') {
            $isValidImage = true;
        }

        if (!$isValidImage) {
            throw new Exception('File content does not match the declared image type. File may be corrupted or malicious.');
        }
    }

    /**
     * Check for script tags in file content
     *
     * @param string $filePath
     * @param UploadedFile $file
     * @return void
     * @throws Exception
     */
    protected function checkForScriptTags($filePath, UploadedFile $file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Only check text-based files
        $textExtensions = ['txt', 'csv', 'html', 'htm', 'xml', 'json'];
        
        // For images, check if they contain PHP/script tags (image polyglot attack)
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $content = file_get_contents($filePath);
            
            // Check for PHP tags
            if (preg_match('/<\?php/i', $content) || 
                preg_match('/<\?=/i', $content) ||
                preg_match('/<script/i', $content)) {
                throw new Exception('File contains potentially malicious script tags');
            }
        }
    }

    /**
     * Validate file name for SQL injection and path traversal
     *
     * @param UploadedFile $file
     * @return void
     * @throws Exception
     */
    protected function validateFileName(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        // Check for path traversal
        if (strpos($fileName, '..') !== false || 
            strpos($fileName, '/') !== false || 
            strpos($fileName, '\\') !== false) {
            throw new Exception('File name contains invalid characters (path traversal attempt detected)');
        }

        // Check for SQL injection patterns
        $sqlPatterns = [
            '/(\bUNION\b.*\bSELECT\b)/i',
            '/(\bSELECT\b.*\bFROM\b)/i',
            '/(\bINSERT\b.*\bINTO\b)/i',
            '/(\bUPDATE\b.*\bSET\b)/i',
            '/(\bDELETE\b.*\bFROM\b)/i',
            '/(\bDROP\b.*\bTABLE\b)/i',
            '/(\bEXEC\b|\bEXECUTE\b)/i',
            '/(\bSCRIPT\b)/i',
            '/(\bJAVASCRIPT\b)/i',
            '/(\bVBSCRIPT\b)/i',
            '/(\bONLOAD\b|\bONERROR\b)/i',
        ];

        foreach ($sqlPatterns as $pattern) {
            if (preg_match($pattern, $fileName)) {
                throw new Exception('File name contains potentially malicious content');
            }
        }

        // Check for null bytes
        if (strpos($fileName, "\0") !== false) {
            throw new Exception('File name contains null bytes');
        }

        // Check for control characters
        if (preg_match('/[\x00-\x1F\x7F]/', $fileName)) {
            throw new Exception('File name contains invalid control characters');
        }
    }

    /**
     * Validate for double extensions (e.g., file.php.jpg)
     *
     * @param UploadedFile $file
     * @return void
     * @throws Exception
     */
    protected function validateDoubleExtension(UploadedFile $file)
    {
        $fileName = strtolower($file->getClientOriginalName());
        $parts = explode('.', $fileName);

        if (count($parts) > 2) {
            // Check if any part before the last is a dangerous extension
            for ($i = 0; $i < count($parts) - 1; $i++) {
                if (in_array($parts[$i], $this->dangerousExtensions)) {
                    throw new Exception('File name contains suspicious double extension pattern');
                }
            }
        }
    }

    /**
     * Scan file content for malicious patterns
     *
     * @param UploadedFile $file
     * @return void
     * @throws Exception
     */
    protected function scanFileContent(UploadedFile $file)
    {
        $filePath = $file->getRealPath();
        $extension = strtolower($file->getClientOriginalExtension());

        // For non-image files, scan content
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
            $content = file_get_contents($filePath);
            
            // Check for PHP code
            if (preg_match('/<\?php/i', $content) || 
                preg_match('/<\?=/i', $content) ||
                preg_match('/<script[^>]*>/i', $content)) {
                throw new Exception('File content contains potentially malicious code');
            }

            // Check for eval, base64_decode, system, exec, shell_exec
            $dangerousFunctions = [
                '/\beval\s*\(/i',
                '/\bexec\s*\(/i',
                '/\bsystem\s*\(/i',
                '/\bshell_exec\s*\(/i',
                '/\bpassthru\s*\(/i',
                '/\bproc_open\s*\(/i',
                '/\bpopen\s*\(/i',
                '/\bbase64_decode\s*\(/i',
                '/\bassert\s*\(/i',
                '/\bcreate_function\s*\(/i',
            ];

            foreach ($dangerousFunctions as $pattern) {
                if (preg_match($pattern, $content)) {
                    throw new Exception('File content contains potentially dangerous code');
                }
            }
        }
    }

    /**
     * Sanitize file name to prevent security issues
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function sanitizeFileName(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        // Remove path components
        $fileName = basename($fileName);

        // Remove dangerous characters
        $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);

        // Remove multiple dots
        $fileName = preg_replace('/\.{2,}/', '.', $fileName);

        // Ensure extension is preserved
        if (!empty($extension)) {
            $baseName = pathinfo($fileName, PATHINFO_FILENAME);
            if (empty($baseName)) {
                $baseName = 'file';
            }
            $fileName = $baseName . '.' . $extension;
        }

        // Limit length
        if (strlen($fileName) > 255) {
            $fileName = substr($fileName, 0, 255 - strlen($extension) - 1) . '.' . $extension;
        }

        return $fileName;
    }
}

