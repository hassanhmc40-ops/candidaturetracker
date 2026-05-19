<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'application_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the application that owns this document.
     * 
     * Relationship: Document belongsTo Application (N,1)
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
     * Get human-readable file size.
     * 
     * @return string
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get file extension from file name.
     * 
     * @return string
     */
    public function getExtensionAttribute()
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }

    /**
     * Get icon class based on file type.
     * 
     * @return string
     */
    public function getIconAttribute()
    {
        return match($this->extension) {
            'pdf' => 'fa-file-pdf text-red-600',
            'doc', 'docx' => 'fa-file-word text-blue-600',
            'xls', 'xlsx' => 'fa-file-excel text-green-600',
            'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image text-purple-600',
            'zip', 'rar' => 'fa-file-archive text-yellow-600',
            default => 'fa-file text-gray-600',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | MODEL EVENTS
    |--------------------------------------------------------------------------
    */

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        /**
         * When a document is deleted, remove the file from storage.
         */
        static::deleting(function ($document) {
            if (Storage::disk('private')->exists($document->file_path)) {
                Storage::disk('private')->delete($document->file_path);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the download URL for this document.
     * 
     * @return string
     */
    public function getDownloadUrl()
    {
        return route('documents.download', $this->id);
    }

    /**
     * Check if file exists in storage.
     * 
     * @return bool
     */
    public function fileExists()
    {
        return Storage::disk('private')->exists($this->file_path);
    }

    /**
     * Get allowed file types for validation.
     * 
     * @return array
     */
    public static function getAllowedTypes()
    {
        return [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'image/jpeg',
            'image/png',
            'image/gif',
        ];
    }

    /**
     * Get max file size in bytes (5MB).
     * 
     * @return int
     */
    public static function getMaxFileSize()
    {
        return 5 * 1024 * 1024; // 5MB
    }
}