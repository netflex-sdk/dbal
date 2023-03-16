<?php

namespace Netflex\Database\DBAL;

use RuntimeException;

use Illuminate\Support\Str;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Column as DoctrineColumn;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\SimpleArrayType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\Type;

use Netflex\Database\DBAL\Contracts\Connection;

final class Column
{
    protected array $column;

    protected function __construct(array $column)
    {
        $this->column = $column;
    }

    public static function reserved(Connection $connection): array
    {
        return $connection->getAdapter()->getReservedColumns();
    }

    public static function isReserved(Connection $connection, string $name): bool
    {
        return array_key_exists($name, static::reserved($connection));
    }

    public static function normalizeName($name)
    {
        return Str::replace('_', ' ', Str::title($name));
    }

    public static function mapField(array $field): Column
    {
        return new static([
            'column'  => $field['column'] ?? $field['alias'] ?? throw new RuntimeException('Missing column name'),
            'type'   => $field['type'],
            'notnull' => false,
            'default' => data_get($field, 'config.default_value.value', null),
            'comment' => $field['description'] ?? '',
        ]);
    }

    /**
     * @param Connection $connection
     * @return Column[]
     */
    public static function getReservedColumns(Connection $connection): array
    {
        return collect(static::reserved($connection))
            ->map(fn ($field, $key) => [
                'column'  => $key,
                'type'   => $field['type'],
                'notnull' => $field['notnull'] ?? false,
                'default' => $field['default'] ?? null,
                'autoincrement' => $field['autoincrement'] ?? false,
                'comment' => $field['comment'] ?? '',
            ])
            ->values()
            ->map(fn ($field) => new static($field))
            ->all();
    }

    public function toArray(): array
    {
        return $this->column;
    }

    public function toDoctrineColumn(): DoctrineColumn
    {
        return new DoctrineColumn(
            $this->name(),
            $this->doctrineType(),
            $this->options()
        );
    }

    public function name(): string
    {
        return $this->column['column'];
    }

    public function type(): string
    {
        return $this->column['type'];
    }

    public static function mapType(string $type): string
    {
        switch ($type) {
            case Types::ASCII_STRING:
            case Types::STRING:
            case Types::GUID:
            case Types::BIGINT:
                return 'text';
            case Types::TEXT:
            case Types::BLOB:
            case Types::BINARY:
                return 'textarea';
            case Types::ARRAY:
            case Types::SIMPLE_ARRAY:
                return 'tags';
            case Types::BOOLEAN:
                return 'checkbox';
            case Types::DECIMAL:
                return 'float';
            case Types::DATE_MUTABLE:
            case Types::DATE_IMMUTABLE:
                return 'date';
            case 'timestamp':
            case Types::DATETIME_MUTABLE:
            case Types::DATETIME_IMMUTABLE:
            case Types::DATETIMETZ_MUTABLE:
            case Types::DATETIMETZ_IMMUTABLE:
                return 'datetime';
            default:
                return $type;
        }
    }

    public function doctrineType(): Type
    {
        switch ($this->type()) {
            case 'entry':
                return new IntegerType;
            case 'checkbox':
                return new BooleanType;
            case 'collection':
            case 'textarea':
            case 'editor-large':
            case 'editor-small':
                return new TextType;
            case 'image':
            case 'file':
                return new ArrayType;
            case 'entries':
                return new SimpleArrayType;
            default:
                try {
                    return Type::getType($this->column['type']);
                } catch (Exception $e) {
                    return new TextType;
                }
        }
    }

    public function options(): array
    {
        return collect($this->column)
            ->except(['column', 'type'])
            ->toArray();
    }
}
