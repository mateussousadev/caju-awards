<?php

namespace App\Models;

use App\CategoryType;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'award_id',
        'name',
        'description',
        'type',
        'winner_id',
        'public_vote_weight',
        'quantitative_weight',
        'jury_weight',
        'order',
    ];

    protected $casts = [
        'public_vote_weight' => 'integer',
        'quantitative_weight' => 'integer',
        'jury_weight' => 'integer',
        'order' => 'integer',
        'type' => CategoryType::class,
    ];

    public function award()
    {
        return $this->belongsTo(Award::class);
    }

    public function nominees()
    {
        return $this->hasMany(Nominee::class);
    }

    public function winner()
    {
        return $this->belongsTo(Nominee::class, 'winner_id');
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
