<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe Facility qui met en évidence ses relations
 */
class Facility extends Model
{
    use HasFactory;

    /**
     * Renvoi les chevaux
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function facility_horse()
    {
        return $this->belongsToMany(Horse::class)
                    ->using(FacilityHorse::class)
                    ->withPivot("id","start_date","end_date","status","decline_reason","created_at","updated_at");
    }

    /**
     * Renvoi les exceptions
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exception_facility()
    {
        return $this->belongsToMany(Exception::class)
                    ->using(ExceptionFacility::class)
                    ->withPivot("id","created_at","updated_at");
    }

    /**
     * Renvoi les days
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function day_facility()
    {
        return $this->belongsToMany(Day::class)
                    ->using(DayFacility::class)
                    ->withPivot("id","start_hour","start_minute","end_hour","end_minute","created_at","updated_at");
    }

    /**
     * Renvoi les images
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facilities_images()
    {
        return $this->hasMany(FacilitiesImage::class);
    }
}
