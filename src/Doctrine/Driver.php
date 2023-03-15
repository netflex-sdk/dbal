<?php

namespace Netflex\Database\DBAL\Doctrine;

use Doctrine\DBAL\Connection as DBALConnection;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Driver as DoctrineDriver;
use Doctrine\DBAL\Driver\API\ExceptionConverter as ExceptionConverterContract;

use Netflex\Database\DBAL\Contracts\Connection as DriverConnection;
use Netflex\Database\DBAL\Doctrine\ExceptionConverter;

class Driver implements DoctrineDriver
{
    protected DriverConnection $connection;

    public function __construct(DriverConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return DBALConnection The database connection.
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

    public function getSchemaManager(DBALConnection $conn, AbstractPlatform $platform)
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

    public function getExceptionConverter(): ExceptionConverterContract
    {
        return new ExceptionConverter;
    }
}
