<?php

namespace Admingenerator\FormExtensionsBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'novalidate' => false,
        ));
        
        $resolver->setAllowedTypes(array(
            'novalidate' => array('bool'),
        ));
    }

    public function getExtendedType()
    {
        return 'form';
    }
}
