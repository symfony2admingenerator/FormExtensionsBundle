<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
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
    public function buildView(FormView $view, FormInterface $form, array $options)
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
            array(
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
                'attr'            => array(
                    'class' => $class,
                    'style' => $style,
                )
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
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
        ));

        $resolver->setAllowedTypes(
            'width', array('integer')
        )->setAllowedTypes(
            'height', array('integer')
        )->setAllowedTypes(
            'displayInput', array('bool')
        )->setAllowedTypes(
            'displayPrevious', array('bool')
        )->setAllowedTypes(
            'angleArc', array('numeric')
        )->setAllowedTypes(
            'angleOffset', array('numeric')
        )->setAllowedTypes(
            'cursor', array('numeric', 'bool')
        )->setAllowedTypes(
            'readOnly', array('bool')
        )->setAllowedTypes(
            'thickness', array('numeric')
        )->setAllowedTypes(
            'fgColor', array('string')
        )->setAllowedTypes(
            'bgColor', array('string')
        )->setAllowedTypes(
            'step', array('numeric')
        )->setAllowedTypes(
            'min', array('numeric')
        )->setAllowedTypes(
            'max', array('numeric')
        )->setAllowedTypes(
            'hide_box_shadow', array('bool')
        );

        $resolver->setAllowedValues(
            'angleArc', range(0, 359)
        )->setAllowedValues(
            'angleOffset', range(0, 359)
        )->setAllowedValues(
            'lineCap', array('butt', 'round')
        );
    }

    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\NumberType';
    }

    public function getBlockPrefix()
    {
        return 's2a_knob';
    }
}
