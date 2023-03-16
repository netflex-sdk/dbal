<?php

namespace Netflex\Database\DBAL\Contracts;

use Closure;

use Netflex\Database\DBAL\Column;
use Netflex\Database\DBAL\PDOStatement;

interface DatabaseAdapter
{
    public function select(PDOStatement $statement, array $arguments, Closure $closure): bool;
    public function insert(PDOStatement $statement, array $arguments, Closure $closure): bool;
    public function update(PDOStatement $statement, array $arguments, Closure $closure): bool;
    public function delete(PDOStatement $statement, array $arguments, Closure $closure): bool;

    public function tableExists(PDOStatement $statement, array $arguments, Closure $callback): bool;
    public function createTable(PDOStatement $statement, array $arguments, Closure $callback): bool;
    public function dropTable(PDOStatement $statement, array $arguments, Closure $callback): bool;
    public function dropTableIfExists(PDOStatement $statement, array $arguments, Closure $callback): bool;

    /** @return array */
    public function getReservedColumns(): array;

    /** @return string[] */
    public function getReservedTableNames(): array;

    public function selectColumns(PDOStatement $statement, array $arguments, Closure $callback): bool;
    public function columnExists(PDOStatement $statement, array $arguments, Closure $callback): bool;
    public function addColumn(PDOStatement $statement, array $arguments, Closure $callback): bool;
    public function alterColumn(PDOStatement $statement, array $arguments, Closure $callback): bool;
    public function dropColumn(PDOStatement $statement, array $arguments, Closure $callback): bool;
    public function dropColumnIfExists(PDOStatement $statement, array $arguments, Closure $callback): bool;
}
