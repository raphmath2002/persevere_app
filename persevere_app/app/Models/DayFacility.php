<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe pour la table pivot DayFacility mettant en évidence ses relations
 */
class DayFacility extends Pivot
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
