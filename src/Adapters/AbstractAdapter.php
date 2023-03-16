<?php

namespace Netflex\Database\DBAL\Adapters;

use Closure;
use RuntimeException;

use Netflex\Database\DBAL\Column;
use Netflex\Database\DBAL\PDOStatement;
use Netflex\Database\DBAL\Concerns\PerformsQueries;
use Netflex\Database\DBAL\Contracts\DatabaseAdapter;
use Netflex\Database\DBAL\Contracts\Connection;

use Illuminate\Support\Str;

abstract class AbstractAdapter implements DatabaseAdapter
{
    use PerformsQueries {
        select as performSelect;
    }

    protected Connection $connection;

    protected string $tablePrefix = '';
    protected array $reservedFields = [];
    protected array $reservedTableNames = [];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->setTablePrefix();
    }

    protected function setTablePrefix()
    {
        if ($tablePrefix = $this->tablePrefix) {
            $connection = $this->connection;

            if (!$connection->getTablePrefix() || !Str::startsWith($connection->getTablePrefix(), $tablePrefix)) {
                $connection->setTablePrefix($tablePrefix . $connection->getTablePrefix());
            }
        }
    }

    protected function getTableName(string $table): string
    {
        return $table;
    }

    public function select(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        $arguments['table'] = $this->getTableName($arguments['table']);

        return $this->performSelect($statement, $arguments, $callback);
    }

    public function insert(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('Method [' . __FUNCTION__ . '] not implemented for connection [' . $this->connection->getName() . '] (Adapter: ' . get_class($this->connection->getAdapter()) . ')');
    }

    public function update(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('Method [' . __FUNCTION__ . '] not implemented for connection [' . $this->connection->getName() . '] (Adapter: ' . get_class($this->connection->getAdapter()) . ')');
    }

    public function delete(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('Method [' . __FUNCTION__ . '] not implemented for connection [' . $this->connection->getName() . '] (Adapter: ' . get_class($this->connection->getAdapter()) . ')');
    }

    public function tableExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        return false;
    }

    public function createTable(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method [' . __FUNCTION__ . '] not implemented for connection [' . $this->connection->getName() . '] (Adapter: ' . get_class($this->connection->getAdapter()) . ')');
    }

    public function dropTable(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method [' . __FUNCTION__ . '] not implemented for connection [' . $this->connection->getName() . '] (Adapter: ' . get_class($this->connection->getAdapter()) . ')');
    }

    public function dropTableIfExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        if ($this->tableExists($statement, $arguments, $callback)) {
            return $this->dropTable($statement, $arguments, $callback);
        }

        return false;
    }

    public function getReservedColumns(): array
    {
        return $this->reservedFields;
    }

    public function getReservedTableNames(): array
    {
        return $this->reservedTableNames;
    }

    public function selectColumns(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        $fields = Column::getReservedColumns($this->connection);

        $callback($fields);

        return true;
    }

    public function columnExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        $columns = [];

        $this->selectColumns($statement, $arguments, function ($fields) use (&$columns) {
            $columns = $fields;
        });

        foreach ($columns as $column) {
            if ($column === $arguments['column']) {
                return true;
            }
        }

        return false;
    }

    public function addColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method [' . __FUNCTION__ . '] not implemented for connection [' . $this->connection->getName() . '] (Adapter: ' . get_class($this->connection->getAdapter()) . ')');
    }

    public function alterColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method [' . __FUNCTION__ . '] not implemented for connection [' . $this->connection->getName() . '] (Adapter: ' . get_class($this->connection->getAdapter()) . ')');
    }

    public function dropColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method [' . __FUNCTION__ . '] not implemented for connection [' . $this->connection->getName() . '] (Adapter: ' . get_class($this->connection->getAdapter()) . ')');
    }

    public function dropColumnIfExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        if ($this->columnExists($statement, $arguments, $callback)) {
            return $this->dropColumn($statement, $arguments, $callback);
        }

        return false;
    }
}
