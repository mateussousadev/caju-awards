<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    protected $table = 'nominees';

    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'description',
        'photo',
        'quantitative_description',
        'quantitative_value',
    ];

    protected $casts = [
        'quantitative_value' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function jury_votes()
    {
        return $this->hasMany(JuryVote::class);
    }
}
