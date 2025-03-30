<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingStatus;
use Illuminate\Http\Request;

class ReadingStatusController extends Controller
{
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'status' => 'required|in:not_started,in_progress,finished',
            'current_page' => 'nullable|integer',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date',
            'rating' => 'nullable|integer|min:1|max:5',
            'notes' => 'nullable|string',
        ]);
        
        // Create or update reading status
        if ($book->readingStatus) {
            $book->readingStatus->update($validated);
        } else {
            ReadingStatus::create([
                'book_id' => $book->id,
                ...$validated
            ]);
        }
        
        return redirect()->route('books.show', $book)
            ->with('success', 'Reading status updated!');
    }
}