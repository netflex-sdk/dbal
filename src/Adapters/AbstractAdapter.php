<?php

namespace Netflex\DBAL\Adapters;

use Closure;
use RuntimeException;

use Netflex\DBAL\PDOStatement;
use Netflex\DBAL\Contracts\DatabaseAdapter;

abstract class AbstractAdapter implements DatabaseAdapter
{
    public function select(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('Method not implemented [' . __FUNCTION__ . ']');
    }

    public function insert(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('Method not implemented [' . __FUNCTION__ . ']');
    }

    public function update(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('Method not implemented [' . __FUNCTION__ . ']');
    }

    public function delete(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('Method not implemented [' . __FUNCTION__ . ']');
    }

    public function tableExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        return false;
    }

    public function createTable(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method not implemented [' . __FUNCTION__ . ']');
    }

    public function dropTable(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method not implemented [' . __FUNCTION__ . ']');
    }

    public function dropTableIfExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        return false;
    }

    public function selectColumns(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method not implemented [' . __FUNCTION__ . ']');
    }

    public function columnExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        return false;
    }

    public function addColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method not implemented [' . __FUNCTION__ . ']');
    }

    public function alterColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method not implemented [' . __FUNCTION__ . ']');
    }

    public function dropColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('Method not implemented [' . __FUNCTION__ . ']');
    }

    public function dropColumnIfExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        return false;
    }
}
