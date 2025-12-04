<?php namespace App\Services\Uploaders;

use Intervention\Image\ImageManager as Image;
use Illuminate\Filesystem\Filesystem as File;

class MaterialImagesUploader extends Uploader implements CanUploadImage {

    use UploadsImage;

    /**
     * @var File
     */
    protected $file;

    /**
     * The target directory of the upload file.
     *
     * @var string
     */
    protected $directoryPath = 'uploads/materials';

    /**
     * Create the uploader class.
     *
     * @param Image $image
     * @param File  $file
     */
    public function __construct(Image $image,  File $file)
    {
        $this->image = $image;
        $this->file = $file;
    }

    /**
     * Get the templates to be used when uploading an image.
     *
     * @return array
     */
    protected function getImageTemplates()
    {
        return [
            [
                'name' => 'square',
                'path' => $this->directoryPath . '/images',
                'width' => 1000,
                'height' => 1000,
            ]
        ];
    }
}