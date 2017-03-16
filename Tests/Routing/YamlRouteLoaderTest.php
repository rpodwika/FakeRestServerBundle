<?php

namespace Rpodwika\FakeRestServerBundle\Tests;

use PHPUnit\Framework\TestCase;
use Rpodwika\FakeRestServerBundle\Database\DatabaseProviderInterface;
use Rpodwika\FakeRestServerBundle\Routing\FakeRouteFactory;
use Rpodwika\FakeRestServerBundle\Routing\YamlRouteLoader;
use Symfony\Component\Routing\Route;


class YamlRouteLoaderTest extends TestCase
{
    public function testSupports()
    {
        $yamlRouteLoader = new YamlRouteLoader($this->createDatabaseProvider(), $this->createFakeFactory());

        $this->assertFalse($yamlRouteLoader->supports(null, 'xyz'));
        $this->assertTrue($yamlRouteLoader->supports(null, 'fake_rest_server'));
    }

    public function testLoadMethod()
    {
        $databaseProvider = $this->createDatabaseProvider();
        $schema = $databaseProvider->getDatabaseSchema();
        $yamlRouteLoader = new YamlRouteLoader($databaseProvider, $this->createFakeFactory());
        $routeCollection = $yamlRouteLoader->load(null);

        $this->assertCount(6, $routeCollection);

        $expectedNames = [];
        $expectedNames[] = YamlRouteLoader::ROUTE_PREFIX . "_GET_%s";
        $expectedNames[] = YamlRouteLoader::ROUTE_PREFIX . "_POST_%s";
        $expectedNames[] = YamlRouteLoader::ROUTE_PREFIX . "_PUT_%s";
        $expectedNames[] = YamlRouteLoader::ROUTE_PREFIX . "_DELETE_%s";
        $expectedNames[] = YamlRouteLoader::ROUTE_PREFIX . "_HEAD_%s";
        $expectedNames[] = YamlRouteLoader::ROUTE_PREFIX . "_OPTIONS_%s";
        $routeNames = array_keys($routeCollection->getIterator()->getArrayCopy());
        $endpointName = key($schema);

        array_walk($expectedNames, function (&$element) use ($endpointName) {
            $element = sprintf($element, $endpointName);
        });

        $this->assertCount(6, $routeNames);
        $this->assertEquals($expectedNames, $routeNames);
    }

    private function createDatabaseProvider()
    {
        $databaseProvider = $this
            ->getMockBuilder(DatabaseProviderInterface::class)
            ->getMock();

        $databaseProvider->method('getDataBaseSchema')
            ->willReturn([
                'user' => [
                    ['id' => 5, 'name' => 'John'],
                    ['id' => 6, 'name' => 'Jane'],
                ]

            ]);

        return $databaseProvider;
    }

    private function createFakeFactory()
    {
        $fakeRouteFactory = $this->getMockBuilder(FakeRouteFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fakeRouteFactory->method('createGetRoute')
            ->willReturn(new Route('test'));

        $fakeRouteFactory->method('createPostRoute')
            ->willReturn(new Route('test'));

        $fakeRouteFactory->method('createPostRoute')
            ->willReturn(new Route('test'));

        $fakeRouteFactory->method('createPutRoute')
            ->willReturn(new Route('test'));

        $fakeRouteFactory->method('createDeleteRoute')
            ->willReturn(new Route('test'));

        $fakeRouteFactory->method('createOptionsRoute')
            ->willReturn(new Route('test'));

        return $fakeRouteFactory;
    }

}
