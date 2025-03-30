<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleBooksService
{
    public function searchByIsbn($isbn)
    {
        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => 'isbn:' . $isbn
        ]);
        
        return $response->json();
    }
    
    public function searchByTitle($title)
    {
        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => 'intitle:' . $title
        ]);
        
        return $response->json();
    }
}