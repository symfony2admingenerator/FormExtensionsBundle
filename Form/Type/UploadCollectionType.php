<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Admingenerator\FormExtensionsBundle\Form\EventListener\UploadCollectionSubscriber;
use Admingenerator\FormExtensionsBundle\Storage\FileStorageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
    protected ?FileStorageInterface $storage = null;

    public function setFileStorage(FileStorageInterface $storage): void
    {
        $this->storage = $storage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventSubscriber(new UploadCollectionSubscriber(
            $builder->getName(),
            $options,
            $this->storage
        ));

        if (!$builder->hasAttribute('prototype')) {
            $prototype = $builder->create($options['prototype_name'], $options['type'], array_replace([
                'label' => $options['prototype_name'].'label__',
            ], $options['options']));
            $builder->setAttribute('prototype', $prototype->getForm());
        }
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars = array_merge(
            $view->vars,
            [
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
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'acceptFileTypes'           => '/.*$/i',
            'autoUpload'                => false,
            'editable'                  => [],
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
            'uploadRouteParameters'     => []
        ]);

        // This seems weird... why to we accept it as option if we force
        // its value?
        $resolver->setAllowedValues(
            'novalidate', [true]
        )->setAllowedValues(
            'multipart', [true]
        )->addAllowedValues(
            'multiple', [true]
        )->setAllowedValues(
            'required', [false]
        );

        $resolver->setAllowedTypes(
            'acceptFileTypes', ['string']
        )->setAllowedTypes(
            'autoUpload', ['bool']
        )->setAllowedTypes(
            'editable', ['array']
        )->setAllowedTypes(
            'displayDownloadButton', ['bool']
        )->setAllowedTypes(
            'loadImageFileTypes', ['string']
        )->setAllowedTypes(
            'loadImageMaxFileSize', ['integer']
        )->setAllowedTypes(
            'maxNumberOfFiles', ['integer', 'null']
        )->setAllowedTypes(
            'maxFileSize', ['integer', 'null']
        )->setAllowedTypes(
            'minFileSize', ['integer', 'null']
        )->setAllowedTypes(
            'multipart', ['bool']
        )->setAllowedTypes(
            'multiple', ['bool']
        )->setAllowedTypes(
            'nameable', ['bool']
        )->setAllowedTypes(
            'nameable_field', ['string', 'null']
        )->setAllowedTypes(
            'novalidate' , ['bool']
        )->setAllowedTypes(
            'prependFiles', ['bool']
        )->setAllowedTypes(
            'previewAsCanvas', ['bool']
        )->setAllowedTypes(
            'previewFilter', ['string', 'null']
        )->setAllowedTypes(
            'itemFilter', ['string', 'null']
        )->setAllowedTypes(
            'previewMaxWidth', ['integer']
        )->setAllowedTypes(
            'previewMaxHeight', ['integer']
        )->setAllowedTypes(
            'primary_key', ['string']
        )->setAllowedTypes(
            'required', ['bool']
        )->setAllowedTypes(
            'sortable', ['bool']
        )->setAllowedTypes(
            'sortable_field', ['string']
        )->setAllowedTypes(
            'uploadRouteName', ['string', 'null']
        )->setAllowedTypes(
            'uploadRouteParameters', ['array']
        );
    }

    public function getParent(): string
    {
        return CollectionType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_upload_collection';
    }
}
