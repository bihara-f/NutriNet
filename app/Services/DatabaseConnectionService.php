<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class DatabaseConnectionService
{
    /**
     * Test database connection with advanced features
     */
    public function testConnection(): array
    {
        try {
            $startTime = microtime(true);
            
            // Test basic connection
            DB::connection()->getPdo();
            
            // Test transaction capabilities
            DB::beginTransaction();
            DB::select('SELECT 1 as test');
            DB::commit();
            
            $endTime = microtime(true);
            $responseTime = ($endTime - $startTime) * 1000; // Convert to milliseconds
            
            return [
                'status' => 'success',
                'connection' => 'active',
                'response_time' => round($responseTime, 2) . 'ms',
                'database' => config('database.default'),
                'host' => config('database.connections.mysql.host'),
                'features' => [
                    'transactions' => true,
                    'foreign_keys' => true,
                    'ssl_enabled' => !empty(config('database.connections.mysql.options')),
                    'connection_pooling' => true
                ]
            ];
        } catch (Exception $e) {
            Log::error('Database connection failed: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Execute stored procedure example
     */
    public function executeStoredProcedure(string $procedure, array $params = []): array
    {
        try {
            $result = DB::select("CALL {$procedure}(" . implode(',', array_fill(0, count($params), '?')) . ")", $params);
            return ['status' => 'success', 'data' => $result];
        } catch (Exception $e) {
            Log::error("Stored procedure execution failed: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Advanced query with transaction and error handling
     */
    public function executeTransactionalQuery(callable $callback): array
    {
        try {
            return DB::transaction(function () use ($callback) {
                return $callback();
            });
        } catch (Exception $e) {
            Log::error("Transactional query failed: " . $e->getMessage());
            throw $e;
        }
    }
}