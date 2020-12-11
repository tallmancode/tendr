<?php

namespace Tallmancode\TendrSettings;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;
use ReflectionClass;
use ReflectionProperty;
use Tallmancode\TendrSettings\Factories\SettingsRepositoryFactory;

abstract class Settings implements Arrayable, Jsonable, Responsable
{
    protected $model_type = null;

    protected $model_id = null;


    abstract public static function group(): string;

    public static function modelType()
    {
        return self::$model_type;
    }

    public static function modelId()
    {
        return self::$model_id;
    }

    public static function repository(): ?string
    {
        return null;
    }

    public static function casts(): array
    {
        return [];
    }

    public static function encrypted(): array
    {
        return [];
    }

    public static function fake(array $values): self
    {
        $realProperties = SettingsRepositoryFactory::create(self::repository())->getPropertiesInGroup(static::group());

        return app()->instance(static::class, new static(
            array_merge($realProperties, $values)
        ));
    }

    public function __construct(array $properties = [])
    {
        $this->fill($properties);
    }

    public function fill(array $properties): self
    {
        foreach ($properties as $name => $payload) {
            $this->{$name} = $payload;
        }

        return $this;
    }

    public function save(): self
    {
        return SettingsMapper::create(static::class)->save($this);
    }

    public function get($params = null)
    {
        $group = static::group();
        return SettingsRepositoryFactory::create(self::repository())->getPropertiesInGroup($group, static::modelType(), static::modelId());
    }

    public function lock(string ...$properties)
    {
        SettingsRepositoryFactory::create(self::repository())->lockProperties(
            static::group(),
            $properties,
            static::modelType(),
            static::modelId(),
        );
    }

    public function unlock(string ...$properties)
    {
        SettingsRepositoryFactory::create(self::repository())->unlockProperties(
            static::group(),
            $properties,
            static::modelType(),
            static::modelId(),
        );
    }

    public function toArray(): array
    {
        $reflectionClass = new ReflectionClass(static::class);

        return collect($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC))
            ->mapWithKeys(fn (ReflectionProperty $property) => [
                $property->getName() => $this->{$property->getName()},
            ])
            ->toArray();
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function toResponse($request)
    {
        return response()->json($this->toJson());
    }

    public function getModel()
    {
        return $this->model;
    }
}
