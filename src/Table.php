<?php

namespace Netflex\Database\DBAL;

use Illuminate\Support\Str;
use Netflex\Database\DBAL\Contracts\Connection;

final class Table
{
    public static function normalizeIndexName($name)
    {
        if (Str::startsWith($name, 'entry_')) {
            return Str::after($name, 'entry_');
        }

        return $name;
    }

    public static function normalizeName($name)
    {
        return Str::replace('_', ' ', Str::title($name));
    }

    public static function getReservedTableNames(Connection $connection): array
    {
        return $connection->getAdapter()->getReservedTableNames();
    }
}
