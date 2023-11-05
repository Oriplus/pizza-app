<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cost_price'];

    protected $hidden = ['created_at', 'updated_at'];

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class)->withTimestamps();
    }
}
