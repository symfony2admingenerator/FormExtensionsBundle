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
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('admingenerator_form_extensions');

        $treeBuilder->getRootNode()
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
                ->arrayNode('extensions')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('autocomplete')->defaultTrue()->end()
                        ->booleanNode('bootstrap_select')->defaultTrue()->end()
                        ->booleanNode('help_message')->defaultTrue()->end()
                        ->booleanNode('no_validate')->defaultTrue()->end()
                        ->booleanNode('single_upload')->defaultTrue()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
