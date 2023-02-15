<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Admingenerator\FormExtensionsBundle\Form\DataTransformer\ArrayToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * See `Resources/doc/select2/overview.md` for documentation
 *
 * @author Bilal Amarni <bilal.amarni@gmail.com>
 * @author Chris Tickner <chris.tickner@gmail.com>
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */
abstract class Select2Type extends AbstractType
{

    /**
     * @param string $widget Type of the form (used as a suffix for the blockprefix)
     * @param string $parent Parent FQCN form
     */
    public function __construct(private readonly string $widget, private readonly string $parent)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ('hidden' === $this->widget && !empty($options['configs']['multiple'])) {
            $builder->addViewTransformer(new ArrayToStringTransformer());
        } elseif ('hidden' === $this->widget && empty($options['configs']['multiple']) && null !== $options['transformer']) {
            $builder->addModelTransformer($options['transformer']);
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['configs'] = $options['configs'];
        $view->vars['hidden'] = $options['hidden'];

        // Adds a custom block prefix
        array_splice(
            $view->vars['block_prefixes'],
            array_search($this->getBlockPrefix(), $view->vars['block_prefixes']),
            0,
            's2a_select2'
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $defaults = [
            'allowClear'         => false,
            'minimumInputLength' => 0,
            'width'              => 'resolve',
        ];

        $resolver
            ->setDefaults([
                'hidden'        => false,
                'configs'       => $defaults,
                'transformer'   => null,
            ])
            ->setNormalizer(
                'configs', function (Options $options, $configs) use ($defaults) {
                    return array_merge($defaults, $configs);
                }
            )
        ;
    }

    public function getParent(): string
    {
        return $this->parent;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_select2_' . $this->widget;
    }
}
