<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'diet_plan_id',
        'name',
        'calories',
        'protein',
        'carbs',
        'fat',
        'meal_type',
        'ingredients',
        'instructions'
    ];

    protected $casts = [
        'calories' => 'integer',
        'protein' => 'decimal:2',
        'carbs' => 'decimal:2',
        'fat' => 'decimal:2',
        'ingredients' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function dietPlan()
    {
        return $this->belongsTo(DietPlan::class);
    }

    public function nutritionLogs()
    {
        return $this->hasMany(NutritionLog::class);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('meal_type', $type);
    }
}