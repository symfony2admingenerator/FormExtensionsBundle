<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * See `Resources/doc/bootstrap-datetimepicker/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class TimePickerType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['width'] = $options['width'];
        $view->vars['config'] = $options['config'];

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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'widget'        => 'single_text',
            'width'     => null,
            'config'        => [
                'icons'         => [
                    'time'  => "fa fa-clock-o",
                    'date'  => "fa fa-calendar",
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
        );
    }

    public function getParent(): string
    {
        return TimeType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_time_picker';
    }
}
