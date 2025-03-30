<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingStatus;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $currentlyReading = ReadingStatus::where('status', 'in_progress')->count();
        $completed = ReadingStatus::where('status', 'finished')->count();
        $recentlyAdded = Book::with('authors')->latest()->take(5)->get();
        $recentlyFinished = Book::whereHas('readingStatus', function($query) {
            $query->where('status', 'finished')->orderByDesc('finished_at');
        })->with(['authors', 'readingStatus'])->take(5)->get();
        
        return view('home', compact('totalBooks', 'currentlyReading', 'completed', 'recentlyAdded', 'recentlyFinished'));
    }
}