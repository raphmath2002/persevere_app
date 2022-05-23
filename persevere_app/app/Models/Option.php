<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe Option qui met en évidence ses relations
 */
class Option extends Model
{
    use HasFactory;

    /**
     * Renvoi les chevaux
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function horse_option()
    {
        return $this->belongsToMany(Horse::class)
                    ->using(HorseOption::class)
                    ->withPivot("id","subscribe_date","unsubscribe_date","created_at","updated_at");
    }
}
