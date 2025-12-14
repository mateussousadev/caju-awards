<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JuryMember extends Model
{
    protected $table = 'jury_members';

    protected $fillable = ['user_id', 'award_id'];
    public function awards()
    {
        return $this->belongsToMany(Award::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jury_votes()
    {
        return $this->hasMany(JuryVote::class);
    }
}
