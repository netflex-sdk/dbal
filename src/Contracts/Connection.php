<?php

namespace Netflex\Database\DBAL\Contracts;

use Illuminate\Database\ConnectionInterface;

use Netflex\Database\DBAL\PDO;
use Netflex\Database\DBAL\Contracts\DatabaseAdapter;

interface Connection extends ConnectionInterface
{
    public function getAdapter(): DatabaseAdapter;

    /** @return string */
    public function getTablePrefix();

    /**
     * @param string $prefix
     * @return Connection
     * */
    public function setTablePrefix($prefix);

    /** @return PDO */
    public function getPdo();

    /** @return string|null */
    public function getName();
}
