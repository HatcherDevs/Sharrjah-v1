<?php namespace App\Services\Uploaders;

use Illuminate\Filesystem\Filesystem as File;
use App\Services\Uploaders\CanUploadImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class Uploader {

    // ===== SECURITY UPDATE: Added FileSecurityValidation trait =====
    // To disable security validation, comment out the line below
    use FileSecurityValidation;
    // ===== END SECURITY UPDATE =====

    /**
     * @var File
     */
    protected $file;

    /**
     * The file or files template to be used for file payload.
     *
     * @var string
     */
    protected $fileTemplate = '';

    /**
     * Create the uploader class.
     *
     * @param Image $image
     * @param File  $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Allow uploading of multiple files.
     *
     * @param  array  $files
     *
     * @return array
     */
    public function uploadMultiple(array $files = array())
    {
        $uploadedFiles = [];

        foreach ($files as $file)
        {
            if ($file) $uploadedFiles[] = $this->upload($file);
        }

        return array_collapse($uploadedFiles);
    }
    
     /**
     * File upload implementation.
     *
     * @param  UploadedFile $file
     *
     * @return mixed
     */
    public function upload(UploadedFile $file)
    {
        // ===== SECURITY UPDATE: Added file security validation =====
        // To disable security validation, comment out the following 3 lines and uncomment the original code below
        // Validate file security before upload
        $fileType = ($this instanceof CanUploadImage && $this->isImage($file)) ? 'image' : 'file';
        $this->validateFileSecurity($file, $fileType);
        // ===== END SECURITY UPDATE =====

        // ===== ORIGINAL CODE (kept for rollback) =====
        // if ($this instanceof CanUploadImage && $this->isImage($file))
        // {
        //     return $this->uploadImage($file);
        // }
        // return $this->uploadFile($file);
        // ===== END ORIGINAL CODE =====

        if ($this instanceof CanUploadImage && $this->isImage($file))
        {
            return $this->uploadImage($file);
        }

        return $this->uploadFile($file);
    }

    /**
     * Upload a file.
     *
     * @param  UploadedFile $file
     *
     * @return array
     */
    protected function uploadFile(UploadedFile $file)
    {
        $path = $this->getRelativePath();
        $uploadPath = $this->getUploadPath($path);

        $fileName = $this->createFileName($file);

        $file->move($uploadPath, $fileName);

        return [$this->createPayload($file->getClientOriginalName(), $fileName, $path, $file->getClientMimeType(), $this->getFileTemplate())];
    }

    /**
     * Create the payload for the file
     *
     * @param  string $original_name
     * @param  string $file_name
     * @param  string $path
     * @param  string $mime_type
     * @param  string $template
     *
     * @return array
     */
    protected function createPayLoad($original_name, $file_name, $path, $mime_type, $template = '')
    {
        return compact('original_name', 'file_name', 'path', 'mime_type', 'template');
    }

    /**
     * Get the absolute path of the target directory.
     *
     * @param  string $relativePath 
     * @param  string $fileName
     *
     * @return string
     */
    protected function getUploadPath($relativePath, $fileName = '')
    {
        $path = public_path($relativePath);

        $this->file->exists($path) or $this->file->makeDirectory($path, 0755, true);

        return "{$path}/{$fileName}";
    }

    /**
     * Get the relative path of the uploads directory.
     *
     * @param  string $path 
     *
     * @return string
     */
    protected function getRelativePath($path = '')
    {
        if ( ! $path && property_exists($this, 'directoryPath'))
        {
            $path = $this->directoryPath;
        }

        return config('paths.uploads') . '/' . $path;
    }

    /**
     * Create an encrypted file name for the upload.
     *
     * @param UploadedFile $file
     * @param string       $path
     * 
     * @return string
     */
    protected function createFileName(UploadedFile $file, $path = '')
    {
        // ===== SECURITY UPDATE: Added extension sanitization =====
        // To disable security checks, uncomment the original code below and comment out the security code
        // Sanitize extension before using it
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Ensure extension is safe
        if (empty($extension) || in_array($extension, $this->dangerousExtensions)) {
            throw new \Exception('Invalid or dangerous file extension');
        }
        
        // Create secure random filename
        $safeExtension = preg_replace('/[^a-z0-9]/', '', $extension);
        return md5($file->getFilename() . time() . mt_rand(1, 10)) . '.' . $safeExtension;
        // ===== END SECURITY UPDATE =====

        // ===== ORIGINAL CODE (kept for rollback) =====
        // return md5($file->getFilename() . time() . mt_rand(1, 10)) . '.' . $file->getClientOriginalExtension();
        // ===== END ORIGINAL CODE =====
    }

    /**
     * File template getter.
     *
     * @return string
     */
    public function getFileTemplate()
    {
        return $this->fileTemplate;
    }

    /**
     * File template setter.
     *
     * @return string
     */
    public function setFileTemplate($template)
    {
        $this->fileTemplate = $template;

        return $this;
    }

}