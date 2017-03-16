<?php

namespace Rpodwika\FakeRestServerBundle\Tests;

use PHPUnit\Framework\TestCase;
use Rpodwika\FakeRestServerBundle\Database\YamlDatabaseProvider;
use Rpodwika\FakeRestServerBundle\Parser\ParserInterface;
use Symfony\Component\HttpKernel\KernelInterface;


class YamlDatabaseProviderTest extends TestCase
{
    public function testCustomResourcesPath()
    {
        $custompath = 'custom/path';

        $yamlDatabaseProvider = new YamlDatabaseProvider(
            'json.json',
            $this->createKernelMock(),
            $this->createParserMock(),
            $custompath
        );

        $this->assertEquals($custompath, $yamlDatabaseProvider->getResourcesPath());
    }

    public function testGetDatabaseSchema()
    {
        $yamlDatabaseProvider = new YamlDatabaseProvider(
            'json.json',
            $this->createKernelMock(),
            $this->createParserMock()
        );

        $data = $yamlDatabaseProvider->getDatabaseSchema();

        $this->assertInternalType('array', $data);
    }

    private function createKernelMock()
    {
        $kernelMock = $this
            ->getMockBuilder(KernelInterface::class)
            ->getMock();

        $kernelMock
            ->method('getRootDir')
            ->willReturn('/path')
        ;

        return $kernelMock;
    }

    private function createParserMock()
    {
        $parserMock = $this
            ->getMockBuilder(ParserInterface::class)
            ->getMock();

        $parserMock->method('parseFile')
            ->willReturn([
                'schema' => [
                    'sample' =>
                        ['id' => 5, 'name' => 'John'],
                        ['id' => 6, 'name' => 'Jane'],
                    ]
            ]);

        return $parserMock;
    }
}
