<?php

namespace Admingenerator\FormExtensionsBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author havvg <tuebernickel@gmail.com>
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class AutocompleteExtension extends AbstractTypeExtension
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // It doesn't hurt even if it will be left empty.
        if (empty($view->vars['attr'])) {
            $view->vars['attr'] = array();
        }

        if (false === $options['autocomplete']) {
            $view->vars['attr'] = array_merge($view->vars['attr'], array(
                'autocomplete'        => 'off',
                'x-autocompletetype'  => 'off',
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'autocomplete' => true,
        ));
        
        $resolver->setAllowedTypes(
            'autocomplete', array('bool')
        );
    }

    public function getExtendedType()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\FormType';
    }
}
