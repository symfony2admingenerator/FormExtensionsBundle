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
            'startDate'             => $options['startDate'],
            'endDate'               => $options['endDate'],
            'minDate'               => $options['minDate'],
            'maxDate'               => $options['maxDate'],
            'dateLimit'             => $options['dateLimit'],
            'timeZone'              => $options['timeZone'],
            'showDropdowns'         => $options['showDropdowns'],
            'showWeekNumbers'       => $options['showWeekNumbers'],
            'timePicker'            => $options['timePicker'],
            'timePickerIncrement'   => $options['timePickerIncrement'],
            'timePicker12Hour'      => $options['timePicker12Hour'],
            'timePickerSeconds'     => $options['timePickerSeconds'],
            'ranges'                => $options['ranges'],
            'opens'                 => $options['opens'],
            'buttonClasses'         => $options['buttonClasses'],
            'applyClass'            => $options['applyClass'],
            'cancelClass'           => $options['cancelClass'],
            'format'                => $options['format'],
            'separator'             => $options['separator'],
            'locale'                => $options['locale'],
            'singleDatePicker'      => $options['singleDatePicker'],
            'parentEl'              => $options['parentEl'],
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
