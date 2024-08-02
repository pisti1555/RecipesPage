<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'image',
        'category',
        'ingredients', 
        'instructions',
        'difficulty',
        'time'
    ];

    public function getRating() {
        if ($this->ratings->count() == 0) return null;
        $sum = 0;

        foreach ($this->ratings as $rating) {
            $sum += $rating->rating;
        }

        $rating = round($sum / $this->ratings->count());

        return $rating;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
