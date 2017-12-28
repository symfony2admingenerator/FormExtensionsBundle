<?php

namespace Admingenerator\FormExtensionsBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class NoValidateExtension extends AbstractTypeExtension
{
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if (empty($view->vars['attr'])) {
            $view->vars['attr'] = array();
        }

        if (true === $options['novalidate']) {
            $view->vars['attr'] = array_merge($view->vars['attr'], array(
                'novalidate' => 'novalidate',
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'novalidate' => false,
        ));
        
        $resolver->setAllowedTypes(
            'novalidate', array('bool')
        );
    }

    public function getExtendedType()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\FormType';
    }
}
