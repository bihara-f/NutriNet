<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'diet_plan_id',
        'meal_id',
        'calories_consumed',
        'protein_consumed',
        'carbs_consumed',
        'fat_consumed',
        'logged_at',
        'notes'
    ];

    protected $casts = [
        'calories_consumed' => 'integer',
        'protein_consumed' => 'decimal:2',
        'carbs_consumed' => 'decimal:2',
        'fat_consumed' => 'decimal:2',
        'logged_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dietPlan()
    {
        return $this->belongsTo(DietPlan::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('logged_at', today());
    }
}