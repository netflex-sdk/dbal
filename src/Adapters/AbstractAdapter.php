<?php

namespace Netflex\DBAL\Adapters;

use Closure;
use Netflex\DBAL\Contracts\DatabaseAdapter;
use Netflex\DBAL\PDOStatement;
use RuntimeException;

abstract class AbstractAdapter implements DatabaseAdapter
{
    public function select(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('This connnection does not implement select');
    }

    public function insert(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('This connnection does not implement insert');
    }

    public function update(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('This connnection does not implement update');
    }

    public function delete(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('This connnection does not implement delete');
    }

    public function tableExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        return false;
    }

    public function createTable(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connnection does not implement create table');
    }

    public function dropTable(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connnection does not implement drop table');
    }

    public function dropTableIfExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        return false;
    }

    public function selectColumns(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connnection does not implement columns');
    }

    public function columnExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        return false;
    }

    public function addColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connnection does not implement add column');
    }

    public function alterColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connnection does not implement alter column');
    }

    public function dropColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connnection does not implement drop column');
    }

    public function dropColumnIfExists(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        return false;
    }
}
