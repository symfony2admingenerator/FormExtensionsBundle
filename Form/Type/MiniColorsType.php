<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars = array_merge(
            $view->vars,
            [
                'configs' => [
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
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
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
        ]);

        $resolver->setAllowedValues(
            'control', ['hue', 'brightness', 'saturation', 'wheel']
        )->setAllowedValues(
            'letterCase', ['lowercase', 'uppercase']
        )->setAllowedValues(
            'position', ['default', 'top', 'left', 'top left']
        )->setAllowedValues(
            'swatchPosition', ['left', 'right']
        );

        $resolver->setAllowedTypes(
            'animationSpeed',  ['integer']
        )->setAllowedTypes(
            'animationEasing', ['string']
        )->setAllowedTypes(
            'changeDelay', ['integer']
        )->setAllowedTypes(
            'hideSpeed', ['integer']
        )->setAllowedTypes(
            'inline', ['bool']
        )->setAllowedTypes(
            'opacity', ['bool']
        )->setAllowedTypes(
            'showSpeed', ['integer']
        )->setAllowedTypes(
            'textfield', ['bool']
        )->setAllowedTypes(
            'theme', ['string']
        );
    }

    public function getParent(): string
    {
        return TextType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_mini_colors';
    }
}
