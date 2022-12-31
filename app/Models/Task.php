<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskStatus;
use App\Enums\Priorities;
use App\Enums\EstimationType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property TaskStatus $status
 * @property int $progression
 * @property Priorities $priority
 * @property int $estimated_duration
 * @property EstimationType $estimation_type
 * @property string $deadline
 * @property string $started_at
 * @property string $finished_at
 * @property int $project_id
 * @property string $created_at
 * @property string $updated_at
 * @property Project $project
 *
 * @method BelongsTo project()
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'progression',
        'priority',
        'estimated_duration',
        'estimation_type',
        'deadline',
        'started_at',
        'finished_at'
    ];

    protected $casts = [
        'status'            => TaskStatus::class,
        'priority'          => Priorities::class,
        'estimation_type'   => EstimationType::class,
    ];

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Filter records
     *
     * @param  Builder $query
     * @param  array $filters
     *
     * @return void
     */
    public function scopeFilters(Builder $query, array $filters = [])
    {
        $query->when(
            $filters['search'] ?? false,
            fn($q) => $q->where('title', 'like', "%{$filters['search']}%")
        )
        ->when(
            $filters['status'] ?? false,
            fn($q) => $q->whereStatus($filters['status'])
        );
    }
}
