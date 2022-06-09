<?php

namespace App\Services\Images;


use Illuminate\Http\UploadedFile;

interface ImageServiceInterface
{
    /**
     * Saves an Image temporary on the provided Disk.
     * @param UploadedFile $file The file which contains the Image.
     * @return false|string false if the saving failed, otherwise it returns an encrypted string containing the file destination
     */
    public function saveImage(UploadedFile $file): false|string;

    /**
     * Deletes a temporary Image on the provided Disk.
     * @param string $filePath The encrypted FilePath to the Files destination.
     * @return bool false if deleting failed without exceptions, true if the files has been successfully deleted.
     */
    public function deleteImage(string $filePath): bool;

    /**
     * Restores Permanent saved Images and returns them.
     * @param string $filePath The filepond id for the image
     * @return string the image.
     */
    public function loadImage(string $filePath): mixed;

    /**
     * Restores Temporary saved Images and returns them.
     * @param string $filePath The filePath to the Image destination
     * @return string The fileName of the Image.
     */
    public function restoreImage(string $filePath): string;
}
