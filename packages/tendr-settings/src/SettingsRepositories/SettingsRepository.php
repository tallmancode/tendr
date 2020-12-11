<?php

namespace Tallmancode\TendrSettings\SettingsRepositories;

use Illuminate\Database\Eloquent\Model;

interface SettingsRepository
{
    /**
     * Get all the properties in the repository for a single group
     */
    public function getPropertiesInGroup(string $group, string $modelType, int $modelId): array;

    /**
     * Check if a property exists in a group
     */
    public function checkIfPropertyExists(string $group, string $name, string $modelType, int $modelId): bool;

    /**
     * Get the payload of a property
     */
    public function getPropertyPayload(string $group, string $name, string $modelType, int $modelId);

    /**
     * Create a property within a group with a payload
     */
    public function createProperty(string $group, string $name, $payload, string $modelType, int $modelId): void;

    /**
     * Update the payload of a property within a group
     */
    public function updatePropertyPayload(string $group, string $name, $value, string $modelType, int $modelId): void;

    /**
     * Delete a property from a group
     */
    public function deleteProperty(string $group, string $name, string $modelType, int $modelId): void;

    /**
     * Lock a set of properties for a specific group
     */
    public function lockProperties(string $group, array $properties, string $modelType, int $modelId): void;

    /**
     * Unlock a set of properties for a group
     */
    public function unlockProperties(string $group, array $properties, string $modelType, int $modelId): void;

    /**
     * Get all the locked properties within a group
     */
    public function getLockedProperties(string $group, string $modelType, int $modelId): array;
}
