<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Casts\Encrypted;

class DietPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'calories_target',
        'protein_target',
        'carbs_target',
        'fat_target',
        'duration_days',
        'status',
        'metadata'
    ];

    protected $casts = [
        'calories_target' => 'integer',
        'protein_target' => 'decimal:2',
        'carbs_target' => 'decimal:2',
        'fat_target' => 'decimal:2',
        'duration_days' => 'integer',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    // Advanced Eloquent Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    public function nutritionLogs()
    {
        return $this->hasMany(NutritionLog::class);
    }

    // Advanced Query Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeWithinCalorieRange(Builder $query, int $min, int $max): Builder
    {
        return $query->whereBetween('calories_target', [$min, $max]);
    }

    // Advanced Accessors & Mutators
    public function getProgressPercentageAttribute(): float
    {
        if ($this->duration_days <= 0) return 0;
        
        $daysCompleted = $this->nutrition_logs_count ?? 0;
        return min(100, ($daysCompleted / $this->duration_days) * 100);
    }

    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = ucfirst(trim($value));
    }

    // Advanced Caching Methods
    public static function getCachedUserPlans(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember(
            "user_diet_plans_{$userId}",
            now()->addHours(1),
            fn() => static::forUser($userId)->active()->with(['meals', 'nutritionLogs'])->get()
        );
    }

    // Performance Optimization Methods
    public function loadOptimized(): self
    {
        return $this->load([
            'user:id,name,email',
            'meals:id,diet_plan_id,name,calories',
            'nutritionLogs' => function ($query) {
                $query->select(['id', 'diet_plan_id', 'calories_consumed', 'logged_at'])
                      ->latest('logged_at')
                      ->limit(10);
            }
        ]);
    }

    // Advanced Validation Rules
    public static function validationRules(): array
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:1000',
            'calories_target' => 'required|integer|min:1200|max:5000',
            'protein_target' => 'required|numeric|min:0|max:500',
            'carbs_target' => 'required|numeric|min:0|max:800',
            'fat_target' => 'required|numeric|min:0|max:300',
            'duration_days' => 'required|integer|min:1|max:365',
            'status' => 'required|in:active,inactive,completed',
        ];
    }

    // Security: Mass Assignment Protection
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Database Event Hooks
    protected static function booted(): void
    {
        static::created(function (DietPlan $plan) {
            Cache::forget("user_diet_plans_{$plan->user_id}");
        });

        static::updated(function (DietPlan $plan) {
            Cache::forget("user_diet_plans_{$plan->user_id}");
        });

        static::deleted(function (DietPlan $plan) {
            Cache::forget("user_diet_plans_{$plan->user_id}");
        });
    }
}