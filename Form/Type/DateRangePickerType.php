<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * See `Resources/doc/daterange-picker/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class DateRangePickerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, array(
            'from_name'   => $options['from_name'],
            'to_name'     => $options['to_name'],
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'startDate'             => null,
            'endDate'               => null,
            'minDate'               => null,
            'maxDate'               => null,
            'dateLimit'             => null,
            'timeZone'              => null,
            'showDropdowns'         => null,
            'showWeekNumbers'       => null,
            'timePicker'            => null,
            'timePickerIncrement'   => null,
            'timePicker12Hour'      => null,
            'timePickerSeconds'     => null,
            'ranges'                => null,
            'opens'                 => null,
            'buttonClasses'         => null,
            'applyClass'            => null,
            'cancelClass'           => null,
            'format'                => null,
            'separator'             => null,
            'locale'                => null,
            'singleDatePicker'      => null,
            'parentEl'              => null,
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 's2a_daterange_picker';
    }
}
