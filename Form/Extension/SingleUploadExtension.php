<?php

namespace Admingenerator\FormExtensionsBundle\Form\Extension;

use Admingenerator\FormExtensionsBundle\Form\EventListener\SingleUploadSubscriber;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class SingleUploadExtension extends AbstractTypeExtension
{
    /**
     * Adds a single upload subscriber to all compound forms
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['compound']) {
            $builder->addEventSubscriber(new SingleUploadSubscriber());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getExtendedType()
    {
        return self::getExtendedTypes()[0];
    }

    public static function getExtendedTypes()
    {
        return ['Symfony\Component\Form\Extension\Core\Type\FormType'];
    }
}

