<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * See `Resources/doc/single-upload/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class SingleUploadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $data = array_key_exists('data', $view->vars) ? $view->vars['data'] : null;

        if ($data instanceof UploadedFile && $form->getRoot()->getErrors()) {
        	$view->vars['data'] = $data = null;
        }

        $view->vars = array_replace($view->vars, array(
            'type'  => 'file',
            'value' => '',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $data = array_key_exists('data', $view->vars) ? $view->vars['data'] : null;
        $view->vars['data'] = $this->_is_file($data) ? $data : null;

        $view->vars = array_merge(
            $view->vars,
            array(
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
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
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
        ));

        $resolver->setAllowedValues(array(
            'multipart'   => array(true),
            'novalidate'  => array(true),
            'required'    => array(false),
        ));

        $resolver->setAllowedTypes(array(
            'nameable'          => array('string', 'bool'),
            'deleteable'        => array('string', 'bool'),
            'downloadable'      => array('bool'),
            'maxWidth'          => array('integer'),
            'maxHeight'         => array('integer'),
            'minWidth'          => array('integer'),
            'minHeight'         => array('integer'),
            'previewImages'     => array('bool'),
            'previewAsCanvas'   => array('bool'),
            'previewFilter'     => array('string', 'null'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 's2a_single_upload';
    }

    /**
     * @param $file
     * @return bool
     */
    private function _is_file($file)
    {
        return $file instanceof File && file_exists($file->getPathName()) && !is_dir($file->getPathName());
    }

    /**
     * Private functions
     */
    private function _checkFileType($file)
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

    private function _isAudio($file)
    {
        return (preg_match('/audio\/.*/i', $file->getMimeType()));
    }

    private function _isArchive($file)
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

    private function _isHTML($file)
    {
        return (preg_match('/text\/html/i', $file->getMimeType()));
    }

    private function _isImage($file)
    {
        return (preg_match('/image\/.*/i', $file->getMimeType()));
    }

    private function _isPDFDocument($file)
    {
        return (
            preg_match('/application\/acrobat/i', $file->getMimeType()) ||
            preg_match('/applications?\/.*pdf.*/i', $file->getMimeType()) ||
            preg_match('/text\/.*pdf.*/i', $file->getMimeType())
        );
    }

    private function _isPlainText($file)
    {
        return (preg_match('/text\/plain/i', $file->getMimeType()));
    }

    private function _isPresentation($file)
    {
        return (
            preg_match('/application\/.*ms\-powerpoint.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*officedocument\.presentationml.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*opendocument\.presentation.*/i', $file->getMimeType())
        );
    }

    private function _isSpreadsheet($file)
    {
        return (
            preg_match('/application\/.*ms\-excel.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*officedocument\.spreadsheetml.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*opendocument\.spreadsheet.*/i', $file->getMimeType())
        );
    }

    private function _isTextDocument($file)
    {
        return (
            preg_match('/application\/.*ms\-?word.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*officedocument\.wordprocessingml.*/i', $file->getMimeType()) ||
            preg_match('/application\/.*opendocument\.text.*/i', $file->getMimeType())
        );
    }

    private function _isVideo($file)
    {
        return (preg_match('/video\/.*/i', $file->getMimeType()));
    }
}
