<?php

namespace Netflex\Database\DBAL\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;

class Platform extends AbstractPlatform
{
    public function getName()
    {
        return 'netflex';
    }

    protected function initializeDoctrineTypeMappings()
    {
    }

    protected function _getCommonIntegerTypeDeclarationSQL(array $column)
    {
        return 'integer';
    }

    public function getClobTypeDeclarationSQL(array $column)
    {
        return 'text';
    }

    public function getBlobTypeDeclarationSQL(array $column)
    {
        return 'text';
    }

    public function getBooleanTypeDeclarationSQL(array $column)
    {
        return 'boolean';
    }

    public function getIntegerTypeDeclarationSQL(array $column)
    {
        return 'integer';
    }

    public function getBigIntTypeDeclarationSQL(array $column)
    {
        return 'integer';
    }

    public function getSmallIntTypeDeclarationSQL(array $column)
    {
        return 'integer';
    }

    public function getCurrentDatabaseExpression(): string
    {
        return '';
    }
}
