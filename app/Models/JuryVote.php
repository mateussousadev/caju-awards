<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JuryVote extends Model
{
    protected $table = 'jury_votes';

    protected $fillable = [
        'jury_member_id',
        'nominee_id',
        'category_id',
        'score',
    ];

    public function nominee()
    {
        return $this->belongsTo(Nominee::class);
    }

    public function jury_member()
    {
        return $this->belongsTo(JuryMember::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
