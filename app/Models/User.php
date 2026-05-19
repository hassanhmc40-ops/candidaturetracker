<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Get all applications for this user.
     * 
     * Relationship: User hasMany Applications (1,N)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get only active (non-archived) applications.
     * 
     * This excludes soft-deleted applications.
     * Useful for displaying current applications (US2).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeApplications()
    {
        return $this->hasMany(Application::class)
                    ->whereNull('deleted_at');
    }

    /**
     * Get only archived (soft-deleted) applications.
     * 
     * This retrieves only soft-deleted applications.
     * Useful for archives page (US7).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function archivedApplications()
    {
        return $this->hasMany(Application::class)
                    ->onlyTrashed();
    }
}
