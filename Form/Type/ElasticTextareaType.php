<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * See `Resources/doc/elastic-textarea/overview.md` for documentation
 *
 * @author Pierrick VIGNAND <pierrick.vignand@gmail.com>
 */
class ElasticTextareaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\TextareaType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 's2a_elastic_textarea';
    }
}
