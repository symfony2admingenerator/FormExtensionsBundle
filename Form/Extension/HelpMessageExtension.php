<?php

namespace Admingenerator\FormExtensionsBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author havvg <tuebernickel@gmail.com>
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class HelpMessageExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setAttribute('help', $options['help']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['help'] = $form->getConfig()->getAttribute('help');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'help' => null,
        ]);
        
        $resolver->setAllowedTypes(
            'help', ['null', 'string']
        );
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}