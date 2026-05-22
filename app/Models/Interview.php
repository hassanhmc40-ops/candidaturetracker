<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Interview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'application_id',
        'type',
        'scheduled_date',
        'scheduled_time',
        'preparation_notes',
        'result',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_date' => 'date',
        'scheduled_time' => 'datetime:H:i', // Cast to time format
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the application that owns this interview.
     * 
     * Relationship: Interview belongsTo Application (N,1)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS & MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the interview type in French for display.
     * 
     * @return string
     */
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'telephone' => 'Phone',
            'visioconference' => 'Video',
            'technique' => 'Technical',
            'rh' => 'HR',
            'presentiel' => 'In Person',
            'entretien_final' => 'Final Interview',
            default => $this->type,
        };
    }

    /**
     * Get the interview result in French for display.
     * 
     * @return string|null
     */
    public function getResultLabelAttribute()
    {
        if (!$this->result) {
            return null;
        }

        return match($this->result) {
            'en_attente' => 'Pending',
            'reussi' => 'Passed',
            'echoue' => 'Failed',
            'annule' => 'Cancelled',
            default => $this->result,
        };
    }

    /**
     * Get CSS class for result badge.
     * 
     * @return string
     */
    public function getResultColorAttribute()
    {
        return match($this->result) {
            'en_attente' => 'bg-yellow-500',
            'reussi' => 'bg-green-500',
            'echoue' => 'bg-red-500',
            'annule' => 'bg-gray-500',
            default => 'bg-gray-400',
        };
    }

    /**
     * Get full datetime by combining date and time.
     * 
     * @return \Carbon\Carbon
     */
    public function getScheduledDatetimeAttribute()
    {
        return Carbon::parse($this->scheduled_date->format('Y-m-d') . ' ' . $this->scheduled_time);
    }

    /**
     * Get formatted date and time for display.
     * 
     * @return string
     */
    public function getFormattedScheduleAttribute()
    {
        return $this->scheduled_date->format('d/m/Y') . ' à ' . 
               Carbon::parse($this->scheduled_time)->format('H:i');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include upcoming interviews.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>=', now()->toDateString())
                     ->orderBy('scheduled_date')
                     ->orderBy('scheduled_time');
    }

    /**
     * Scope a query to only include past interviews.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePast($query)
    {
        return $query->where('scheduled_date', '<', now()->toDateString())
                     ->orderBy('scheduled_date', 'desc')
                     ->orderBy('scheduled_time', 'desc');
    }

    /**
     * Scope a query to order interviews chronologically.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeChronological($query)
    {
        return $query->orderBy('scheduled_date')
                     ->orderBy('scheduled_time');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Check if the interview is upcoming.
     * 
     * @return bool
     */
    public function isUpcoming()
    {
        return $this->scheduled_date >= now()->toDateString();
    }

    /**
     * Check if the interview is today.
     * 
     * @return bool
     */
    public function isToday()
    {
        return $this->scheduled_date->isToday();
    }

    /**
     * Get all interview type options for forms.
     * 
     * @return array
     */
    public static function getTypeOptions()
    {
        return [
            'telephone' => 'Phone',
            'visioconference' => 'Video',
            'technique' => 'Technical',
            'rh' => 'HR',
            'presentiel' => 'In Person',
            'entretien_final' => 'Final Interview',
        ];
    }

    /**
     * Get all result options for forms.
     * 
     * @return array
     */
    public static function getResultOptions()
    {
        return [
            'en_attente' => 'Pending',
            'reussi' => 'Passed',
            'echoue' => 'Failed',
            'annule' => 'Cancelled',
        ];
    }
}