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
     * Renvoi les pensions
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pensions()
    {
        return $this->hasMany(Pension::class);
    }
}
