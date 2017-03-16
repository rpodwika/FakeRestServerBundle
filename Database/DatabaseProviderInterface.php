<?php

declare(strict_types = 1);

namespace Rpodwika\FakeRestServerBundle\Database;

interface DatabaseProviderInterface
{
    /**
     * Method must return PHP array with database schema
     *
     * @return array
     */
    public function getDatabaseSchema(): array;
}