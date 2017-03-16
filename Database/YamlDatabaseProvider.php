<?php

declare(strict_types = 1);

namespace Rpodwika\FakeRestServerBundle\Database;

use Exception;
use Rpodwika\FakeRestServerBundle\Exception\FileNotFoundException;
use Rpodwika\FakeRestServerBundle\Exception\ParseException;
use Rpodwika\FakeRestServerBundle\Parser\ParserInterface;
use Symfony\Component\HttpKernel\KernelInterface;

final class YamlDatabaseProvider implements DatabaseProviderInterface
{
    /**
     * @var string
     */
    private $jsonFilePath;

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @var string
     */
    private $resourcesPath;

    /**
     * YamlDatabaseProvider constructor.
     *
     * @param string $jsonFilePath
     * @param KernelInterface $kernel
     * @param string $resourcesPath
     */
    public function __construct(
        string $jsonFilePath,
        KernelInterface $kernel,
        ParserInterface $parser,
        string $resourcesPath = null
    ) {
        $this->setYamlFilePath($jsonFilePath);

        $this->kernel = $kernel;
        $this->parser = $parser;
        $this->resourcesPath = $resourcesPath;
    }

    /**
     * @return array
     */
    public function getDatabaseSchema(): array
    {
        return $this->readFile();
    }

    /**
     * Set YAML file path.
     *
     * @param string $jsonFilePath
     */
    public function setYamlFilePath(string $jsonFilePath): void
    {
        $this->jsonFilePath = $jsonFilePath;
    }

    /**
     * Return a path to a directory where a database file is located.
     *
     * @return string
     */
    public function getResourcesPath() : string
    {
        if (null === $this->resourcesPath) {
            $this->resourcesPath = $this->kernel->getRootDir() . DIRECTORY_SEPARATOR . 'Resources';
        }

        return $this->resourcesPath;
    }

    /**
     * Read a YAML file with database schema.
     * If file is not found then FileNotFound exception is thrown.
     *
     * @return array
     *
     * @throws ParseException|FileNotFoundException|Exception
     */
    private function readFile(): ?array
    {
        $dataBaseFile = $this->getResourcesPath() . DIRECTORY_SEPARATOR . $this->jsonFilePath;

        return $this->parser->parseFile($dataBaseFile);
    }
}
