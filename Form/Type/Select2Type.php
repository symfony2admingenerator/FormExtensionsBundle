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
     * @var string
     */
    private $widget;
    /**
     * @var string
     */
    private $parent;

    /**
     * @param string $widget Type of the form (used as a suffix fot he blocprefix)
     * @param string $parent Parent FQCN form
     */
    public function __construct($widget, $parent)
    {
        $this->widget = $widget;
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ('hidden' === $this->widget && !empty($options['configs']['multiple'])) {
            $builder->addViewTransformer(new ArrayToStringTransformer());
        } elseif ('hidden' === $this->widget && empty($options['configs']['multiple']) && null !== $options['transformer']) {
            $builder->addModelTransformer($options['transformer']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
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

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $defaults = array(
            'allowClear'         => false,
            'minimumInputLength' => 0,
            'width'              => 'resolve',
        );

        $resolver
            ->setDefaults(array(
                'hidden'        => false,
                'configs'       => $defaults,
                'transformer'   => null,
            ))
            ->setNormalizer(
                'configs', function (Options $options, $configs) use ($defaults) {
                    return array_merge($defaults, $configs);
                }
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 's2a_select2_' . $this->widget;
    }
}
