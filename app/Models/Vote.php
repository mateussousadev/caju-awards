<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'category_id',
        'nominee_id',
        'user_id',
        'ip_address',
    ];

    public function nominee()
    {
        return $this->belongsTo(Nominee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
