<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'job_title',
        'job_url',
        'status',
        'priority',
        'notes',
        'application_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'application_date' => 'date',
        'deleted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user that owns the application.
     * 
     * Relationship: Application belongsTo User (N,1)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all interviews for this application.
     * 
     * Relationship: Application hasMany Interviews (1,N)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

    /**
     * Get all documents for this application (BONUS).
     * 
     * Relationship: Application hasMany Documents (1,N)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS & MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the status in French for display.
     * 
     * Converts database value to French label.
     * 
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'en_attente' => 'En attente',
            'en_cours' => 'En cours',
            'entretien_planifie' => 'Entretien planifié',
            'offre_recue' => 'Offre reçue',
            'refusee' => 'Refusée',
            'acceptee' => 'Acceptée',
            default => $this->status,
        };
    }

    /**
     * Get the priority in French for display.
     * 
     * Converts database value to French label.
     * 
     * @return string
     */
    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            'basse' => 'Basse',
            'moyenne' => 'Moyenne',
            'haute' => 'Haute',
            'urgente' => 'Urgente',
            default => $this->priority,
        };
    }

    /**
     * Get CSS class for status badge.
     * 
     * Used for color-coding in views.
     * 
     * @return string
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'en_attente' => 'bg-gray-500',
            'en_cours' => 'bg-blue-500',
            'entretien_planifie' => 'bg-yellow-500',
            'offre_recue' => 'bg-green-500',
            'refusee' => 'bg-red-500',
            'acceptee' => 'bg-green-700',
            default => 'bg-gray-400',
        };
    }

    /**
     * Get CSS class for priority badge.
     * 
     * Used for color-coding in views.
     * 
     * @return string
     */
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'basse' => 'bg-green-500',
            'moyenne' => 'bg-yellow-500',
            'haute' => 'bg-orange-500',
            'urgente' => 'bg-red-500',
            default => 'bg-gray-400',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include applications with specific status.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include applications with specific priority.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $priority
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to apply filters (US9).
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });

        $query->when($filters['priority'] ?? false, function ($query, $priority) {
            $query->where('priority', $priority);
        });

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | MODEL EVENTS
    |--------------------------------------------------------------------------
    */

    /**
     * The "booted" method of the model.
     * 
     * Used for model events like deleting.
     */
    protected static function booted()
    {
        /**
         * When an application is force deleted (permanent delete),
         * delete all associated document files from storage.
         * 
         * This ensures no orphaned files remain on disk.
         */
        static::forceDeleting(function ($application) {
            // Delete all document files from disk (BONUS feature)
            foreach ($application->documents as $document) {
                if (Storage::disk('private')->exists($document->file_path)) {
                    Storage::disk('private')->delete($document->file_path);
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Check if the application is archived (soft deleted).
     * 
     * @return bool
     */
    public function isArchived()
    {
        return $this->trashed();
    }

    /**
     * Get all status options for forms.
     * 
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            'en_attente' => 'En attente',
            'en_cours' => 'En cours',
            'entretien_planifie' => 'Entretien planifié',
            'offre_recue' => 'Offre reçue',
            'refusee' => 'Refusée',
            'acceptee' => 'Acceptée',
        ];
    }

    /**
     * Get all priority options for forms.
     * 
     * @return array
     */
    public static function getPriorityOptions()
    {
        return [
            'basse' => 'Basse',
            'moyenne' => 'Moyenne',
            'haute' => 'Haute',
            'urgente' => 'Urgente',
        ];
    }
}