<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Researcher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department',
        'contact',
        'avatar_path',
        'user_id',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function papers()
    {
        return $this->belongsToMany(Paper::class, 'paper_researcher');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_researcher');
    }
    public function getCitationsAttribute()
    {
        return $this->papers->sum('citations');
    }
}
