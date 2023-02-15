<?php
namespace Admingenerator\FormExtensionsBundle\Storage;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Store locally asynchronous uploaded files.
 * Take care that this cannot work on a load balanced architecture
 * (You should create your own Adapter and store files on a NAS
 * or equivalent system).
 *
 */
class LocalFileStorage implements FileStorageInterface
{
    private string $temporaryDirectory;

    private SessionInterface $session;

    public function __construct(RequestStack $requestStack, string $tempDir = null)
    {
        $this->session = $requestStack->getSession();
        $this->temporaryDirectory = $tempDir ?: sys_get_temp_dir() . DIRECTORY_SEPARATOR . 's2a' . DIRECTORY_SEPARATOR . 'collectionupload';
    }

    public function storeFiles(array $files): array
    {
        $handledFiles = [];
        $sessionFiles = $this->session->get('s2a_collectionUpload_files', []);

        foreach ($files as $file) {
            $uid = uniqid();
            $uploadedFilename = sha1(uniqid(mt_rand(), true)).'.'.$file->guessExtension();

            $handledFile = new \stdClass();
            $handledFile->uid  = $uid;
            $handledFile->name = $file->getClientOriginalName();
            $handledFile->type = $file->getClientMimeType();
            $handledFile->size = $file->getSize();
            $handledFiles[] = $handledFile;

            $file->move($this->temporaryDirectory, $uploadedFilename);

            $fileDescriptor = clone $handledFile;
            $fileDescriptor->originalName = $fileDescriptor->name;
            $fileDescriptor->name = $uploadedFilename;
            // TODO: should we add a limit to size of files in memory?
            $sessionFiles[$uid] = $fileDescriptor;
        }
        $this->session->set('s2a_collectionUpload_files', $sessionFiles);

        return $handledFiles;
    }

    public function getFile(string $fileId = null): ?UploadedFile
    {
        if (is_null($fileId)) {
            return null;
        }

        $files = $this->session->get('s2a_collectionUpload_files', array());
        if (!array_key_exists($fileId, $files)) {
            return null;
        }

        $fileDescriptor = $files[$fileId];
        $filePath = $this->temporaryDirectory . DIRECTORY_SEPARATOR . $fileDescriptor->name;
        $file = null;
        if (file_exists($filePath)) {
            $file = new UploadedFile(
                $filePath,
                $fileDescriptor->originalName,
                $fileDescriptor->type,
                null,
                true
            );
        }
        unset($files[$fileId]);
        $this->session->set('s2a_collectionUpload_files', $files);

        return $file;
    }

}
