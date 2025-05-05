<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'paper_id',
        'borrower_id',
        'approved_by',
        'borrowed_at',
        'due_at',
        'returned_at',
        'status'
    ];

    protected $dates = ['borrowed_at', 'due_at', 'returned_at'];

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
