<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->show_email)) {
                $model->show_email = false;
            }

            if (is_null($model->show_name)) {
                $model->show_name = false;
            }
        });
    }

    protected $fillable = [
        'user_id',
        'image',
        'description',
        'show_email',
        'show_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
