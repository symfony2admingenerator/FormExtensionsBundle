<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

/**
 * See `Resources/doc/bootstrap-datetimepicker/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class DateTimePickerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['width'] = $options['width'];
        $view->vars['config'] = array_replace($options['config'], array(
            'icons'         => array(
                'time'  => "fa fa-clock-o",
                'date'  => "fa fa-calendar",
                'up'    => "fa fa-arrow-up",
                'down'  => "fa fa-arrow-down"
            )
        ));

        if ($view->vars['value']) {
            $value = new \DateTime($view->vars['value']);
            $view->vars['widget_value'] = $value->format('Y-m-d\TH:i:sP');
        }

        $view->vars['widget_format'] = 'YYYY-MM-DDTHH:mm:ssZ';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'widget'    => 'single_text',
            'format'    => DateTimeType::HTML5_FORMAT,
            'width'     => null,
            'config'    => array(
                'sideBySide'    => false,
                'icons'     => array(
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
        )->setAllowedValues(
            'format', array(DateTimeType::HTML5_FORMAT)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\DateTimeType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 's2a_datetime_picker';
    }
}
