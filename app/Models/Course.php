<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'capacity', 'starts_at'];

    protected $casts = [
        'starts_at' => 'datetime',
        'capacity' => 'integer',
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function activeEnrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class)
            ->whereIn('status', [Enrollment::STATUS_ENROLLED, Enrollment::STATUS_COMPLETED]);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(Participant::class, 'enrollments')
            ->withPivot(['id', 'enrolled_at', 'status'])
            ->withTimestamps();
    }

    public function getOccupiedSeatsAttribute(): int
    {
        return $this->activeEnrollments()->count();
    }

    public function getFreeSeatsAttribute(): int
    {
        return max(0, $this->capacity - $this->occupied_seats);
    }

    public function hasFreeCapacity(): bool
    {
        return $this->free_seats > 0;
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['date_from'] ?? null, fn ($q, $date) => $q->whereDate('starts_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($q, $date) => $q->whereDate('starts_at', '<=', $date))
            ->when(!empty($filters['only_available']), function ($q) {
                $q->whereRaw(
                    'capacity > (SELECT COUNT(*) FROM enrollments WHERE enrollments.course_id = courses.id AND enrollments.status IN (?, ?))',
                    [Enrollment::STATUS_ENROLLED, Enrollment::STATUS_COMPLETED]
                );
            });
    }
}
