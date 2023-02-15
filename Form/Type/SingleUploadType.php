<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * See `Resources/doc/single-upload/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class SingleUploadType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $data = array_key_exists('data', $view->vars) ? $view->vars['data'] : null;

        if ($data instanceof UploadedFile && $form->getRoot()->getErrors()) {
        	$view->vars['data'] = $data = null;
        }

        $view->vars = array_replace($view->vars, [
            'type'  => 'file',
            'value' => '',
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        $data = array_key_exists('data', $view->vars) ? $view->vars['data'] : null;
        $view->vars['data'] = $this->_is_file($data) ? $data : null;

        $view->vars = array_merge(
            $view->vars,
            [
                'nameable'        => $options['nameable'],
                'deleteable'      => $options['deleteable'],
                'downloadable'    => $options['downloadable'],
                'minWidth'        => $options['minWidth'],
                'minHeight'       => $options['minHeight'],
                'maxWidth'        => $options['maxWidth'],
                'maxHeight'       => $options['maxHeight'],
                'previewImages'   => $options['previewImages'],
                'previewAsCanvas' => $options['previewAsCanvas'],
                'previewFilter'   => $options['previewFilter'],
                'fileType'        => $this->_checkFileType($view->vars['data']),
                'novalidate'      => $options['novalidate'],
                'multipart'       => $options['multipart'],
                'is_file'         => $this->_is_file($view->vars['data']),
                'required'        => $options['required']
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'nameable'          => false,
            'deleteable'        => false,
            'downloadable'      => true,
            'maxWidth'          => 320,
            'maxHeight'         => 180,
            'minWidth'          => 16,
            'minHeight'         => 16,
            'previewImages'     => true,
            'previewAsCanvas'   => true,
            'previewFilter'     => null,
            'multipart'         => true,
            'novalidate'        => true,
            'required'          => false,
        ]);

        $resolver->setAllowedValues(
            'multipart', [true]
        )->setAllowedValues(
            'novalidate', [true]
        )->setAllowedValues(
            'required', [false]
        );

        $resolver->setAllowedTypes(
            'nameable', ['string', 'bool']
        )->setAllowedTypes(
            'deleteable', ['string', 'bool']
        )->setAllowedTypes(
            'downloadable', ['bool']
        )->setAllowedTypes(
            'maxWidth', ['integer']
        )->setAllowedTypes(
            'maxHeight', ['integer']
        )->setAllowedTypes(
            'minWidth', ['integer']
        )->setAllowedTypes(
            'minHeight', ['integer']
        )->setAllowedTypes(
            'previewImages', ['bool']
        )->setAllowedTypes(
            'previewAsCanvas', ['bool']
        )->setAllowedTypes(
            'previewFilter', ['string', 'null']
        );
    }

    public function getParent(): string
    {
        return FileType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_single_upload';
    }

    private function _is_file(mixed $file): bool
    {
        return $file instanceof File && file_exists($file->getPathName()) && !is_dir($file->getPathName());
    }

    private function _checkFileType(mixed $file): string
    {
        // sanity check
        if (!$this->_is_file($file))        return 'inexistent';
        if ($this->_isAudio($file))         return 'audio';
        if ($this->_isArchive($file))       return 'archive';
        if ($this->_isHTML($file))          return 'html';
        if ($this->_isImage($file))         return 'image';
        if ($this->_isPDFDocument($file))   return 'pdf-document';
        if ($this->_isPlainText($file))     return 'plain-text';
        if ($this->_isPresentation($file))  return 'presentation';
        if ($this->_isSpreadsheet($file))   return 'spreadsheet';
        if ($this->_isTextDocument($file))  return 'text-document';
        if ($this->_isVideo($file))         return 'video';
        // else
        return 'unknown';
    }

    private function _isAudio(File $file): int|false
    {
        return (preg_match('/audio\/.*/i', $file->getMimeType()));
    }

    private function _isArchive(File $file): bool
    {
        return (
            preg_match('/application\/.*compress.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*archive.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*zip.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*tar.*/i', $file->getMimeType()) ||
            preg_match('/application\/x\-ace/i', $file->getMimeType()) ||
            preg_match('/application\/x\-bz2/i', $file->getMimeType()) ||
            preg_match('/gzip\/document/i', $file->getMimeType())
        );
    }

    private function _isHTML(File $file): int|false
    {
        return (preg_match('/text\/html/i', $file->getMimeType()));
    }

    private function _isImage(File $file): int|false
    {
        return (preg_match('/image\/.*/i', $file->getMimeType()));
    }

    private function _isPDFDocument(File $file): bool
    {
        return (
            preg_match('/application\/acrobat/i', $file->getMimeType()) ||
            preg_match('/applications?\/.*pdf.*/i', $file->getMimeType()) ||
            preg_match('/text\/.*pdf.*/i', $file->getMimeType())
        );
    }

    private function _isPlainText(File $file): int|false
    {
        return (preg_match('/text\/plain/i', $file->getMimeType()));
    }

    private function _isPresentation(File $file): bool
    {
        return (
            preg_match('/application\/.*ms\-powerpoint.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*officedocument\.presentationml.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*opendocument\.presentation.*/i', $file->getMimeType())
        );
    }

    private function _isSpreadsheet(File $file): bool
    {
        return (
            preg_match('/application\/.*ms\-excel.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*officedocument\.spreadsheetml.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*opendocument\.spreadsheet.*/i', $file->getMimeType())
        );
    }

    private function _isTextDocument(File $file): bool
    {
        return (
            preg_match('/application\/.*ms\-?word.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*officedocument\.wordprocessingml.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*opendocument\.text.*/i', $file->getMimeType())
        );
    }

    private function _isVideo(File $file): int|false
    {
        return (preg_match('/video\/.*/i', $file->getMimeType()));
    }
}
