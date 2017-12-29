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
     *
     * @return integer
     */
    public function getSize();

    /**
     * Set governing entity
     *
     * @var $parent object Governing entity
     */
    public function setParent($parent);

    /**
     * Set uploaded file
     *
     * @var $file File Uploaded file
     */
    public function setFile(File $file);

    /**
     * Get file
     *
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function getFile();

    /**
     * Return true if file thumbnail should be generated
     *
     * @return boolean
     */
    public function getPreview();
}
