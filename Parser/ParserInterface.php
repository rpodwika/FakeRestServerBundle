<?php

declare(strict_types = 1);

namespace Rpodwika\FakeRestServerBundle\Parser;

use Rpodwika\FakeRestServerBundle\Exception\FileNotFoundException;
use Rpodwika\FakeRestServerBundle\Exception\ParseException;

interface ParserInterface
{
    /**
     * Parse file
     *
     * @param string $file
     *
     * @return array|null
     *
     * @throws ParseException
     * @throws FileNotFoundException
     */
    public function parseFile(string $file): ?array;
}
