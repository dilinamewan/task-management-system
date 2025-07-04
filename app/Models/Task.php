<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'user_id',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-warning',
            'in_progress' => 'bg-info',
            'completed' => 'bg-success',
        ];
        return $badges[$this->status] ?? 'bg-secondary';
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'low' => 'bg-success',
            'medium' => 'bg-warning',
            'high' => 'bg-danger',
        ];
        return $badges[$this->priority] ?? 'bg-secondary';
    }
}