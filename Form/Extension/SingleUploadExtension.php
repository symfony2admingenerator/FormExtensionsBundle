<?php

namespace Admingenerator\FormExtensionsBundle\Form\Extension;

use Admingenerator\FormExtensionsBundle\Form\EventListener\SingleUploadSubscriber;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class SingleUploadExtension extends AbstractTypeExtension
{
    /**
     * Adds a single upload subscriber to all compound forms
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['compound']) {
            $builder->addEventSubscriber(new SingleUploadSubscriber());
        }
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}

