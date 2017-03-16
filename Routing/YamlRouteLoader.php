<?php

declare(strict_types = 1);

namespace Rpodwika\FakeRestServerBundle\Routing;

use Rpodwika\FakeRestServerBundle\Database\DatabaseProviderInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

final class YamlRouteLoader extends Loader
{
    const ROUTE_PREFIX = 'FAKE_SERVER';
    const ROUTE_TYPE = 'fake_rest_server';

    /**
     * @var DatabaseProviderInterface
     */
    private $databaseProvider;

    /**
     * @var FakeRouteFactory
     */
    private $fakeRouteFactory;

    /**
     * YamlRouteLoader constructor.
     *
     * @param DatabaseProviderInterface $databaseProvider
     * @param FakeRouteFactory $fakeRouteFactory
     */
    public function __construct(DatabaseProviderInterface $databaseProvider, FakeRouteFactory $fakeRouteFactory) {
        $this->databaseProvider = $databaseProvider;
        $this->fakeRouteFactory = $fakeRouteFactory;
    }

    /**
     * Load routes based on database schema
     *
     * @param mixed $resource
     * @param null $type
     * @return RouteCollection
     *
     * @throws \Exception
     */
    public function load($resource, $type = null) : RouteCollection
    {
        $databaseSchema = $this->databaseProvider->getDatabaseSchema();
        $collection = new RouteCollection();

        foreach ($databaseSchema as $endpointName => $data) {
            foreach ($data as $id => $object) {
                $collection->add(
                    self::ROUTE_PREFIX . "_GET_" . $endpointName,
                    $this->fakeRouteFactory->createGetRoute($endpointName)
                );
                $collection->add(
                    self::ROUTE_PREFIX . "_POST_" . $endpointName,
                    $this->fakeRouteFactory->createPostRoute($endpointName)
                );
                $collection->add(
                    self::ROUTE_PREFIX . "_PUT_" . $endpointName,
                    $this->fakeRouteFactory->createPutRoute($endpointName)
                );
                $collection->add(
                    self::ROUTE_PREFIX . "_DELETE_" . $endpointName,
                    $this->fakeRouteFactory->createDeleteRoute($endpointName)
                );
                $collection->add(
                    self::ROUTE_PREFIX . "_HEAD_" . $endpointName,
                    $this->fakeRouteFactory->createHeadRoute($endpointName)
                );
                $collection->add(
                    self::ROUTE_PREFIX . "_OPTIONS_" . $endpointName,
                    $this->fakeRouteFactory->createOptionsRoute($endpointName)
                );
            }
        }

        return $collection;
    }

    /**
     * @inheritdoc
     */
    public function supports($resource, $type = null): bool
    {
        return self::ROUTE_TYPE === $type;
    }

}
