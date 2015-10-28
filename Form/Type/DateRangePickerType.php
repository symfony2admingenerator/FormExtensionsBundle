<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * See `Resources/doc/daterange-picker/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class DateRangePickerType extends AbstractType
{
    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected $translator;
    
    /**
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    
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
            'callback'              => $options['callback']
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'startDate'             => null,
            'endDate'               => null,
            'minDate'               => null,
            'maxDate'               => null,
            'dateLimit'             => null,
            'timeZone'              => null,
            'showDropdowns'         => true,
            'showWeekNumbers'       => true,
            'timePicker'            => false,
            'timePickerIncrement'   => 1,
            'timePicker12Hour'      => false,
            'timePickerSeconds'     => false,
            'ranges'                => array(),
            'opens'                 => 'right',
            'buttonClasses'         => array('btn', 'btn-sm'),
            'applyClass'            => 'btn-success',
            'cancelClass'           => 'btn-default',
            'format'                => 'YYYY-MM-DD',
            'separator'             => ' - ',
            'locale'                => array(
                'applyLabel'            => $this->translator->trans('s2a_daterange_picker.applyLabel', array(), 'AdmingeneratorFormExtensions'),
                'cancelLabel'           => $this->translator->trans('s2a_daterange_picker.cancelLabel', array(), 'AdmingeneratorFormExtensions'),
                'fromLabel'             => $this->translator->trans('s2a_daterange_picker.fromLabel', array(), 'AdmingeneratorFormExtensions'),
                'toLabel'               => $this->translator->trans('s2a_daterange_picker.toLabel', array(), 'AdmingeneratorFormExtensions'),
                'customRangeLabel'      => $this->translator->trans('s2a_daterange_picker.customRangeLabel', array(), 'AdmingeneratorFormExtensions'),
                'daysOfWeek'            => array(
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Su', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Mo', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Tu', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.We', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Th', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Fr', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Sa', array(), 'AdmingeneratorFormExtensions'),
                ),
                'monthNames'            => array(
                    $this->translator->trans('s2a_daterange_picker.monthNames.January', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.February', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.March', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.April', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.May', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.June', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.July', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.August', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.September', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.October', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.November', array(), 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.December', array(), 'AdmingeneratorFormExtensions'),
                ),
                'firstDay'              => intval($this->translator->trans('s2a_daterange_picker.firstDay', array(), 'AdmingeneratorFormExtensions')),
            ),
            'singleDatePicker'      => false,
            'parentEl'              => 'body',
            'callback'              => 'function(start, end, label) {}'
        ));
        
        $resolver->setAllowedTypes(
            'startDate', array('null', 'string')
        )->setAllowedTypes(
            'endDate', array('null', 'string')
        )->setAllowedTypes(
            'minDate', array('null', 'string')
        )->setAllowedTypes(
            'maxDate', array('null', 'string')
        )->setAllowedTypes(
            'dateLimit', array('null', 'string')
        )->setAllowedTypes(
            'timeZone', array('null', 'string')
        )->setAllowedTypes(
            'showDropdowns', array('bool')
        )->setAllowedTypes(
            'showWeekNumbers', array('bool')
        )->setAllowedTypes(
            'timePicker', array('bool')
        )->setAllowedTypes(
            'timePickerIncrement', array('integer')
        )->setAllowedTypes(
            'timePicker12Hour', array('bool')
        )->setAllowedTypes(
            'timePickerSeconds', array('bool')
        )->setAllowedTypes(
            'ranges', array('array')
        )->setAllowedTypes(
            'buttonClasses', array('array')
        )->setAllowedTypes(
            'applyClass', array('string')
        )->setAllowedTypes(
            'cancelClass', array('string')
        )->setAllowedTypes(
            'format', array('string')
        )->setAllowedTypes(
            'separator', array('string')
        )->setAllowedTypes(
            'locale', array('array')
        )->setAllowedTypes(
            'singleDatePicker', array('bool')
        )->setAllowedTypes(
            'parentEl', array('string')
        )->setAllowedTypes(
            'callback', array('string')
        );
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
