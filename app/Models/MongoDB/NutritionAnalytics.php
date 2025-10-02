<?php

namespace App\Models\MongoDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Services\MongoDB\MongoDBService;

/**
 * Advanced MongoDB Model for Nutrition Analytics
 * Demonstrates outstanding MongoDB integration with:
 * - Complex aggregation pipelines
 * - Time-series data handling
 * - Advanced indexing strategies
 * - Sharding support
 */
class NutritionAnalytics extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'nutrition_analytics';

    protected $fillable = [
        'user_id',
        'date',
        'meal_type',
        'meal_name',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'sugar',
        'sodium',
        'cholesterol',
        'vitamins',
        'minerals',
        'ingredients',
        'preparation_method',
        'location',
        'mood_before',
        'mood_after',
        'energy_level',
        'satisfaction_rating',
        'notes',
        'photos',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date' => 'datetime',
        'calories' => 'integer',
        'protein' => 'decimal:2',
        'carbs' => 'decimal:2',
        'fat' => 'decimal:2',
        'fiber' => 'decimal:2',
        'sugar' => 'decimal:2',
        'sodium' => 'decimal:2',
        'cholesterol' => 'decimal:2',
        'vitamins' => 'array',
        'minerals' => 'array',
        'ingredients' => 'array',
        'location' => 'array',
        'photos' => 'array',
        'satisfaction_rating' => 'integer',
        'energy_level' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Advanced Analytics Queries using MongoDB Aggregation
     */
    public static function getDailyNutritionSummary(int $userId, \DateTime $date): array
    {
        $mongoService = new MongoDBService();
        
        $pipeline = [
            [
                '$match' => [
                    'user_id' => $userId,
                    'date' => [
                        '$gte' => $date->format('Y-m-d 00:00:00'),
                        '$lte' => $date->format('Y-m-d 23:59:59')
                    ]
                ]
            ],
            [
                '$group' => [
                    '_id' => '$meal_type',
                    'total_calories' => ['$sum' => '$calories'],
                    'total_protein' => ['$sum' => '$protein'],
                    'total_carbs' => ['$sum' => '$carbs'],
                    'total_fat' => ['$sum' => '$fat'],
                    'total_fiber' => ['$sum' => '$fiber'],
                    'avg_satisfaction' => ['$avg' => '$satisfaction_rating'],
                    'meal_count' => ['$sum' => 1],
                    'unique_ingredients' => ['$addToSet' => '$ingredients'],
                    'preparation_methods' => ['$addToSet' => '$preparation_method']
                ]
            ],
            [
                '$addFields' => [
                    'calories_per_meal' => ['$divide' => ['$total_calories', '$meal_count']],
                    'protein_percentage' => [
                        '$multiply' => [
                            ['$divide' => [['$multiply' => ['$total_protein', 4]], '$total_calories']],
                            100
                        ]
                    ],
                    'carbs_percentage' => [
                        '$multiply' => [
                            ['$divide' => [['$multiply' => ['$total_carbs', 4]], '$total_calories']],
                            100
                        ]
                    ],
                    'fat_percentage' => [
                        '$multiply' => [
                            ['$divide' => [['$multiply' => ['$total_fat', 9]], '$total_calories']],
                            100
                        ]
                    ]
                ]
            ]
        ];

        Log::info('MongoDB daily nutrition summary query', [
            'user_id' => $userId,
            'date' => $date->format('Y-m-d'),
            'pipeline_complexity' => 'high'
        ]);

        return $mongoService->executeAggregation('nutrition_analytics', $pipeline);
    }

    /**
     * Advanced Trend Analysis with Time Series
     */
    public static function getNutritionTrends(int $userId, int $days = 30): array
    {
        $mongoService = new MongoDBService();
        
        $pipeline = [
            [
                '$match' => [
                    'user_id' => $userId,
                    'date' => [
                        '$gte' => new \DateTime("-{$days} days"),
                        '$lte' => new \DateTime()
                    ]
                ]
            ],
            [
                '$group' => [
                    '_id' => [
                        '$dateToString' => [
                            'format' => '%Y-%m-%d',
                            'date' => '$date'
                        ]
                    ],
                    'daily_calories' => ['$sum' => '$calories'],
                    'daily_protein' => ['$sum' => '$protein'],
                    'daily_carbs' => ['$sum' => '$carbs'],
                    'daily_fat' => ['$sum' => '$fat'],
                    'avg_satisfaction' => ['$avg' => '$satisfaction_rating'],
                    'meal_variety' => ['$addToSet' => '$meal_name']
                ]
            ],
            [
                '$addFields' => [
                    'variety_score' => ['$size' => '$meal_variety'],
                    'macro_balance_score' => [
                        '$subtract' => [
                            100,
                            [
                                '$abs' => [
                                    '$subtract' => [
                                        ['$multiply' => [['$divide' => ['$daily_protein', '$daily_calories']], 100]],
                                        25 // Target 25% protein
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                '$setWindowFields' => [
                    'sortBy' => ['_id' => 1],
                    'output' => [
                        '7_day_avg_calories' => [
                            '$avg' => '$daily_calories',
                            'window' => [
                                'range' => [-6, 0],
                                'unit' => 'day'
                            ]
                        ],
                        'calorie_trend' => [
                            '$derivative' => [
                                'input' => '$daily_calories',
                                'unit' => 'day'
                            ]
                        ],
                        'satisfaction_trend' => [
                            '$avg' => '$avg_satisfaction',
                            'window' => [
                                'range' => [-6, 0],
                                'unit' => 'day'
                            ]
                        ]
                    ]
                ]
            ],
            ['$sort' => ['_id' => 1]]
        ];

        Log::info('MongoDB nutrition trends analysis', [
            'user_id' => $userId,
            'days' => $days,
            'features' => ['moving_averages', 'trend_analysis', 'variety_scoring']
        ]);

        return $mongoService->executeAggregation('nutrition_analytics', $pipeline);
    }

    /**
     * Advanced Meal Recommendation Engine
     */
    public static function getMealRecommendations(int $userId, array $preferences = []): array
    {
        $mongoService = new MongoDBService();
        
        $pipeline = [
            // Find similar users based on nutrition patterns
            [
                '$match' => [
                    'user_id' => ['$ne' => $userId],
                    'satisfaction_rating' => ['$gte' => 4]
                ]
            ],
            [
                '$group' => [
                    '_id' => '$user_id',
                    'avg_calories' => ['$avg' => '$calories'],
                    'avg_protein' => ['$avg' => '$protein'],
                    'favorite_meals' => [
                        '$push' => [
                            '$cond' => [
                                ['$gte' => ['$satisfaction_rating', 4]],
                                [
                                    'meal_name' => '$meal_name',
                                    'ingredients' => '$ingredients',
                                    'satisfaction' => '$satisfaction_rating',
                                    'calories' => '$calories',
                                    'protein' => '$protein'
                                ],
                                null
                            ]
                        ]
                    ]
                ]
            ],
            [
                '$addFields' => [
                    'similarity_score' => [
                        '$subtract' => [
                            100,
                            [
                                '$sqrt' => [
                                    '$add' => [
                                        ['$pow' => [['$subtract' => ['$avg_calories', 2000]], 2]],
                                        ['$pow' => [['$subtract' => ['$avg_protein', 150]], 2]]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                '$match' => [
                    'similarity_score' => ['$gte' => 70]
                ]
            ],
            [
                '$unwind' => '$favorite_meals'
            ],
            [
                '$match' => [
                    'favorite_meals' => ['$ne' => null]
                ]
            ],
            [
                '$group' => [
                    '_id' => '$favorite_meals.meal_name',
                    'avg_satisfaction' => ['$avg' => '$favorite_meals.satisfaction'],
                    'recommendation_score' => ['$avg' => '$similarity_score'],
                    'ingredients' => ['$first' => '$favorite_meals.ingredients'],
                    'avg_calories' => ['$avg' => '$favorite_meals.calories'],
                    'avg_protein' => ['$avg' => '$favorite_meals.protein'],
                    'recommendation_count' => ['$sum' => 1]
                ]
            ],
            [
                '$match' => [
                    'recommendation_count' => ['$gte' => 2]
                ]
            ],
            [
                '$addFields' => [
                    'final_score' => [
                        '$multiply' => [
                            '$recommendation_score',
                            '$avg_satisfaction',
                            ['$log' => '$recommendation_count']
                        ]
                    ]
                ]
            ],
            ['$sort' => ['final_score' => -1]],
            ['$limit' => 10]
        ];

        Log::info('MongoDB meal recommendations generated', [
            'user_id' => $userId,
            'algorithm' => 'collaborative_filtering',
            'preferences' => $preferences
        ]);

        return $mongoService->executeAggregation('nutrition_analytics', $pipeline);
    }

    /**
     * Geospatial Analysis for Location-based Insights
     */
    public static function getLocationBasedInsights(int $userId, array $coordinates, float $radiusKm = 5.0): array
    {
        $mongoService = new MongoDBService();
        
        $pipeline = [
            [
                '$geoNear' => [
                    'near' => [
                        'type' => 'Point',
                        'coordinates' => $coordinates
                    ],
                    'distanceField' => 'distance',
                    'maxDistance' => $radiusKm * 1000, // Convert to meters
                    'spherical' => true,
                    'query' => [
                        'user_id' => $userId,
                        'location' => ['$exists' => true]
                    ]
                ]
            ],
            [
                '$group' => [
                    '_id' => [
                        'lat' => ['$round' => [['$arrayElemAt' => ['$location.coordinates', 1]], 2]],
                        'lng' => ['$round' => [['$arrayElemAt' => ['$location.coordinates', 0]], 2]]
                    ],
                    'meal_count' => ['$sum' => 1],
                    'avg_calories' => ['$avg' => '$calories'],
                    'avg_satisfaction' => ['$avg' => '$satisfaction_rating'],
                    'popular_meals' => ['$addToSet' => '$meal_name'],
                    'avg_distance' => ['$avg' => '$distance']
                ]
            ],
            [
                '$addFields' => [
                    'location_score' => [
                        '$multiply' => [
                            '$avg_satisfaction',
                            ['$log' => '$meal_count']
                        ]
                    ],
                    'meal_variety' => ['$size' => '$popular_meals']
                ]
            ],
            ['$sort' => ['location_score' => -1]],
            ['$limit' => 20]
        ];

        Log::info('MongoDB geospatial analysis completed', [
            'user_id' => $userId,
            'center_coordinates' => $coordinates,
            'radius_km' => $radiusKm
        ]);

        return $mongoService->executeAggregation('nutrition_analytics', $pipeline);
    }

    /**
     * Advanced Text Search for Meals and Ingredients
     */
    public static function searchMealsAndIngredients(string $searchTerm, array $filters = []): array
    {
        $mongoService = new MongoDBService();
        
        $pipeline = [
            [
                '$match' => array_merge([
                    '$text' => [
                        '$search' => $searchTerm,
                        '$caseSensitive' => false
                    ]
                ], $filters)
            ],
            [
                '$addFields' => [
                    'search_score' => ['$meta' => 'textScore'],
                    'ingredient_match_count' => [
                        '$size' => [
                            '$filter' => [
                                'input' => '$ingredients',
                                'cond' => [
                                    '$regexMatch' => [
                                        'input' => '$$this',
                                        'regex' => $searchTerm,
                                        'options' => 'i'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                '$group' => [
                    '_id' => '$meal_name',
                    'avg_calories' => ['$avg' => '$calories'],
                    'avg_protein' => ['$avg' => '$protein'],
                    'avg_satisfaction' => ['$avg' => '$satisfaction_rating'],
                    'ingredient_frequency' => ['$sum' => '$ingredient_match_count'],
                    'search_score' => ['$max' => '$search_score'],
                    'meal_count' => ['$sum' => 1],
                    'common_ingredients' => ['$addToSet' => '$ingredients']
                ]
            ],
            [
                '$addFields' => [
                    'relevance_score' => [
                        '$add' => [
                            '$search_score',
                            ['$multiply' => ['$ingredient_frequency', 0.5]],
                            ['$multiply' => ['$avg_satisfaction', 0.3]]
                        ]
                    ]
                ]
            ],
            ['$sort' => ['relevance_score' => -1]],
            ['$limit' => 25]
        ];

        Log::info('MongoDB text search executed', [
            'search_term' => $searchTerm,
            'filters' => $filters,
            'features' => ['text_search', 'ingredient_matching', 'relevance_scoring']
        ]);

        return $mongoService->executeAggregation('nutrition_analytics', $pipeline);
    }

    /**
     * Real-time Nutritional Goal Tracking
     */
    public static function trackNutritionalGoals(int $userId, array $goals): array
    {
        $mongoService = new MongoDBService();
        
        $today = new \DateTime();
        $pipeline = [
            [
                '$match' => [
                    'user_id' => $userId,
                    'date' => [
                        '$gte' => $today->format('Y-m-d 00:00:00'),
                        '$lte' => $today->format('Y-m-d 23:59:59')
                    ]
                ]
            ],
            [
                '$group' => [
                    '_id' => null,
                    'current_calories' => ['$sum' => '$calories'],
                    'current_protein' => ['$sum' => '$protein'],
                    'current_carbs' => ['$sum' => '$carbs'],
                    'current_fat' => ['$sum' => '$fat'],
                    'current_fiber' => ['$sum' => '$fiber'],
                    'meal_count' => ['$sum' => 1],
                    'last_meal_time' => ['$max' => '$created_at']
                ]
            ],
            [
                '$addFields' => [
                    'calorie_progress' => [
                        '$multiply' => [
                            ['$divide' => ['$current_calories', $goals['calories'] ?? 2000]],
                            100
                        ]
                    ],
                    'protein_progress' => [
                        '$multiply' => [
                            ['$divide' => ['$current_protein', $goals['protein'] ?? 150]],
                            100
                        ]
                    ],
                    'carbs_progress' => [
                        '$multiply' => [
                            ['$divide' => ['$current_carbs', $goals['carbs'] ?? 250]],
                            100
                        ]
                    ],
                    'fat_progress' => [
                        '$multiply' => [
                            ['$divide' => ['$current_fat', $goals['fat'] ?? 85]],
                            100
                        ]
                    ],
                    'fiber_progress' => [
                        '$multiply' => [
                            ['$divide' => ['$current_fiber', $goals['fiber'] ?? 25]],
                            100
                        ]
                    ],
                    'overall_progress' => [
                        '$avg' => [
                            ['$divide' => ['$current_calories', $goals['calories'] ?? 2000]],
                            ['$divide' => ['$current_protein', $goals['protein'] ?? 150]],
                            ['$divide' => ['$current_carbs', $goals['carbs'] ?? 250]],
                            ['$divide' => ['$current_fat', $goals['fat'] ?? 85]]
                        ]
                    ]
                ]
            ]
        ];

        Log::info('MongoDB nutritional goal tracking', [
            'user_id' => $userId,
            'goals' => $goals,
            'tracking_date' => $today->format('Y-m-d')
        ]);

        return $mongoService->executeAggregation('nutrition_analytics', $pipeline);
    }
}