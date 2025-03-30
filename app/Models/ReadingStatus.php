<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingStatus extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'book_id', 'status', 'current_page', 'started_at', 'finished_at', 'rating', 'notes'
    ];
    
    protected $casts = [
        'started_at' => 'date',
        'finished_at' => 'date',
        'rating' => 'integer',
        'current_page' => 'integer',
    ];
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    
    /**
     * Automatically set started_at when status changes to in_progress
     */
    protected static function booted()
    {
        static::saving(function ($readingStatus) {
            // If status is changing to in_progress and started_at is not set
            if ($readingStatus->status === 'in_progress' && !$readingStatus->started_at) {
                $readingStatus->started_at = now();
            }
            
            // If status is changing to finished and finished_at is not set
            if ($readingStatus->status === 'finished' && !$readingStatus->finished_at) {
                $readingStatus->finished_at = now();
            }
            
            // If book is finished, set current_page to the book's page count
            if ($readingStatus->status === 'finished' && $readingStatus->book && $readingStatus->book->page_count) {
                $readingStatus->current_page = $readingStatus->book->page_count;
            }
        });
    }
}