<?php

namespace Netflex\DBAL\Concerns;

use Closure;
use PDOException;

use Netflex\DBAL\PDOStatement;
use Netflex\DBAL\Contracts\DatabaseAdapter;

use GuzzleHttp\Exception\ServerException;

trait PerformsQueries
{
    public function select(PDOStatement $statement, array $arguments, Closure $callback): bool
    {
        /** @var DatabaseAdapter $this */

        $arguments['index'] = $arguments['table'];
        unset($arguments['table']);

        try {
            $result = $statement->getPDO()
                ->getAPIClient()
                ->post('search/raw', $arguments, true);

            $statement->affectedRows = $result['hits']['total'] ?? 0;

            if (isset($result['aggregations'])) {
                $aggregations = $result['aggregations'];

                if (isset($aggregations['aggregate']) && array_key_exists('value', $aggregations['aggregate'])) {
                    $aggregations['aggregate'] = $aggregations['aggregate']['value'];
                }

                $result['hits']['hits'][] = [
                    '_source' => $aggregations
                ];
            }

            if (isset($result['hits']['hits'])) {
                $statement->affectedRows = count($result['hits']['hits']);
            }

            $callback($result);

            return true;
        } catch (ServerException $e) {
            $response = $e->getResponse();
            $code = $response->getStatusCode();
            $message = $e->getMessage();

            if ($esResponse = json_decode($response->getBody())) {
                if ($esResponse->error) {
                    if ($esError = json_decode($esResponse->error->message)) {
                        $message = $esError->error->root_cause[0]->reason;
                    }
                }
            }

            $statement->errorCode = $code;
            $statement->errorInfo = [get_class($e), $code, $message];
            $callback(null);

            throw new PDOException($message, $code, $e);
        }
    }
}
