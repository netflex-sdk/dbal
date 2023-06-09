<?php

namespace Netflex\Database\DBAL\Doctrine;

use Netflex\Database\DBAL\Column;
use Netflex\Database\DBAL\Contracts\Connection;
use Netflex\Database\DBAL\Grammars\SelectColumns;

use Doctrine\DBAL\Connection as DoctrineConnection;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column as DoctrineColumn;

class SchemaManager extends AbstractSchemaManager
{
    protected $connection;

    public function __construct(Connection $connection, DoctrineConnection $doctrineConnection)
    {
        parent::__construct($doctrineConnection, new Platform);
        $this->connection = $connection;
    }

    /**
     * @param Column $tableColumn
     * @return DoctrineColumn
     */
    protected function _getPortableTableColumnDefinition($tableColumn)
    {
        return $tableColumn->toDoctrineColumn();
    }

    public function listTableColumns($table, $database = null)
    {
        $pdo = $this->connection->getPdo();
        $statement = $pdo->prepare(SelectColumns::compile($this->connection, $table));
        $statement->execute();
        $fields = $statement->fetchAll();

        return array_map(fn ($field) => $this->_getPortableTableColumnDefinition($field), $fields);
    }

    public function listTableForeignKeys($table, $database = null)
    {
        return [];
    }

    public function listTableIndexes($table, $currentDatabase = null)
    {
        return [];
    }
}
