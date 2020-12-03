<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

     /**
     * Returns the users for a company
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
