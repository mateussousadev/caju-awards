<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    protected $table = 'nominees';

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
