<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleBooksService
{
    protected $apiUrl = 'https://www.googleapis.com/books/v1/volumes';

    public function searchByIsbn($isbn)
    {
        try {
            $response = Http::get($this->apiUrl, [
                'q' => 'isbn:' . trim($isbn),
                'maxResults' => 10
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                // Log the response for debugging
                Log::info('Google Books API ISBN response', ['isbn' => $isbn, 'totalItems' => $data['totalItems'] ?? 0]);
                return $data;
            } else {
                Log::error('Google Books API ISBN search failed', [
                    'isbn' => $isbn, 
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return ['items' => [], 'totalItems' => 0, 'error' => 'API request failed'];
            }
        } catch (\Exception $e) {
            Log::error('Google Books API ISBN search exception', ['isbn' => $isbn, 'error' => $e->getMessage()]);
            return ['items' => [], 'totalItems' => 0, 'error' => $e->getMessage()];
        }
    }
    
    public function searchByTitle($title)
    {
        try {
            $response = Http::get($this->apiUrl, [
                'q' => 'intitle:' . trim($title),
                'maxResults' => 10
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                // Log the response for debugging
                Log::info('Google Books API title response', ['title' => $title, 'totalItems' => $data['totalItems'] ?? 0]);
                return $data;
            } else {
                Log::error('Google Books API title search failed', [
                    'title' => $title, 
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return ['items' => [], 'totalItems' => 0, 'error' => 'API request failed'];
            }
        } catch (\Exception $e) {
            Log::error('Google Books API title search exception', ['title' => $title, 'error' => $e->getMessage()]);
            return ['items' => [], 'totalItems' => 0, 'error' => $e->getMessage()];
        }
    }
}