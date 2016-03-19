<?php
namespace Admingenerator\FormExtensionsBundle\Storage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileStorageInterface
{
    /**
     * @param array $files
     * @return array
     */
    public function storeFiles(array $files);

    /**
     * @param string $fileId
     * @return UploadedFile|null
     */
    public function getFile($fileId = null);
}
