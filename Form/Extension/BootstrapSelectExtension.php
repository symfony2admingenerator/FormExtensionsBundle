<?php

namespace Admingenerator\FormExtensionsBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class BootstrapSelectExtension extends AbstractTypeExtension
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (false === $options['expanded'] && !array_key_exists('class', $options['attr'])) {
            $view->vars['attr'] = array_merge($view->vars['attr'], array(
                'class' => 'selectpicker'
            ));
        }
    }

    public function getExtendedType()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\ChoiceType';
    }
}
