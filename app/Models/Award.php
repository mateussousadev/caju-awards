<?php

namespace App\Models;

use App\AwardStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Award extends Model
{
    use SoftDeletes;            
    protected $table = 'awards';

    protected $fillable = [
        'name',
        'year',
        'voting_start_date',
        'voting_end_date',
        'status',
    ];

    protected $casts = [
        'year' => 'integer',
        'voting_start_date' => 'date',
        'voting_end_date' => 'date',
        'status' => AwardStatus::class,
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function jury_members()
    {
        return $this->belongsToMany(JuryMember::class);
    }
}
