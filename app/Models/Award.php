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
        'description',
        'year',
        'voting_start_at',
        'voting_end_at',
        'status',
        'is_active',
    ];

    protected $casts = [
        'year' => 'integer',
        'voting_start_at' => 'datetime',
        'voting_end_at' => 'datetime',
        'status' => AwardStatus::class,
        'is_active' => 'boolean',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function jury_members()
    {
        return $this->belongsToMany(JuryMember::class);
    }
}
