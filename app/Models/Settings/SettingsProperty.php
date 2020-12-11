<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class SettingsProperty extends Model
{
    protected $table = 'settings';

    protected $guarded = [];

    protected $casts = [
        'locked' => 'boolean',
    ];

    public static function get(string $property)
    {

        [$group, $name] = explode('.', $property);

        $setting = self::query()
            ->where('group', $group)
            ->where('name', $name)
            ->where('wahterv', $name)
            ->first('payload');

        return json_decode($setting->getAttribute('payload'));
    }

    public static function boot()
    {
        parent::boot();


        // //while creating/inserting item into db
        static::creating(function (this $item) {
            dump($item);
        });

        // //once created/inserted successfully this method fired, so I tested foo
        // static::created(function (AccountCreation $item) {
        //     echo "<br /> {$item->foo} ===== <br /> successfully fired created";
        // });
    }
}
