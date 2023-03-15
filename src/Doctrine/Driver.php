<?php

namespace Netflex\Database\DBAL\Doctrine;

use Doctrine\DBAL\Connection as DBALConnection;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;

use Doctrine\DBAL\Driver as DoctrineDriver;

use Netflex\Database\DBAL\Contracts\Connection as DriverConnection;

class Driver implements DoctrineDriver
{
    protected DriverConnection $connection;

    public function __construct(DriverConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection The database connection.
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        return new DBALConnection($params, $this);
    }

    /**
     * @return AbstractPlatform The database platform.
     */
    public function getDatabasePlatform()
    {
        return new Platform();
    }

    public function getSchemaManager(DBALConnection $conn)
    {
        return new SchemaManager($this->connection, $conn);
    }

    /**
     * Gets the name of the driver.
     *
     * @deprecated
     *
     * @return string The name of the driver.
     */
    public function getName()
    {
        return 'Netflex';
    }

    /**
     * Gets the name of the database connected to for this driver.
     *
     * @deprecated Use Connection::getDatabase() instead.
     *
     * @return string The name of the database.
     */
    public function getDatabase(Connection $conn)
    {
        return get_class($this->connection->getAdapter());
    }
}
