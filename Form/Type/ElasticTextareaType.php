<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * See `Resources/doc/elastic-textarea/overview.md` for documentation
 *
 * @author Pierrick VIGNAND <pierrick.vignand@gmail.com>
 */
class ElasticTextareaType extends AbstractType
{
    public function getParent(): string
    {
        return TextareaType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_elastic_textarea';
    }
}
