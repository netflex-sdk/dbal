<?php

namespace Netflex\Database\DBAL;

use RuntimeException;

use Illuminate\Support\Str;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Column as DoctrineColumn;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\SimpleArrayType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\Type;
use Netflex\Database\Driver\Connection;

final class Column
{
    protected array $column;

    protected function __construct(array $column)
    {
        $this->column = $column;
    }

    public static function reserved(Connection $connection): array
    {
        return $connection->getAdapter()->getReservedFields();
    }

    public static function isReserved(Connection $connection, string $name): bool
    {
        return in_array($name, static::reserved($connection));
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

    public static function getReservedFields(Connection $connection, string $table): array
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
