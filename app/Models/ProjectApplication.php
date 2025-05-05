<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'motivation',
        'status',
    ];

    /**
     * Get the project that the application is for.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who applied.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}