<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * See `Resources/doc/double-list/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */
abstract class DoubleListType extends AbstractType
{
    private $widget;

    public function __construct($widget)
    {
        $this->widget = $widget;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'multiple'    => true,
            'attr'        => array(
                'class' => 'hidden-select',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 's2a_double_list_' . $this->widget;
    }
}
