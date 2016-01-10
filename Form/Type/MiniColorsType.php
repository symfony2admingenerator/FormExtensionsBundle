<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * See `Resources/doc/mini-colors/overview.md` for documentation
 *
 * @author Escandell Stéphane <stephane.escandell@gmail.com>
 */
class MiniColorsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge(
            $view->vars,
            array(
                'configs' => array(
                    'animationSpeed'  => $options['animationSpeed'],
                    'animationEasing' => $options['animationEasing'],
                    'changeDelay'     => $options['changeDelay'],
                    'control'         => $options['control'],
                    'hideSpeed'       => $options['hideSpeed'],
                    'inline'          => $options['inline'],
                    'letterCase'      => $options['letterCase'],
                    'opacity'         => $options['opacity'],
                    'position'        => $options['position'],
                    'showSpeed'       => $options['showSpeed'],
                    'swatchPosition'  => $options['swatchPosition'],
                    'textfield'       => $options['textfield'],
                    'theme'           => $options['theme'],
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'animationSpeed'  => 100,
            'animationEasing' => 'swing',
            'changeDelay'     => 0,
            'control'         => 'hue',
            'hideSpeed'       => 100,
            'inline'          => false,
            'letterCase'      => 'lowercase',
            'opacity'         => false,
            'position'        => 'default',
            'showSpeed'       => 100,
            'swatchPosition'  => 'left',
            'textfield'       => true,
            'theme'           => 'bootstrap'
        ));

        $resolver->setAllowedValues(
            'control', array('hue', 'brightness', 'saturation', 'wheel')
        )->setAllowedValues(
            'letterCase', array('lowercase', 'uppercase')
        )->setAllowedValues(
            'position', array('default', 'top', 'left', 'top left')
        )->setAllowedValues(
            'swatchPosition', array('left', 'right')
        );

        $resolver->setAllowedTypes(
            'animationSpeed',  array('integer')
        )->setAllowedTypes(
            'animationEasing', array('string')
        )->setAllowedTypes(
            'changeDelay', array('integer')
        )->setAllowedTypes(
            'hideSpeed', array('integer')
        )->setAllowedTypes(
            'inline', array('bool')
        )->setAllowedTypes(
            'opacity', array('bool')
        )->setAllowedTypes(
            'showSpeed', array('integer')
        )->setAllowedTypes(
            'textfield', array('bool')
        )->setAllowedTypes(
            'theme', array('string')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\TextType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 's2a_mini_colors';
    }
}
