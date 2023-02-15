<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Admingenerator\FormExtensionsBundle\Form\EventListener\ReorderCollectionSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * See `Resources/doc/bootstrap-collection/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */
abstract class BootstrapCollectionType extends AbstractType
{

    /**
     * @param string $widget Type of the form (used as a suffix for the blockprefix)
     */
    public function __construct(private readonly string $widget)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventSubscriber(new ReorderCollectionSubscriber());

        parent::buildForm($builder, $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['sortable']       = $options['sortable'];
        $view->vars['sortable_field'] = $options['sortable_field'];
        $view->vars['new_label']      = $options['new_label'];
        $view->vars['prototype_name'] = $options['prototype_name'];
        $view->vars['fieldset_class'] = $options['fieldset_class'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'sortable'           => false,
            'sortable_field'     => 'position',
            'new_label'          => 's2a_bootstrap_collection.new_label',
            'fieldset_class'     => 'col-md-4'
        ]);

        $resolver->setAllowedTypes(
            'sortable', ['bool']
        )->setAllowedTypes(
            'sortable_field', ['string']
        )->setAllowedTypes(
            'new_label', ['string']
        )->setAllowedTypes(
            'fieldset_class', ['string']
        );
    }

    public function getParent(): string
    {
        return CollectionType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_collection_' . $this->widget;
    }
}
