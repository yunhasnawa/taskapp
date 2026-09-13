<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    public const PRIORITIES = ['rendah', 'sedang', 'tinggi'];

    public const STATUSES = ['belum dimulai', 'dikerjakan', 'selesai'];

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, fn (Builder $q, string $search) => $q->where('title', 'like', "%{$search}%"))
            ->when($filters['status'] ?? null, fn (Builder $q, string $status) => $q->where('status', $status))
            ->when($filters['priority'] ?? null, fn (Builder $q, string $priority) => $q->where('priority', $priority));
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'selesai'    => 'success',
            'dikerjakan' => 'warning',
            default      => 'secondary',
        };
    }

    public function priorityColor(): string
    {
        return match($this->priority) {
            'tinggi'    => 'danger',
            'sedang'    => 'warning',
            default      => 'info',
        };
    }

    public function isOverdue(): bool
    {
        return $this->due_date !== null
            && $this->status !== 'selesai'
            && $this->due_date->isPast();
    }
}
