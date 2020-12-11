<?php

namespace Tallmancode\TendrSettings;

use Exception;
use ReflectionClass;
use ReflectionProperty;
use Tallmancode\TendrSettings\Events\LoadingSettings;
use Tallmancode\TendrSettings\Events\SavingSettings;
use Tallmancode\TendrSettings\Events\SettingsLoaded;
use Tallmancode\TendrSettings\Events\SettingsSaved;
use Tallmancode\TendrSettings\Exceptions\MissingSettings;
use Tallmancode\TendrSettings\Factories\SettingsRepositoryFactory;
use Tallmancode\TendrSettings\SettingsRepositories\SettingsRepository;
use Tallmancode\TendrSettings\Support\SettingsPropertyData;
use Tallmancode\TendrSettings\Support\SettingsPropertyDataCollection;

class SettingsMapper
{
    /** @var string|class-string */
    protected string $settingsClass;

    /** @var array|class-array */
    protected array $defaults;

    /** @var array|\ReflectionProperty[] */
    protected array $reflectionProperties;

    protected SettingsRepository $repository;

    protected SettingsPropertyDataCollection $properties;

    public static function create(string $settingsClass)
    {
        return new self($settingsClass);
    }

    public function __construct(string $settingsClass)
    {
        if (!is_subclass_of($settingsClass, Settings::class)) {
            throw new Exception("Tried decorating {$settingsClass} which is not extending `Tallmancode\TendrSettings\Settings::class`");
        }
        dump('43');
        $this->settingsClass = $settingsClass;

        $this->reflectionProperties = (new ReflectionClass($settingsClass))->getProperties(ReflectionProperty::IS_PUBLIC);
        dump('47');
        $this->repository = SettingsRepositoryFactory::create($settingsClass::repository());

        $this->properties = SettingsPropertyDataCollection::resolve(
            $this->settingsClass,
            $this->reflectionProperties,
            $this->repository
        );
        dump('55');

        $this->defaults = config('settings.defaults.' . $settingsClass::group());
    }

    public function load(): Settings
    {
        /** @var \Tallmancode\TendrSettings\Settings $settings */
        $settings = new $this->settingsClass;

        $this->ensureNoMissingSettings('loading');

        event(new LoadingSettings($this->settingsClass, $this->properties));

        foreach ($this->properties as $property) {
            $settings->{$property->getName()} = $property->getValue();
        }

        event(new SettingsLoaded($settings));

        return $settings;
    }


    public function save(Settings $settings): Settings
    {

        $this->ensureNoMissingSettings('saving');
        dump('83');
        event(new SavingSettings($this->settingsClass, $this->properties, $settings));

        foreach ($this->properties as $property) {
            if ($this->repository->checkIfPropertyExists(
                $this->settingsClass::group(),
                $property->getName(),
                $this->settingsClass::modelType(),
                $this->settingsClass::modelId(),
            )) {
                if ($property->isLocked()) {
                    $settings->{$property->getName()} = $property->getValue();

                    continue;
                }

                $property->setValue($settings->{$property->getName()});
                $this->repository->updatePropertyPayload(
                    $this->settingsClass::group(),
                    $property->getName(),
                    $property->getRawPayload(),
                    $this->settingsClass::modelType(),
                    $this->settingsClass::modelId(),
                );
            } else {
                $this->repository->createProperty(
                    $this->settingsClass::group(),
                    $property->getName(),
                    $property->getRawPayload(),
                    $this->settingsClass::modelType(),
                    $this->settingsClass::modelId(),
                );
            }
        }

        event(new SettingsSaved($settings));

        return $settings;
    }

    protected function ensureNoMissingSettings(
        string $operation
    ): void {

        $requiredProperties = array_map(
            fn (ReflectionProperty $property) => $property->getName(),
            $this->reflectionProperties
        );


        $availableProperties = array_map(
            fn (SettingsPropertyData $property) => $property->getName(),
            $this->properties->toArray()
        );


        $avalibleDefaults = array_map(
            function ($key) {
                return $key;
            },
            array_keys($this->defaults),
        );

        $availableProperties = array_unique(array_merge($avalibleDefaults, $availableProperties));

        $missingSettings = array_diff($requiredProperties, $availableProperties);

        if (!empty($missingSettings)) {
            throw MissingSettings::create($this->settingsClass, $missingSettings, $operation);
        }
    }
}
