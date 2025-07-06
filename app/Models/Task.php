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

    // Define which relationships to always load (can help with N+1 problems)
    protected $with = [];

    // Add scopes for common queries to optimize performance
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->where('status', '!=', 'completed');
    }

    public function scopeUpcoming($query, $days = 7)
    {
        return $query->whereBetween('due_date', [now(), now()->addDays($days)])
                    ->where('status', '!=', 'completed');
    }

    // Optimized search scope for full-text search
    public function scopeSearch($query, $term)
    {
        if (config('database.default') === 'mysql') {
            return $query->whereRaw("MATCH(title, description) AGAINST(? IN BOOLEAN MODE)", [$term]);
        }
        
        return $query->where(function($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%");
        });
    }

    // Optimized relationship
    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'name', 'email']);
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