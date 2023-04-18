<?php

namespace Admingenerator\FormExtensionsBundle\DependencyInjection;

use Admingenerator\FormExtensionsBundle\Form\Extension\AutocompleteExtension;
use Admingenerator\FormExtensionsBundle\Form\Extension\BootstrapSelectExtension;
use Admingenerator\FormExtensionsBundle\Form\Extension\HelpMessageExtension;
use Admingenerator\FormExtensionsBundle\Form\Extension\NoValidateExtension;
use Admingenerator\FormExtensionsBundle\Form\Extension\SingleUploadExtension;
use Admingenerator\FormExtensionsBundle\Twig\Extension\ImageAssetsExtension;
use Admingenerator\FormExtensionsBundle\Twig\Extension\IncludeGlobalsExtension;
use Admingenerator\FormExtensionsBundle\Twig\Extension\LegacyIncludeGlobalsExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Twig\Environment;

/**
 * Loads FormExtensions configuration
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class AdmingeneratorFormExtensionsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('admingenerator.form.upload_manager', $config['upload_manager']);
        $container->setParameter('admingenerator.form.image_manipulator', $config['image_manipulator']);
        $container->setParameter('admingenerator.form.twig', $config['twig']);
        $container->setParameter('admingenerator.form.include_jquery', $config['include_jquery']);
        $container->setParameter('admingenerator.form.include_jqueryui', $config['include_jqueryui']);
        $container->setParameter('admingenerator.form.include_momentjs', $config['include_momentjs']);
        $container->setParameter('admingenerator.form.include_blueimp', $config['include_blueimp']);
        $container->setParameter('admingenerator.form.include_gmaps', $config['include_gmaps']);

        $this->configureAssetsExtension($container, $config['upload_manager'], $config['image_manipulator']);

        $this->configureFormExtensions($config['extensions'], $container);

        $this->loadUploadCollectionListener($config['upload_collection'], $container);

        $this->loadGlobalsExtension($container);
    }

    /**
     * Register the form extensions if required
     */
    private function configureFormExtensions(array $config, ContainerBuilder $container): void
    {
        if ($config['autocomplete']) {
            $this->registerExtension($container, 'form.type_extension.autocomplete', AutocompleteExtension::class);
        }
        if ($config['bootstrap_select']) {
            $this->registerExtension($container, 'form.type_extension.bootstrap_select', BootstrapSelectExtension::class, ChoiceType::class);
        }
        if ($config['help_message']) {
            $this->registerExtension($container, 'form.type_extension.help_message', HelpMessageExtension::class);
        }
        if ($config['no_validate']) {
            $this->registerExtension($container, 'form.type_extension.novalidate', NoValidateExtension::class);
        }
        if ($config['single_upload']) {
            $this->registerExtension($container, 'form.type_extension.single_upload', SingleUploadExtension::class);
        }
    }

    /**
     * Add the collection upload listener if required
     */
    private function loadUploadCollectionListener(array $config, ContainerBuilder $container): void
    {
        if ($config['async_listener_enabled']) {
            if (!(array_key_exists('async_route_name', $config) && $routeName = $config['async_route_name'])) {
                throw new \LogicException('async_route_name must be defined when async_listener_enabled is true');
            }

            $collectionUploadListenerDefinition = new Definition('%admingenerator.form.upload_collection_listener.class%');
            $collectionUploadListenerDefinition->setArguments(array(
                    new Reference($config['file_storage']),
                    $routeName,
                    new Reference('property_accessor')
            ));
            $collectionUploadListenerDefinition->addTag('kernel.event_subscriber');
            $container->setDefinition('admingenerator.form.upload_collection_listener', $collectionUploadListenerDefinition);

            $container->getDefinition('admingenerator.form.extensions.type.upload_collection')->addMethodCall('setFileStorage', array(new Reference($config['file_storage'])));
        }
    }

    private function registerExtension(ContainerBuilder $container, string $serviceId, string $extensionClass, string $extendedTypeClass = FormType::class): void
    {
        $extensionDefinition = new Definition($extensionClass);
        $extensionDefinition->addTag('form.type_extension', [
            'extended-type' => $extendedTypeClass,
        ]);
        $container->setDefinition($serviceId, $extensionDefinition);
    }

    private function configureAssetsExtension(ContainerBuilder $container, string $uploadManager, string $imageManipulator): void
    {
        $uploaderHelperDefinition = null;
        $imageExtensionDefinition = null;
        if ('vich_uploader' === $uploadManager) {
            if ($container->hasDefinition('vich_uploader.templating.helper.uploader_helper') || $container->hasAlias('vich_uploader.templating.helper.uploader_helper')) {
                $uploaderHelperDefinition = $container->findDefinition('vich_uploader.templating.helper.uploader_helper');
            } else {
                $uploaderHelperDefinition = new Reference(\Vich\UploaderBundle\Templating\Helper\UploaderHelper::class);
            }
        }
        if ('liip_imagine' === $imageManipulator) {
            if (class_exists('\Liip\ImagineBundle\Templating\ImagineExtension')) {
                $imageExtensionDefinition = new Reference('liip_imagine.twig.extension');
            } else {
                $imageExtensionDefinition = new Reference('liip_imagine.templating.filter_extension');
            }
        } else if ('avalanche_imagine' === $imageManipulator) {
            $imageExtensionDefinition = new Reference('imagine.twig.extension');
        }

        $assetsExtensionDefinition = new Definition(ImageAssetsExtension::class);
        $assetsExtensionDefinition->setArgument('$uploaderExtension', $uploaderHelperDefinition);
        $assetsExtensionDefinition->setArgument('$filterExtension', $imageExtensionDefinition);
        $assetsExtensionDefinition->addTag('twig.extension');
        $container->setDefinition('admingenerator.twig.extension.image_assets', $assetsExtensionDefinition);
    }

    private function loadGlobalsExtension(ContainerBuilder $container): void
    {
        $globalsExtensionDefinition = new Definition(IncludeGlobalsExtension::class);
        $globalsExtensionDefinition->setArgument('$container', new Reference('service_container'));
        $globalsExtensionDefinition->addTag('twig.extension');
        $container->setDefinition('admingenerator.twig.extension.include_globals', $globalsExtensionDefinition);
    }
}
