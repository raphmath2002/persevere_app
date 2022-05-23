<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe Appointment qui met en évidence ses relations
 */
class Appointment extends Model
{
    use HasFactory;

    /**
     * Return professional instance
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Renvoi les chevaux
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appointment_horse()
    {
        return $this->belongsToMany(Horse::class)
                    ->using(AppointmentHorse::class)
                    ->withPivot("id","title","description","status","price","start_date","end_date","cares","observations","created_at","updated_at");
    }
}
