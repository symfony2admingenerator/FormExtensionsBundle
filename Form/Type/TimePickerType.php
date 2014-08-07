<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
        $view->vars['config'] = array_replace($options['config'], array(
            'pickDate'      => false,
            'pickTime'      => true,
            'useMinutes'    => $options['with_minutes'],
            'useSeconds'    => $options['with_seconds'],
        ));

        // widget requires value in format d-M-y H:i:s
        if ($options['with_minutes'] && $options['with_seconds']) {            
            $widgetValue = '01-01-0000 ' . $view->vars['value'];
            $widgetFormat = 'HH:mm:ss';
        } else if ($options['with_minutes']) {            
            $widgetValue = '01-01-0000 ' . $view->vars['value'] . ':00';
            $widgetFormat = 'HH:mm';
        } else {
            $widgetValue = '01-01-0000 ' . $view->vars['value'] . ':00:00';
            $widgetFormat = 'HH';
        }

        if ($view->vars['value']) {
            // the d-M-y part will always be 01-01-0000
            $view->vars['widget_value'] = $widgetValue;
        }
        
        $view->vars['widget_format'] = $widgetFormat;
        
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget'        => 'single_text',
            'config'        => array(
                'pickDate'      => false,
                'pickTime'      => true,
                'icons'         => array(
                    'time'  => "fa fa-clock-o",
                    'date'  => "fa fa-calendar",
                    'up'    => "fa fa-arrow-up",
                    'down'  => "fa fa-arrow-down"
                )
            )
        ));

        $resolver->setAllowedTypes(array(
            'config' => array('array')
        ));

        $resolver->setAllowedValues(array(
            'widget' => array('single_text')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'time';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 's2a_time_picker';
    }
}
