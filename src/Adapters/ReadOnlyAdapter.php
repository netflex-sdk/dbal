<?php

namespace Netflex\Database\DBAL\Adapters;

use Closure;
use RuntimeException;

use Netflex\Database\DBAL\PDOStatement;
use Netflex\Database\DBAL\Concerns\PerformsQueries;

final class ReadOnlyAdapter extends AbstractAdapter
{
    use PerformsQueries;

    public function insert(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('This connection is read-only');
    }

    public function update(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('This connection is read-only');
    }

    public function delete(PDOStatement $statement, array $arguments, Closure $closure): bool
    {
        throw new RuntimeException('This connection is read-only');
    }


    public function createTable(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connection is read-only');
    }

    public function dropTable(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connection is read-only');
    }

    public function selectColumns(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connection is read-only');
    }

    public function addColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connection is read-only');
    }

    public function alterColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connection is read-only');
    }

    public function dropColumn(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        throw new RuntimeException('This connection is read-only');
    }
}
