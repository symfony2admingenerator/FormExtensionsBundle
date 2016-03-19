<?php

namespace Admingenerator\FormExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

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
    public function load(array $configs, ContainerBuilder $container)
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

        $this->loadUploadCollectionListener($config['upload_collection'], $container);
    }

    /**
     * Add the collection upload listener if required
     *
     * @param array $config
     * @param ContainerBuilder $container
     * @throws \LogicException
     */
    private function loadUploadCollectionListener(array $config, ContainerBuilder $container)
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
}
