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
        $view->vars['width'] = $options['width'];
        $view->vars['config'] = array_replace($options['config'], array(
        ));

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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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

        $resolver->setAllowedTypes(array(
            'width'  => array('null', 'integer'),
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
