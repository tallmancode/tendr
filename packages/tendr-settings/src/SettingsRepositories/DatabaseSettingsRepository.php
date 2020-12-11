<?php

namespace Tallmancode\TendrSettings\SettingsRepositories;

use DB;
use Illuminate\Database\Eloquent\Model;
use Tallmancode\TendrSettings\Models\SettingsProperty;

class DatabaseSettingsRepository implements SettingsRepository
{
    /** @var string|\Illuminate\Database\Eloquent\Model */
    protected string $propertyModel;

    protected ?string $connection;

    public function __construct(array $config)
    {
        $this->propertyModel = $config['model'] ?? SettingsProperty::class;

        $this->connection = $config['connection'] ?? null;
    }

    public function getPropertiesInGroup(string $group, string $modelType, int $modelId): array
    {
        /**
         * @var \Tallmancode\TendrSettings\Models\SettingsProperty $temp
         * @psalm-suppress UndefinedClass
         */
        $temp = new $this->propertyModel;

        $avalibleDefaults = config('settings.defaults.'.$group);
        $availableProperties =  DB::connection($this->connection ?? $temp->getConnectionName())
            ->table($temp->getTable())
            ->where('group', $group)
            ->where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->get(['name', 'payload'])
            ->mapWithKeys(function ($object) {
                return [$object->name => json_decode($object->payload, true)];
            })
            ->toArray();

        return array_unique(array_merge($avalibleDefaults, $availableProperties));
    }

    public function checkIfPropertyExists(string $group, string $name, string $modelType, int $modelId): bool
    {
        return $this->propertyModel::on($this->connection)
            ->where('group', $group)
            ->where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->where('name', $name)
            ->exists();
    }

    public function getPropertyPayload(string $group, string $name, string $modelType, int $modelId)
    {
        $setting = $this->propertyModel::on($this->connection)
            ->where('group', $group)
            ->where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->where('name', $name)
            ->first('payload')
            ->toArray();

        return json_decode($setting['payload']);
    }

    public function createProperty(string $group, string $name, $payload, string $modelType, int $modelId): void
    {
        $this->propertyModel::on($this->connection)->create([
            'group' => $group,
            'name' => $name,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'payload' => json_encode($payload),
            'locked' => false,
        ]);
    }

    public function updatePropertyPayload(string $group, string $name, $value, string $modelType, int $modelId): void
    {
        $this->propertyModel::on($this->connection)
            ->where('group', $group)
            ->where('name', $name)
            ->where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->update([
                'payload' => json_encode($value),
            ]);
    }

    public function deleteProperty(string $group, string $name, string $modelType, int $modelId): void
    {
        $this->propertyModel::on($this->connection)
            ->where('group', $group)
            ->where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->where('name', $name)
            ->delete();
    }

    public function lockProperties(string $group, array $properties, string $modelType, int $modelId): void
    {
        $this->propertyModel::on($this->connection)
            ->where('group', $group)
            ->whereIn('name', $properties)
            ->where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->update(['locked' => true]);
    }

    public function unlockProperties(string $group, array $properties, string $modelType, int $modelId): void
    {
        $this->propertyModel::on($this->connection)
            ->where('group', $group)
            ->whereIn('name', $properties)
            ->update(['locked' => false]);
    }

    public function getLockedProperties(string $group, string $modelType, int $modelId): array
    {
        return $this->propertyModel::on($this->connection)
            ->where('group', $group)
            ->where('locked', true)
            ->pluck('name')
            ->toArray();
    }
}
