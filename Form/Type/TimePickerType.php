<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * See `Resources/doc/bootstrap-datetimepicker/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class TimePickerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['width'] = $options['width'];
        $view->vars['config'] = $options['config'];

        if ($options['with_minutes'] && $options['with_seconds']) {
            $widgetFormat = 'HH:mm:ss';
        } else if ($options['with_minutes']) {            
            $widgetFormat = 'HH:mm';
        } else {
            $widgetFormat = 'HH';
        }

        if ($view->vars['value']) {
            $view->vars['widget_value'] = $view->vars['value'];
        }
        
        $view->vars['widget_format'] = $widgetFormat;
        
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'widget'        => 'single_text',
            'width'     => null,
            'config'        => array(
                'icons'         => array(
                    'time'  => "fa fa-clock-o",
                    'date'  => "fa fa-calendar",
                    'up'    => "fa fa-arrow-up",
                    'down'  => "fa fa-arrow-down"
                )
            )
        ));

        $resolver->setAllowedTypes(
            'width', array('null', 'integer')
        )->setAllowedTypes(
            'config', array('array')
        );

        $resolver->setAllowedValues(
            'widget', array('single_text')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\TimeType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 's2a_time_picker';
    }
}
