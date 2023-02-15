<?php
namespace Admingenerator\FormExtensionsBundle\Storage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileStorageInterface
{
    public function storeFiles(array $files): array;

    public function getFile(string $fileId = null): ?UploadedFile;
}
