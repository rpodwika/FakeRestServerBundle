<?php

declare(strict_types = 1);

namespace Rpodwika\FakeRestServerBundle\Parser;

use Exception;
use Rpodwika\FakeRestServerBundle\Exception\FileNotFoundException;
use Rpodwika\FakeRestServerBundle\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlParser implements ParserInterface
{
    /**
     * Parse YAML file
     *
     * @param string $file
     *
     * @return array|null
     *
     * @throws Exception
     */
    public function parseFile(string $file): ?array
    {
        if (false === file_exists($file)) {
            throw new FileNotFoundException(sprintf("Could not find database file %s", $file));
        }

        try {
            $fileContent = file_get_contents($file);

            if (false === $fileContent) {
                throw new Exception("File could not be read");
            }

            return Yaml::parse($fileContent);
        } catch (Exception $exception) {
            throw new ParseException(sprintf("File %s could not be parsed as valid schema", $file));
        }
    }
}
