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
            'singleDatePicker'      => $options['singleDatePicker'],
            'parentEl'              => $options['parentEl'],
            'callback'              => $options['callback']
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
            'timeZone'              => '+00:00',
            'showDropdowns'         => true,
            'showWeekNumbers'       => true,
            'timePicker'            => false,
            'timePickerIncrement'   => 1,
            'timePicker12Hour'      => false,
            'timePickerSeconds'     => false,
            'ranges'                => array(),
            'opens'                 => 'right',
            'buttonClasses'         => array('btn'),
            'applyClass'            => 'btn-success',
            'cancelClass'           => 'btn-default',
            'format'                => 'YYYY-MM-DD',
            'separator'             => ' - ',
            'locale'                => array(
                'applyLabel'            => 's2a_daterange_picker.applyLabel',
                'cancelLabel'           => 's2a_daterange_picker.cancelLabel',
                'fromLabel'             => 's2a_daterange_picker.fromLabel',
                'toLabel'               => 's2a_daterange_picker.toLabel',
                'customRangeLabel'      => 's2a_daterange_picker.customRangeLabel',
                'daysOfWeek'            => array(
                    's2a_daterange_picker.daysOfWeek.Su',
                    's2a_daterange_picker.daysOfWeek.Mo',
                    's2a_daterange_picker.daysOfWeek.Tu',
                    's2a_daterange_picker.daysOfWeek.We',
                    's2a_daterange_picker.daysOfWeek.Th',
                    's2a_daterange_picker.daysOfWeek.Fr',
                    's2a_daterange_picker.daysOfWeek.Sa'
                ),
                'monthNames'            => array(
                    's2a_daterange_picker.monthNames.January',
                    's2a_daterange_picker.monthNames.February',
                    's2a_daterange_picker.monthNames.March',
                    's2a_daterange_picker.monthNames.April',
                    's2a_daterange_picker.monthNames.May',
                    's2a_daterange_picker.monthNames.June',
                    's2a_daterange_picker.monthNames.July',
                    's2a_daterange_picker.monthNames.August',
                    's2a_daterange_picker.monthNames.September',
                    's2a_daterange_picker.monthNames.October',
                    's2a_daterange_picker.monthNames.November',
                    's2a_daterange_picker.monthNames.December'
                ),
                'firstDay'              => 's2a_daterange_picker.firstDay'
            ),
            'singleDatePicker'      => false,
            'parentEl'              => 'body',
            'callback'              => 'function(start, end, label) {}'
        ));
        
        $resolver->setAllowedTypes(array(
            'startDate'             => array('null', 'string'),
            'endDate'               => array('null', 'string'),
            'minDate'               => array('null', 'string'),
            'maxDate'               => array('null', 'string'),
            'dateLimit'             => array('null', 'string'),
            'timeZone'              => array('string'),
            'showDropdowns'         => array('bool'),
            'showWeekNumbers'       => array('bool'),
            'timePicker'            => array('bool'),
            'timePickerIncrement'   => array('integer'),
            'timePicker12Hour'      => array('bool'),
            'timePickerSeconds'     => array('bool'),
            'ranges'                => array('array'),
            'buttonClasses'         => array('array'),
            'applyClass'            => array('string'),
            'cancelClass'           => array('string'),
            'format'                => array('string'),
            'separator'             => array('string'),
            'locale'                => array('array'),
            'singleDatePicker'      => array('bool'),
            'parentEl'              => array('string'),
            'callback'              => array('string'),
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
