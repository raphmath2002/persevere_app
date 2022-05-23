<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe Horse qui met en évidence ses relations
 */
class Horse extends Model
{
    use HasFactory;

    /**
     * Return pension instance
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pension()
    {
        return $this->belongsTo(Pension::class);
    }

    /**
     * Return user instance
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Renvoi les installations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function facility_horse()
    {
        return $this->belongsToMany(Facility::class)
                    ->using(FacilityHorse::class)
                    ->withPivot("id","start_date","end_date","status","decline_reason","created_at","updated_at");
    }

    /**
     * Renvoi les options
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function horse_option()
    {
        return $this->belongsToMany(Option::class)
                    ->using(HorseOption::class)
                    ->withPivot("id","subscribe_date","unsubscribe_date","created_at","updated_at");
    }

    /**
     * Renvoi les rendez-vous
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appointment_horse()
    {
        return $this->belongsToMany(Appointment::class)
                    ->using(AppointmentHorse::class)
                    ->withPivot("id","title","description","status","price","start_date","end_date","cares","observations","created_at","updated_at");
    }

    /**
     * Renvoi les chevaux
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function horse_pension()
    {
        return $this->belongsToMany(Pension::class)
                    ->using(HorsePension::class)
                    ->withPivot("id","subscribe_date","unsubscribe_date","created_at","updated_at");
    }
}
