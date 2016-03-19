<?php

namespace Admingenerator\FormExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Validates and merges configuration
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('admingenerator_form_extensions');

        $rootNode
            ->children()
                ->scalarNode('upload_manager')->defaultNull()->end()
                ->scalarNode('image_manipulator')->defaultNull()->end()
                ->arrayNode('twig')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('use_form_resources')->defaultTrue()->end()
                    ->end()
                ->end()
                ->arrayNode('upload_collection')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('async_listener_enabled')->defaultFalse()->end()
                        ->scalarNode('async_route_name')->end() // TODO: add dynamic validation: if async_listener_enabled: true, this parameter should not be empty
                        ->scalarNode('file_storage')->defaultValue('admingenerator.form.file_storage.local')->end() // TODO: add dynamic validation
                    ->end()
                ->end()
                ->booleanNode('include_jquery')->defaultFalse()->end()
                ->booleanNode('include_jqueryui')->defaultFalse()->end()
                ->booleanNode('include_momentjs')->defaultFalse()->end()
                ->booleanNode('include_blueimp')->defaultFalse()->end()
                ->booleanNode('include_gmaps')->defaultFalse()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
