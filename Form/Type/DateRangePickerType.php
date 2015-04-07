<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * See `Resources/doc/daterange-picker/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class DateRangePickerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($options['from_name'], $options['type'], array_merge($options['options'], $options['from_options']))
            ->add($options['to_name'], $options['type'], array_merge($options['options'], $options['to_options']))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'type'            => 'text',
            'options'         => array(),
            'from_options'    => array(),
            'to_options'      => array(),
            'from_name'       => 'from',
            'to_name'         => 'to',
            'error_bubbling' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, array(
            'from_name'   => $options['from_name'],
            'to_name'     => $options['to_name'],
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 's2a_daterange_picker';
    }
}
