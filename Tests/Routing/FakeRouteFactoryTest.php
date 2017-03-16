<?php

namespace Rpodwika\FakeRestServerBundle\Tests;

use PHPUnit\Framework\TestCase;
use Rpodwika\FakeRestServerBundle\Routing\FakeRouteFactory;


class FakeRouteFactoryTest extends TestCase
{
    public function testCreateGetRoute()
    {
        $fakeRouteFactory = new FakeRouteFactory();
        $route = $fakeRouteFactory->createGetRoute("user");

        $this->assertTrue(in_array('GET', $route->getMethods()));
        $this->assertCount(1, $route->getMethods());
        $this->assertEquals('/user/{user}', $route->getPath());
    }

    public function testCreatePostRoute()
    {
        $fakeRouteFactory = new FakeRouteFactory();
        $route = $fakeRouteFactory->createPostRoute("user");

        $this->assertTrue(in_array('POST', $route->getMethods()));
        $this->assertCount(1, $route->getMethods());
        $this->assertEquals('/user', $route->getPath());
    }

    public function testCreatePutRoute()
    {
        $fakeRouteFactory = new FakeRouteFactory();
        $route = $fakeRouteFactory->createPutRoute("user");

        $this->assertTrue(in_array('PUT', $route->getMethods()));
        $this->assertCount(1, $route->getMethods());
        $this->assertEquals('/user/{user}', $route->getPath());
    }

    public function testCreateDeleteRoute()
    {
        $fakeRouteFactory = new FakeRouteFactory();
        $route = $fakeRouteFactory->createDeleteRoute("user");

        $this->assertTrue(in_array('DELETE', $route->getMethods()));
        $this->assertCount(1, $route->getMethods());
        $this->assertEquals('/user/{user}', $route->getPath());
    }

    public function testCreateHeadRoute()
    {
        $fakeRouteFactory = new FakeRouteFactory();
        $route = $fakeRouteFactory->createHeadRoute("user");

        $this->assertTrue(in_array('HEAD', $route->getMethods()));
        $this->assertCount(1, $route->getMethods());
        $this->assertEquals('/user/{user}', $route->getPath());
    }

    public function testCreateOptionsRoute()
    {
        $fakeRouteFactory = new FakeRouteFactory();
        $route = $fakeRouteFactory->createOptionsRoute("user");

        $this->assertTrue(in_array('OPTIONS', $route->getMethods()));
        $this->assertCount(1, $route->getMethods());
        $this->assertEquals('/user/{user}', $route->getPath());
    }
}
