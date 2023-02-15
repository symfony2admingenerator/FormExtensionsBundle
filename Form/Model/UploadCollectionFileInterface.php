<?php

namespace Admingenerator\FormExtensionsBundle\Form\Model;

use Symfony\Component\HttpFoundation\File\File;

/**
 * Interface for UploadCollectionType files.
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
interface UploadCollectionFileInterface
{
    /**
     * Return file size in bytes
     */
    public function getSize(): int;

    /**
     * Set governing entity
     *
     * @var $parent object Governing entity
     */
    public function setParent(object $parent): void;

    /**
     * Set uploaded file
     *
     * @var $file File Uploaded file
     */
    public function setFile(File $file): void;

    /**
     * Get file
     */
    public function getFile(): File;

    /**
     * Return true if file thumbnail should be generated
     */
    public function getPreview(): bool;
}
