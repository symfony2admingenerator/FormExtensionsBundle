<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * See `Resources/doc/knob/overview.md` for documentation
 *
 * @author Vincent Touzet <vincent.touzet@gmail.com>
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class KnobType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $class = 'knob';
        if (array_key_exists('attr', $options) && array_key_exists('class', $options['attr'])) {
            $class = $options['attr']['class'].' '.$class;
        }

        $style = $options['hide_box_shadow'] ? 'box-shadow:none;' : '';
        if (array_key_exists('attr', $options) && array_key_exists('style', $options['attr'])) {
            $style = trim($options['attr']['style'].' '.$style);
        }

        $view->vars = array_merge(
            $view->vars,
            [
                'width'           => $options['width'],
                'height'          => $options['height'],
                'displayInput'    => $options['displayInput'],
                'displayPrevious' => $options['displayPrevious'],
                'angleArc'        => $options['angleArc'],
                'angleOffset'     => $options['angleOffset'],
                'cursor'          => $options['cursor'],
                'readOnly'        => $options['readOnly'],
                'thickness'       => $options['thickness'],
                'fgColor'         => $options['fgColor'],
                'bgColor'         => $options['bgColor'],
                'lineCap'         => $options['lineCap'],
                'step'            => $options['step'],
                'min'             => $options['min'],
                'max'             => $options['max'],
                'attr'            => [
                    'class' => $class,
                    'style' => $style,
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'width'           => 200,
            'height'          => 200,
            'displayInput'    => true,
            'displayPrevious' => false,
            'angleArc'        => 0,
            'angleOffset'     => 0,
            'cursor'          => true,
            'readOnly'        => false,
            'thickness'       => 0.35,
            'fgColor'         => '#87CEEB',
            'bgColor'         => '#EEEEEE',
            'lineCap'         => 'butt',
            'step'            => 1,
            'min'             => 0,
            'max'             => 100,
            'hide_box_shadow' => true,
        ]);

        $resolver->setAllowedTypes(
            'width', ['integer']
        )->setAllowedTypes(
            'height', ['integer']
        )->setAllowedTypes(
            'displayInput', ['bool']
        )->setAllowedTypes(
            'displayPrevious', ['bool']
        )->setAllowedTypes(
            'angleArc', ['numeric']
        )->setAllowedTypes(
            'angleOffset', ['numeric']
        )->setAllowedTypes(
            'cursor', ['numeric', 'bool']
        )->setAllowedTypes(
            'readOnly', ['bool']
        )->setAllowedTypes(
            'thickness', ['numeric']
        )->setAllowedTypes(
            'fgColor', ['string']
        )->setAllowedTypes(
            'bgColor', ['string']
        )->setAllowedTypes(
            'step', ['numeric']
        )->setAllowedTypes(
            'min', ['numeric']
        )->setAllowedTypes(
            'max', ['numeric']
        )->setAllowedTypes(
            'hide_box_shadow', ['bool']
        );

        $resolver->setAllowedValues(
            'angleArc', range(0, 359)
        )->setAllowedValues(
            'angleOffset', range(0, 359)
        )->setAllowedValues(
            'lineCap', ['butt', 'round']
        );
    }

    public function getParent(): string
    {
        return NumberType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_knob';
    }
}
