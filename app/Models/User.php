<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Hidden attributes for serialization
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    // Accessors to append to model array
    protected $appends = [
        'profile_photo_url',
    ];

    // Attribute casting
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'preferences' => 'array',
        ];
    }

    // Diet plan relationship
    public function dietPlans()
    {
        return $this->hasMany(DietPlan::class);
    }

    public function nutritionLogs()
    {
        return $this->hasMany(NutritionLog::class);
    }

    // Advanced Sanctum Token Management
    public function createApiToken(string $name, array $abilities = ['*'], \DateTimeInterface $expiresAt = null): string
    {
        $token = $this->createToken($name, $abilities, $expiresAt);
        
        // Log token creation for security audit
        \Log::info('API token created', [
            'user_id' => $this->id,
            'token_name' => $name,
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        return $token->plainTextToken;
    }

    public function revokeAllTokens(): void
    {
        $this->tokens()->delete();
        
        \Log::info('All API tokens revoked', [
            'user_id' => $this->id,
            'ip_address' => request()->ip()
        ]);
    }

    public function revokeTokensByName(string $name): void
    {
        $this->tokens()->where('name', $name)->delete();
        
        \Log::info('API tokens revoked by name', [
            'user_id' => $this->id,
            'token_name' => $name,
            'ip_address' => request()->ip()
        ]);
    }

    // Security Features
    public function updateLastLogin(): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip()
        ]);
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function assignRole(string $role): void
    {
        if (!$this->hasRole($role)) {
            $this->roles()->attach(Role::where('name', $role)->first()->id);
        }
    }

    // Advanced Query Scopes
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeRecentlyActive($query, int $days = 30)
    {
        return $query->where('last_login_at', '>=', now()->subDays($days));
    }

    // API Resource Methods
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified' => !is_null($this->email_verified_at),
            'profile_photo_url' => $this->profile_photo_url,
            'two_factor_enabled' => !is_null($this->two_factor_secret),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
