<?php

namespace Tallmancode\TendrSettings\Support;

use ReflectionProperty;
use Spatie\DataTransferObject\DataTransferObjectCollection;
use Tallmancode\TendrSettings\Factories\SettingsCastFactory;
use Tallmancode\TendrSettings\SettingsCasts\SettingsCast;
use Tallmancode\TendrSettings\SettingsRepositories\SettingsRepository;

class SettingsPropertyDataCollection extends DataTransferObjectCollection
{
    /**
     * @param string|\Tallmancode\TendrSettings\Settings $settingsClass
     * @param array $reflectionProperties
     * @param \Tallmancode\TendrSettings\SettingsRepositories\SettingsRepository $repository
     *
     * @return \Tallmancode\TendrSettings\Support\SettingsPropertyDataCollection
     */
    public static function resolve(
        $settingsClass,
        array $reflectionProperties,
        SettingsRepository $repository
    ): self {
        $properties = $repository->getPropertiesInGroup($settingsClass::group(), $settingsClass::modelType(), $settingsClass::modelId());

        $lockedProperties = $repository->getLockedProperties($settingsClass::group(), $settingsClass::modelType(), $settingsClass::modelId());

        $reflectionProperties = array_filter(
            $reflectionProperties,
            fn (ReflectionProperty $reflectionProperty) => array_key_exists($reflectionProperty->name, $properties)
        );

        $collection = array_map(fn (ReflectionProperty $reflectionProperty) => new SettingsPropertyData(
            $name = $reflectionProperty->name,
            self::resolvePayload($name, $properties),
            self::resolveCast($reflectionProperty, $settingsClass::casts()),
            self::resolveIsLocked($name, $lockedProperties),
            self::resolveIsNullable($reflectionProperty),
            self::resolveShouldBeEncrypted($name, $settingsClass::encrypted())
        ), $reflectionProperties);

        return new self($collection);
    }

    protected static function resolvePayload(string $name, array $properties)
    {
        return $properties[$name] ?? null;
    }

    protected static function resolveCast(ReflectionProperty $reflectionProperty, array $localCasts): ?SettingsCast
    {
        return SettingsCastFactory::resolve($reflectionProperty, $localCasts);
    }

    protected static function resolveIsLocked(string $name, array $lockedProperties): bool
    {
        return in_array($name, $lockedProperties);
    }

    protected static function resolveIsNullable(ReflectionProperty $reflectionProperty): bool
    {
        return $reflectionProperty->getType()->allowsNull();
    }

    protected static function resolveShouldBeEncrypted(string $name, array $encryptedProperties): bool
    {
        return in_array($name, $encryptedProperties);
    }

    public function current(): SettingsPropertyData
    {
        return parent::current();
    }
}
