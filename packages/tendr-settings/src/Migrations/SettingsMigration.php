<?php

namespace Tallmancode\TendrSettings\Migrations;

use Illuminate\Database\Migrations\Migration;

abstract class SettingsMigration extends Migration
{
    protected SettingsMigrator $migrator;

    abstract public function up();

    public function __construct()
    {
        $this->migrator = resolve(SettingsMigrator::class);
    }
}
