<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe Pension qui met en évidence ses relations
 */
class Pension extends Model
{
    use HasFactory;

    /**
     * Renvoi les chevaux
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function horse_pension()
    {
        return $this->belongsToMany(Horse::class)
                    ->using(HorsePension::class)
                    ->withPivot("id","subscribe_date","unsubscribe_date","created_at","updated_at");
    }
}
