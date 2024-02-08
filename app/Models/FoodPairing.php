<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodPairing extends Model
{
    use HasFactory;

    protected $fillable = ['pairing'];

    public function beer(): BelongsTo
    {
        return $this->belongsTo(Beer::class);
    }
}
