<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe FacilitiesImage qui met en évidence ses relations
 */
class FacilitiesImage extends Model
{
    use HasFactory;

    /**
     * Return facility instance
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
