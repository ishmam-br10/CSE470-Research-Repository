<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'researcher_id',
    ];

    /**
     * Get the researcher who owns the project.
     */
    public function owner()
    {
        return $this->belongsTo(Researcher::class, 'researcher_id');
    }

    /**
     * Get the researchers collaborating on this project.
     */
    public function researchers()
    {
        return $this->belongsToMany(Researcher::class, 'project_researcher')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * Get applications for this project.
     */
    public function applications()
    {
        return $this->hasMany(ProjectApplication::class);
    }

    /**
     * Check if the given user is the owner of this project.
     */
    public function isOwnedBy(User $user)
    {
        return $user->researcher && $user->researcher->id === $this->researcher_id;
    }
}