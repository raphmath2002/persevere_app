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
}
