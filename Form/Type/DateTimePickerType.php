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
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['width'] = $options['width'];
        $view->vars['config'] = array_replace($options['config'], array(
            'icons'         => array(
                'time'  => "fa fa-clock fa-regular",
                'date'  => "fa fa-calendar-days fa-regular",
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'widget'    => 'single_text',
            'format'    => DateTimeType::HTML5_FORMAT,
            'width'     => null,
            'config'    => [
                'sideBySide'    => false,
                'icons'     => [
                    'time'  => "fa fa-clock fa-regular",
                    'date'  => "fa fa-calendar-days fa-regular",
                    'up'    => "fa fa-arrow-up",
                    'down'  => "fa fa-arrow-down"
                ]
            ]
        ]);

        $resolver->setAllowedTypes(
            'width', ['null', 'integer']
        )->setAllowedTypes(
            'config', ['array']
        );

        $resolver->setAllowedValues(
            'widget', ['single_text']
        )->setAllowedValues(
            'format', [DateTimeType::HTML5_FORMAT]
        );
    }

    public function getParent(): string
    {
        return DateTimeType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_datetime_picker';
    }
}
