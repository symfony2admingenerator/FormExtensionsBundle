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
class DatePickerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['width'] = $options['width'];
        $view->vars['config'] = $options['config'];

        if ($view->vars['value']) {
            $view->vars['widget_value'] = $view->vars['value'];
        }

        $view->vars['widget_format'] = 'YYYY-MM-DD';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget'    => 'single_text',
            'format'    => 'yyyy-MM-dd',
            'width'     => null,
            'config'    => array(
                'icons'     => array(
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
            'widget' => array('single_text'),
            'format' => array('yyyy-MM-dd')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'date';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 's2a_date_picker';
    }
}
