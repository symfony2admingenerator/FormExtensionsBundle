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
    /**
     * @param string $widget Type of the form (used as a suffix for the blockprefix)
     * @param string $parent Parent FQCN form
     */
    public function __construct(private readonly string $widget, private readonly string $parent)
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'multiple'    => true,
            'attr'        => [
                'class' => 'hidden-select',
            ],
        ]);
    }

    public function getParent(): string
    {
        return $this->parent;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_double_list_' . $this->widget;
    }
}
