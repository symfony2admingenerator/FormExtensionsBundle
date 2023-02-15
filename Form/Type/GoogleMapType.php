<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * See `Resources/doc/google-map/overview.md` for documentation
 *
 * @author Ollie Harridge <code@oll.ie>
 */
class GoogleMapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add($options['lat_name'], $options['type'], array_merge($options['options'], $options['lat_options']))
            ->add($options['lng_name'], $options['type'], array_merge($options['options'], $options['lng_options']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'type'           => TextType::class,
            'options'        => [],
            'lat_options'    => [],
            'lng_options'    => [],
            'lat_name'       => 'latitude',
            'lng_name'       => 'longitude',
            'error_bubbling' => false,
            'map_width'      => null,
            'map_height'     => null,
            // default to Greenwitch, London
            'default_lat'    => 51.5,
            'default_lng'    => -0.1245,
            'callback'       => 'function (location, gmap) {}',
            'error_handler'  => 'function (elem, status) {}'
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars = array_merge($view->vars, array(
            'lat_name'      => $options['lat_name'],
            'lng_name'      => $options['lng_name'],
            'map_width'     => $options['map_width'],
            'map_height'    => $options['map_height'],
            'default_lat'   => $options['default_lat'],
            'default_lng'   => $options['default_lng'],
            'callback'      => $options['callback'],
            'error_handler' => $options['error_handler'],
        ));
    }

    public function getParent(): string
    {
        return FormType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_google_map';
    }
}
