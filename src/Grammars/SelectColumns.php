<?php

namespace Netflex\Database\DBAL\Grammars;

use Illuminate\Support\Str;

use Netflex\Database\DBAL\Command;
use Netflex\Database\DBAL\Contracts\Connection;

class SelectColumns
{
    /**
     * Compile a alter field command.
     * @return array
     */
    public static function compile(Connection $connection, string $table)
    {
        $prefix = $connection->getTablePrefix();

        if (Str::startsWith($table, $prefix)) {
            $table = Str::after($table, $prefix);;
        }

        return [
            'command' => Command::TABLE_COLUMNS_SELECT,
            'arguments' => [
                'table' => $table,
            ]
        ];
    }
}
