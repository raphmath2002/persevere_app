<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe pour la table pivot FacilityHorse mettant en évidence ses relations
 */
class FacilityHorse extends Pivot
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo(Horse::class);
    }
}
