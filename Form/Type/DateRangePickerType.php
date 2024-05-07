<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * See `Resources/doc/daterange-picker/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class DateRangePickerType extends AbstractType
{
    protected TranslatorInterface $translator;

    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars = array_merge($view->vars, [
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
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
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
            'ranges'                => [],
            'opens'                 => 'right',
            'buttonClasses'         => ['btn', 'btn-sm'],
            'applyClass'            => 'btn-success',
            'cancelClass'           => 'btn-default',
            'format'                => 'YYYY-MM-DD',
            'separator'             => ' - ',
            'locale'                => [
                'applyLabel'            => $this->translator->trans('s2a_daterange_picker.applyLabel', [], 'AdmingeneratorFormExtensions'),
                'cancelLabel'           => $this->translator->trans('s2a_daterange_picker.cancelLabel', [], 'AdmingeneratorFormExtensions'),
                'fromLabel'             => $this->translator->trans('s2a_daterange_picker.fromLabel', [], 'AdmingeneratorFormExtensions'),
                'toLabel'               => $this->translator->trans('s2a_daterange_picker.toLabel', [], 'AdmingeneratorFormExtensions'),
                'customRangeLabel'      => $this->translator->trans('s2a_daterange_picker.customRangeLabel', [], 'AdmingeneratorFormExtensions'),
                'daysOfWeek'            => [
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Su', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Mo', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Tu', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.We', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Th', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Fr', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.daysOfWeek.Sa', [], 'AdmingeneratorFormExtensions'),
                ],
                'monthNames'            => [
                    $this->translator->trans('s2a_daterange_picker.monthNames.January', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.February', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.March', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.April', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.May', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.June', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.July', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.August', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.September', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.October', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.November', [], 'AdmingeneratorFormExtensions'),
                    $this->translator->trans('s2a_daterange_picker.monthNames.December', [], 'AdmingeneratorFormExtensions'),
                ],
                'firstDay'              => intval($this->translator->trans('s2a_daterange_picker.firstDay', [], 'AdmingeneratorFormExtensions')),
            ],
            'singleDatePicker'      => false,
            'parentEl'              => 'body',
            'callback'              => 'function(start, end, label) {}'
        ]);
        
        $resolver->setAllowedTypes(
            'startDate', ['null', 'string']
        )->setAllowedTypes(
            'endDate', ['null', 'string']
        )->setAllowedTypes(
            'minDate', ['null', 'string']
        )->setAllowedTypes(
            'maxDate', ['null', 'string']
        )->setAllowedTypes(
            'dateLimit', ['null', 'string']
        )->setAllowedTypes(
            'timeZone', ['null','string']
        )->setAllowedTypes(
            'showDropdowns', ['bool']
        )->setAllowedTypes(
            'showWeekNumbers', ['bool']
        )->setAllowedTypes(
            'timePicker', ['bool']
        )->setAllowedTypes(
            'timePickerIncrement', ['integer']
        )->setAllowedTypes(
            'timePicker12Hour', ['bool']
        )->setAllowedTypes(
            'timePickerSeconds', ['bool']
        )->setAllowedTypes(
            'ranges', ['array']
        )->setAllowedTypes(
            'buttonClasses', ['array']
        )->setAllowedTypes(
            'applyClass', ['string']
        )->setAllowedTypes(
            'cancelClass', ['string']
        )->setAllowedTypes(
            'format', ['string']
        )->setAllowedTypes(
            'separator', ['string']
        )->setAllowedTypes(
            'locale', ['array']
        )->setAllowedTypes(
            'singleDatePicker', ['bool']
        )->setAllowedTypes(
            'parentEl', ['string']
        )->setAllowedTypes(
            'callback', ['string']
        );
    }

    public function getParent(): string
    {
        return TextType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_daterange_picker';
    }
}
