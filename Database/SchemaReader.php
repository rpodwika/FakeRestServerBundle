<?php

declare(strict_types = 1);

namespace Rpodwika\FakeRestServerBundle\Database;

class SchemaReader
{
    /**
     * @var DatabaseProviderInterface
     */
    private $databaseProvider;

    /**
     * SchemaReader constructor.
     *
     * @param DatabaseProviderInterface $databaseProvider
     */
    public function __construct(DatabaseProviderInterface $databaseProvider)
    {
        $this->databaseProvider = $databaseProvider;
    }

    /**
     * Find element in multidimensional array with type and id
     *
     * @param string $type
     * @param int $id
     *
     * @return array|null
     */
    public function find(string $type, int $id) : ?array
    {
        $databaseSchema = $this->databaseProvider->getDatabaseSchema();

        if (empty($databaseSchema)) {
            return null;
        }

        if (is_array($databaseSchema[$type])) {
            $needleKey = array_search($id, array_column($databaseSchema[$type], 'id'));

            if (false !== $needleKey) {
                return $databaseSchema[$type][$needleKey];
            }
        }

        return null;
    }
}
