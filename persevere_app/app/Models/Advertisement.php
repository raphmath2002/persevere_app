<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe Advertisement qui met en évidence ses relations
 */
class Advertisement extends Model
{
    use HasFactory;

    /**
     * Return user instance
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Renvoi les membres
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function advertisement_user()
    {
        return $this->belongsToMany(User::class)
                    ->using(AdvertisementUser::class)
                    ->withPivot("id","created_at","updated");
    }
}
