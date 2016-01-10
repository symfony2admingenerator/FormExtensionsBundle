<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Admingenerator\FormExtensionsBundle\Form\EventListener\UploadCollectionSubscriber;
use Admingenerator\FormExtensionsBundle\Storage\FileStorageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * See `Resources/doc/collection-upload/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */
class UploadCollectionType extends AbstractType
{
    /**
     * @var FileStorageInterface
     */
    protected $storage = null;

    /**
     * @param FileStorageInterface $storage
     */
    public function setFileStorage(FileStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new UploadCollectionSubscriber(
            $builder->getName(),
            $options,
            $this->storage
        ));

        if (!$builder->hasAttribute('prototype')) {
            $prototype = $builder->create($options['prototype_name'], $options['type'], array_replace(array(
                'label' => $options['prototype_name'].'label__',
            ), $options['options']));
            $builder->setAttribute('prototype', $prototype->getForm());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge(
            $view->vars,
            array(
                'acceptFileTypes'           => $options['acceptFileTypes'],
                'autoUpload'                => $options['autoUpload'],
                'editable'                  => $options['editable'],
                'displayDownloadButton'     => $options['displayDownloadButton'],
                'loadImageFileTypes'        => $options['loadImageFileTypes'],
                'loadImageMaxFileSize'      => $options['loadImageMaxFileSize'],
                'maxNumberOfFiles'          => $options['maxNumberOfFiles'],
                'maxFileSize'               => $options['maxFileSize'],
                'minFileSize'               => $options['minFileSize'],
                'multipart'                 => $options['multipart'],
                'multiple'                  => $options['multiple'],
                'nameable'                  => $options['nameable'],
                'nameable_field'            => $options['nameable_field'],
                'novalidate'                => $options['novalidate'],
                'prependFiles'              => $options['prependFiles'],
                'previewFilter'             => $options['previewFilter'],
                'itemFilter'                => $options['itemFilter'],
                'previewAsCanvas'           => $options['previewAsCanvas'],
                'previewMaxHeight'          => $options['previewMaxHeight'],
                'previewMaxWidth'           => $options['previewMaxWidth'],
                'primary_key'               => $options['primary_key'],
                'required'                  => $options['required'],
                'sortable'                  => $options['sortable'],
                'sortable_field'            => $options['sortable_field'],
                'uploadRouteName'           => $options['uploadRouteName'],
                'uploadRouteParameters'     => $options['uploadRouteParameters']
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'acceptFileTypes'           => '/.*$/i',
            'autoUpload'                => false,
            'editable'                  => array(),
            'displayDownloadButton'     => true,
            'loadImageFileTypes'        => '/^image\/(gif|jpe?g|png)$/i',
            'loadImageMaxFileSize'      => 5000000,
            'maxNumberOfFiles'          => null,
            'maxFileSize'               => null,
            'minFileSize'               => null,
            'multipart'                 => true,
            'multiple'                  => true,
            'nameable'                  => true,
            'nameable_field'            => 'name',
            'novalidate'                => true,
            'prependFiles'              => false,
            'previewAsCanvas'           => true,
            'previewFilter'             => null,
            'itemFilter'                => null,
            'previewMaxHeight'          => 80,
            'previewMaxWidth'           => 80,
            'primary_key'               => 'id',
            'required'                  => false,
            'sortable'                  => false,
            'sortable_field'            => 'position',
            'uploadRouteName'           => null,
            'uploadRouteParameters'     => array()
        ));

        // This seems weird... why to we accept it as option if we force
        // its value?
        $resolver->setAllowedValues(
            'novalidate', array(true)
        )->setAllowedValues(
            'multipart', array(true)
        )->addAllowedValues(
            'multiple', array(true)
        )->setAllowedValues(
            'required', array(false)
        );

        $resolver->setAllowedTypes(
            'acceptFileTypes', array('string')
        )->setAllowedTypes(
            'autoUpload', array('bool')
        )->setAllowedTypes(
            'editable', array('array')
        )->setAllowedTypes(
            'displayDownloadButton', array('bool')
        )->setAllowedTypes(
            'loadImageFileTypes', array('string')
        )->setAllowedTypes(
            'loadImageMaxFileSize', array('integer')
        )->setAllowedTypes(
            'maxNumberOfFiles', array('integer', 'null')
        )->setAllowedTypes(
            'maxFileSize', array('integer', 'null')
        )->setAllowedTypes(
            'minFileSize', array('integer', 'null')
        )->setAllowedTypes(
            'multipart', array('bool')
        )->setAllowedTypes(
            'multiple', array('bool')
        )->setAllowedTypes(
            'nameable', array('bool')
        )->setAllowedTypes(
            'nameable_field', array('string', 'null')
        )->setAllowedTypes(
            'novalidate' , array('bool')
        )->setAllowedTypes(
            'prependFiles', array('bool')
        )->setAllowedTypes(
            'previewAsCanvas', array('bool')
        )->setAllowedTypes(
            'previewFilter', array('string', 'null')
        )->setAllowedTypes(
            'itemFilter', array('string', 'null')
        )->setAllowedTypes(
            'previewMaxWidth', array('integer')
        )->setAllowedTypes(
            'previewMaxHeight', array('integer')
        )->setAllowedTypes(
            'primary_key', array('string')
        )->setAllowedTypes(
            'required', array('bool')
        )->setAllowedTypes(
            'sortable', array('bool')
        )->setAllowedTypes(
            'sortable_field', array('string')
        )->setAllowedTypes(
            'uploadRouteName', array('string', 'null')
        )->setAllowedTypes(
            'uploadRouteParameters', array('array')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\CollectionType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 's2a_upload_collection';
    }
}
