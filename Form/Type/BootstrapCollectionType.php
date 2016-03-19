<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Admingenerator\FormExtensionsBundle\Form\EventListener\ReorderCollectionSubscriber;
use Symfony\Component\Form\AbstractType;
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
     * @var string
     */
    private $widget;

    /**
     * @param string $widget Type of the form (used as a suffix fot he blocprefix)
     */
    public function __construct($widget)
    {
        $this->widget = $widget;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new ReorderCollectionSubscriber());

        parent::buildForm($builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['sortable']       = $options['sortable'];
        $view->vars['sortable_field'] = $options['sortable_field'];
        $view->vars['new_label']      = $options['new_label'];
        $view->vars['prototype_name'] = $options['prototype_name'];
        $view->vars['fieldset_class'] = $options['fieldset_class'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'sortable'           => false,
            'sortable_field'     => 'position',
            'new_label'          => 's2a_bootstrap_collection.new_label',
            'fieldset_class'     => 'col-md-4'
        ));

        $resolver->setAllowedTypes(
            'sortable', array('bool')
        )->setAllowedTypes(
            'sortable_field', array('string')
        )->setAllowedTypes(
            'new_label', array('string')
        )->setAllowedTypes(
            'fieldset_class', array('string')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\CollectionType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 's2a_collection_' . $this->widget;
    }
}
