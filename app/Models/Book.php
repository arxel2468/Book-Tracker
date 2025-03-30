<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'isbn', 'description', 'cover_url', 'page_count', 'published_year'
    ];
    
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
    
    public function readingStatus()
    {
        return $this->hasOne(ReadingStatus::class);
    }
}