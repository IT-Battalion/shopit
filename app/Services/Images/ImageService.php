<?php

namespace App\Services\Images;


use App\Exceptions\ImageNotDeletedException;
use App\Exceptions\ImageNotSavedException;
use App\Exceptions\InvalidImageFilePathException;
use App\Exceptions\InvalidImageMimeTypeException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\FileNotFoundException;
use function RingCentral\Psr7\mimetype_from_extension;

class ImageService implements ImageServiceInterface
{
    protected function decryptEncryptFilePath(string $filePath, bool $encrypt = true): string
    {
        return $encrypt ? Crypt::encryptString($filePath) : Crypt::decryptString($filePath);
    }

    protected function isImageFromTemporaryPath(string $filePath): bool
    {
        return Str::startsWith($filePath, Storage::disk(config('shop.image.disk', 'local'))->path(config('shop.image.temporaryPath', 'tmp')));
    }

    protected function isImageFromPermanentPath(string $filePath): bool
    {
        return Str::startsWith($filePath, Storage::disk(config('shop.image.disk', 'local'))->path(config('shop.image.permanentPath', 'product')));
    }

    /**
     * @throws ImageNotSavedException
     * @throws InvalidImageMimeTypeException
     */
    public function saveImage(UploadedFile $file): false|string
    {
        if (!in_array(mimetype_from_extension($file->extension()), config('shop.image.allowedMimeTypes', ['image/jpeg', 'image/png']), true)) {
            throw new InvalidImageMimeTypeException();
        }
        $stored = $file->storeAs(config('shop.image.temporaryPath', 'tmp'), now()->timestamp . '_' . $file->getClientOriginalName(), config('shop.image.disk', 'local'));
        if (!$stored) {
            throw new ImageNotSavedException();
        }
        $filePath = Storage::disk(config('shop.image.disk', 'local'))->path($stored);
        return $this->decryptEncryptFilePath($filePath);
    }

    /**
     * @throws InvalidImageFilePathException
     * @throws ImageNotDeletedException
     */
    public function deleteImage(string $filePath): bool
    {
        $stored = $this->decryptEncryptFilePath($filePath, false);
        if (!$this->isImageFromTemporaryPath($stored)) {
            throw new InvalidImageFilePathException();
        }
        if (!Storage::disk(config('shop.image.disk', 'local'))->delete($stored)) {
            throw new ImageNotDeletedException();
        }
        return true;
    }

    /**
     * @throws InvalidImageFilePathException
     * @throws FileNotFoundException
     */
    public function restoreImage(string $filePath): string
    {
        $stored = $this->decryptEncryptFilePath($filePath, false);
        if ($this->isImageFromTemporaryPath($stored)) {
            throw new InvalidImageFilePathException();
        }
        return Storage::disk(config('shop.image.disk', 'local'))->getMetadata($stored)['name'];
    }

    /**
     * @throws FileNotFoundException
     * @throws InvalidImageFilePathException
     */
    public function loadImage(string $filePath): string
    {
        $stored = $this->decryptEncryptFilePath($filePath, false);
        if ($this->isImageFromPermanentPath($stored)) {
            throw new InvalidImageFilePathException();
        }
        return Storage::disk(config('shop.image.disk', 'local'))->getMetadata($stored)['name'];
    }
}
