<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'year',
        'file_path',
        'cited',
    ];

    public function authors()
    {
        return $this->belongsToMany(Researcher::class);
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
    public function researchers()
    {
        return $this->belongsToMany(Researcher::class, 'paper_researcher');
    }
}
