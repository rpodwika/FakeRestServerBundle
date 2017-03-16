<?php

declare(strict_types = 1);

namespace Rpodwika\FakeRestServerBundle\Routing;

use Symfony\Component\Routing\Route;

class FakeRouteFactory
{
    /**
     * Create GET method route
     *
     * @param string $endpointName
     *
     * @return Route
     */
    public function createGetRoute(string $endpointName) : Route
    {
        $route = $this->createGenericRoute($endpointName);

        $route
            ->setMethods(['GET'])
            ->setDefault('_controller', 'FakeRestServerBundle:FakeServerApi:get')
        ;

        return $route;
    }

    /**
     * Create POST method route
     *
     * @param string $endpointName
     *
     * @return Route
     */
    public function createPostRoute(string $endpointName) : Route
    {
        $route = new Route($endpointName);

        $route
            ->setPath($endpointName)
            ->setRequirements([])
            ->setDefault('_endpoint', $endpointName)
            ->setMethods(['POST'])
            ->setDefault('_controller', 'FakeRestServerBundle:FakeServerApi:post')
        ;

        return $route;
    }

    /**
     * Create PUT method route
     *
     * @param string $endpointName
     *
     * @return Route
     */
    public function createPutRoute(string $endpointName) : Route
    {
        $route = $this->createGenericRoute($endpointName);

        $route
            ->setMethods(['PUT'])
            ->setDefault('_controller', 'FakeRestServerBundle:FakeServerApi:put')
        ;

        return $route;
    }

    /**
     * Create PUT method route
     *
     * @param string $endpointName
     *
     * @return Route
     */
    public function createDeleteRoute(string $endpointName) : Route
    {
        $route = $this->createGenericRoute($endpointName);

        $route
            ->setMethods(['DELETE'])
            ->setDefault('_controller', 'FakeRestServerBundle:FakeServerApi:delete')
        ;

        return $route;
    }

    /**
     * Create HEAD method route
     *
     * @param string $endpointName
     *
     * @return Route
     */
    public function createHeadRoute(string $endpointName) : Route
    {
        $route = $this->createGenericRoute($endpointName);

        $route
            ->setMethods(['HEAD'])
            ->setDefault('_controller', 'FakeRestServerBundle:FakeServerApi:head')
        ;

        return $route;
    }

    /**
     * Create OPTIONS method route
     *
     * @param string $endpointName
     *
     * @return Route
     */
    public function createOptionsRoute(string $endpointName) : Route
    {
        $route = $this->createGenericRoute($endpointName);

        $route
            ->setMethods(['OPTIONS'])
            ->setDefault('_controller', 'FakeRestServerBundle:FakeServerApi:options')
        ;

        return $route;
    }

    /**
     * Create generic route
     *
     * @param string $endpointName
     *
     * @return Route
     */
    private function createGenericRoute(string $endpointName): Route
    {
        return new Route(
            sprintf('%s/{%s}',
                $endpointName,
                $endpointName
            ),
            [],
            [$endpointName => '\d+',],
            [],
            '',
            [],
            ['GET']
        );
    }
}
