<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HostingPlanAttributes;
use App\Models\HostingPlanPrices;

class HostingPlans extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the hostingPlansAttributes for the HostingPlans
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hostingPlansAttributes(): HasMany
    {
        return $this->hasMany(HostingPlanAttributes::class, 'foreign_key', 'local_key');
    }

    /**
     * Get all of the hostingPlanPrices for the HostingPlans
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hostingPlanPrices(): HasMany
    {
        return $this->hasMany(HostingPlanPrices::class, 'foreign_key', 'local_key');
    }
}
