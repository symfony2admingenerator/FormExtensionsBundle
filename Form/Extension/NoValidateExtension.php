<?php

namespace Admingenerator\FormExtensionsBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class NoValidateExtension extends AbstractTypeExtension
{
    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        if (empty($view->vars['attr'])) {
            $view->vars['attr'] = [];
        }

        if (true === $options['novalidate']) {
            $view->vars['attr'] = array_merge($view->vars['attr'], [
                'novalidate' => 'novalidate',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'novalidate' => false,
        ]);
        
        $resolver->setAllowedTypes(
            'novalidate', ['bool']
        );
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}
