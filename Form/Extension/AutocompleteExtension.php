<?php

namespace Admingenerator\FormExtensionsBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author havvg <tuebernickel@gmail.com>
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class AutocompleteExtension extends AbstractTypeExtension
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        // It doesn't hurt even if it will be left empty.
        if (empty($view->vars['attr'])) {
            $view->vars['attr'] = [];
        }

        if (false === $options['autocomplete']) {
            $view->vars['attr'] = array_merge($view->vars['attr'], [
                'autocomplete'        => 'off',
                'x-autocompletetype'  => 'off',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'autocomplete' => true,
        ]);
        
        $resolver->setAllowedTypes(
            'autocomplete', ['bool']
        );
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}
