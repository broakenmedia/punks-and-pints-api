<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    use HasFactory;

    protected $fillable = [
        'beer_id',
        'name',
        'tagline',
        'first_brewed',
        'description',
        'image_url',
        'abv',
        'ibu',
        'target_fg',
        'target_og',
        'ebc',
        'srm',
        'ph',
        'attenuation_level',
        'volume',
        'boil_volume',
        'method',
        'ingredients',
        'brewers_tips',
        'contributed_by',
    ];

    public function foodPairings()
    {
        return $this->hasMany(FoodPairing::class);
    }
}
