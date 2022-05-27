<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe Exception qui met en évidence ses relations
 */
class Exception extends Model
{
    use HasFactory;

    /**
     * Renvoi les installations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exception_facility()
    {
        return $this->belongsToMany(Facility::class)
                    ->using(ExceptionFacility::class)
                    ->withPivot("id", "created_at","updated_at");
    }
}
