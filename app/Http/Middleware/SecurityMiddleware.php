<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class SecurityMiddleware
{
    /**
     * Advanced security middleware with multiple protection layers
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Rate limiting based on IP and user
        $this->applyRateLimiting($request);
        
        // 2. IP whitelist/blacklist check
        $this->checkIpRestrictions($request);
        
        // 3. User agent validation
        $this->validateUserAgent($request);
        
        // 4. Request size limitation
        $this->checkRequestSize($request);
        
        // 5. Security headers
        $response = $next($request);
        $this->addSecurityHeaders($response);
        
        // 6. Log security events
        $this->logSecurityEvent($request);
        
        return $response;
    }

    private function applyRateLimiting(Request $request): void
    {
        $key = 'security:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 100)) {
            Log::warning('Rate limit exceeded', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl()
            ]);
            
            abort(429, 'Too many requests');
        }
        
        RateLimiter::hit($key, 3600); // 1 hour window
    }

    private function checkIpRestrictions(Request $request): void
    {
        $ip = $request->ip();
        $blacklistedIps = config('security.blacklisted_ips', []);
        
        if (in_array($ip, $blacklistedIps)) {
            Log::critical('Blacklisted IP access attempt', [
                'ip' => $ip,
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl()
            ]);
            
            abort(403, 'Access denied');
        }
    }

    private function validateUserAgent(Request $request): void
    {
        $userAgent = $request->userAgent();
        $suspiciousPatterns = [
            'sqlmap',
            'nikto',
            'nessus',
            'burp',
            'w3af',
            'masscan'
        ];
        
        foreach ($suspiciousPatterns as $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                Log::critical('Suspicious user agent detected', [
                    'ip' => $request->ip(),
                    'user_agent' => $userAgent,
                    'pattern' => $pattern
                ]);
                
                abort(403, 'Access denied');
            }
        }
    }

    private function checkRequestSize(Request $request): void
    {
        $maxSize = config('security.max_request_size', 10 * 1024 * 1024); // 10MB
        $contentLength = $request->header('Content-Length', 0);
        
        if ($contentLength > $maxSize) {
            Log::warning('Request size exceeded limit', [
                'ip' => $request->ip(),
                'size' => $contentLength,
                'max_size' => $maxSize
            ]);
            
            abort(413, 'Request entity too large');
        }
    }

    private function addSecurityHeaders(Response $response): void
    {
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        
        if (config('app.env') === 'production') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }
    }

    private function logSecurityEvent(Request $request): void
    {
        // Log all requests for security monitoring
        Log::channel('security')->info('Request processed', [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'user_id' => auth()->id(),
            'timestamp' => now()->toISOString()
        ]);
    }
}