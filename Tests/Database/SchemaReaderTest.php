<?php

namespace Rpodwika\FakeRestServerBundle\Tests;

use Rpodwika\FakeRestServerBundle\Database\DatabaseProviderInterface;
use Rpodwika\FakeRestServerBundle\Database\SchemaReader;
use PHPUnit\Framework\TestCase;

class SchemaReaderTest extends TestCase
{
    public function testFindReturnsNull()
    {
        $dataBaseProviderMock = $this->getMockBuilder(DatabaseProviderInterface::class)
            ->setMethods(['getDatabaseSchema'])
            ->getMock();

        $dataBaseProviderMock->method('getDatabaseSchema')
            ->willReturn([]);

        $schemaReader = new SchemaReader($dataBaseProviderMock);

        $this->assertNull($schemaReader->find('testing', 5));
    }

    public function testFindReturnsNullWithIncompleteData()
    {
        $dataBaseProviderMock = $this->getMockBuilder(DatabaseProviderInterface::class)
            ->setMethods(['getDatabaseSchema'])
            ->getMock();

        $dataBaseProviderMock->method('getDatabaseSchema')
            ->willReturn([
                'testing' => []
            ]);

        $schemaReader = new SchemaReader($dataBaseProviderMock);

        $this->assertNull($schemaReader->find('testing', 5));
    }

    public function testFindReturnsCompleteObject()
    {
        $dataBaseProviderMock = $this->getMockBuilder(DatabaseProviderInterface::class)
            ->setMethods(['getDatabaseSchema'])
            ->getMock();

        $userArr = [
            'id' => 5,
            'name'=> 'test'
        ];

        $dataBaseProviderMock->method('getDatabaseSchema')
            ->willReturn([
                'user' => [
                    $userArr
                ]
            ]);

        $schemaReader = new SchemaReader($dataBaseProviderMock);
        $user = $schemaReader->find('user', '5');

        $this->assertInternalType('array', $user);
        $this->assertNotEmpty($user);
        $this->assertArraySubset($userArr, $user);
    }
}
