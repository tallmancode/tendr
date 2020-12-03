<?php
namespace App\Traits;

use App\Models\Company;

trait CompanyTrait
{
    /**
     * Return the company the user belongs to
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
