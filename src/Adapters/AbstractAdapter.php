<?php

namespace Netflex\Database\DBAL\Adapters;

use Closure;
use RuntimeException;

use Netflex\Database\DBAL\PDOStatement;
use Netflex\Database\DBAL\Contracts\DatabaseAdapter;
use Netflex\Database\Driver\Connection;

abstract class AbstractAdapter implements DatabaseAdapter
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function select(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('Method [' . __FUNCTION__ . '] not implemented for connection [' . $this->connection->getName() . '] (Adapter: ' . get_class($this->connection->getAdapter()) . ')');
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
        return false;
    }

    public function selectColumns(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method [' . __FUNCTION__ . '] not implemented for connection [' . $this->connection->getName() . '] (Adapter: ' . get_class($this->connection->getAdapter()) . ')');
    }

    public function columnExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
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
        return false;
    }
}
