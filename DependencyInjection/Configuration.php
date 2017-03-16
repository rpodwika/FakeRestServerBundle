<?php

namespace Rpodwika\FakeRestServerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fake_rest_server');

        $rootNode->children()
            ->scalarNode('database_file')
                ->info('This is path to file where you define your database to serve your API')
                ->cannotBeEmpty()
                ->isRequired()
            ->end()
            ->enumNode('route_format')
                ->info('Here you define in what format database_file is provided supported formats are yml, json, array')
                ->cannotBeEmpty()
                ->defaultValue('yml')
                ->values(['yml', 'json', 'array'])
            ->end()
        ;
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
