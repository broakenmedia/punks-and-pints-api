<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodPairing extends Model
{
    use HasFactory;

    protected $fillable = ['pairing'];

    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }
}
