<?php

namespace Netflex\Database\DBAL\Exceptions;

use Throwable;
use Illuminate\Database\QueryException as Exception;

class QueryException extends Exception
{
    /**
     * Format the SQL error message.
     *
     * @param string $query
     * @param array $bindings
     * @param Throwable $previous
     * @return string
     */
    protected function formatMessage($query, $bindings, Throwable $previous)
    {
        if ($parsed = json_decode($query)) {
            $command = $parsed->command ?? null;

            if ($request = ($parsed->request ?? null)) {
                if (isset($request->body) || isset($request->aggs)) {
                    return $previous->getMessage() . ' (Query: ' . json_encode($request) . ')';
                }
            }

            if ($command) {
                return $previous->getMessage() . ' (Command: ' . $command . ')';
            }
        }

        return $previous->getMessage();
    }

    public function make($_, $query, $bindings, Throwable $previous): QueryException
    {
        return new static($query, $bindings, $previous);
    }
}
