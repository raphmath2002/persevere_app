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
}
