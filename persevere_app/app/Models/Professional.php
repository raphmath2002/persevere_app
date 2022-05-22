<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe Professional qui met en évidence ses relations
 */
class Professional extends Model
{
    use HasFactory;

    /**
     * Renvoi les rendez-vous
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
