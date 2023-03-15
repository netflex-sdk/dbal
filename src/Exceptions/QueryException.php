<?php

namespace Netflex\Database\DBAL\Exceptions;

use Throwable;
use Illuminate\Database\QueryException as Exception;

class QueryException extends Exception
{
    /**
     * Format the SQL error message.
     *
     * @param string $connection
     * @param string $query
     * @param array $bindings
     * @param Throwable $previous
     * @return string
     */
    protected function formatMessage($connection, $query, $bindings, Throwable $previous)
    {
        if ($parsed = json_decode($query)) {
            $command = $parsed->command ?? null;

            if ($request = ($parsed->request ?? null)) {
                if (isset($request->body) || isset($request->aggs)) {
                    return $previous->getMessage() . ' (Connection: ' . $connection . ', Query: ' . json_encode($request) . ')';
                }
            }

            if ($command) {
                return $previous->getMessage() . ' (Connection: ' . $connection . ', Command: ' . $command . ')';
            }
        }

        return $previous->getMessage();
    }

    public static function make($connection, $query, $bindings, Throwable $previous): QueryException
    {
        return new static($connection, $query, $bindings, $previous);
    }
}
