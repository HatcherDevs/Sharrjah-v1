<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    /**
     * Allowed image extensions
     */
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
    
    /**
     * Allowed MIME types
     */
    private $allowedMimeTypes = [
        'image/jpeg',
        'image/jpg', 
        'image/png',
        'image/gif',
        'image/webp',
        'image/bmp'
    ];

    /**
     * Handle image upload from Froala Editor
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        try {
            // Check if file exists
            if (!$request->hasFile('file')) {
                return response()->json(['error' => 'No file uploaded'], 400);
            }

            $file = $request->file('file');
            
            // Validate file
            $validation = $this->validateImage($file);
            if ($validation !== true) {
                return response()->json(['error' => $validation], 400);
            }

            // Generate unique filename
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = md5(time() . Str::random(10)) . '.' . $extension;
            
            // Define upload path - files are in public/uploads/editor
            $uploadPath = 'public/uploads/editor';
            $fullPath = base_path($uploadPath);
            
            // Create directory if not exists
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            // Move file
            $file->move($fullPath, $filename);
            
            // Return success response for Froala - URL needs public/ prefix
            $imageUrl = url($uploadPath . '/' . $filename);
            
            return response()->json([
                'link' => $imageUrl
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Validate uploaded image
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return bool|string
     */
    private function validateImage($file)
    {
        // Check if file is valid
        if (!$file->isValid()) {
            return 'Invalid file upload';
        }

        // Check extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $this->allowedExtensions)) {
            return 'File extension not allowed. Allowed: ' . implode(', ', $this->allowedExtensions);
        }

        // Check MIME type
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $this->allowedMimeTypes)) {
            return 'File type not allowed. Only images are permitted.';
        }

        // Check file size (max 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file->getSize() > $maxSize) {
            return 'File size exceeds maximum allowed (5MB)';
        }

        // Check for PHP code in file content
        $content = file_get_contents($file->getRealPath());
        $dangerousPatterns = [
            '<?php',
            '<?=',
            '<script',
            'eval(',
            'base64_decode',
            'system(',
            'exec(',
            'shell_exec',
            'passthru'
        ];
        
        foreach ($dangerousPatterns as $pattern) {
            if (stripos($content, $pattern) !== false) {
                return 'File contains potentially dangerous content';
            }
        }

        return true;
    }
}