<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $started_at
 * @property string $finished_at
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Database\Eloquent\Collection $tasks
 *
 * @method HasMany tasks()
 */
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'started_at',
        'finished_at'
    ];

    /**
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
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
            fn($q) => $q->where('name', 'like', "%{$filters['search']}%")
                        ->orWhere('description', 'like', "%{$filters['search']}%")
        );
    }
}
