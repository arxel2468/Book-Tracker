<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\ReadingStatus;
use App\Services\GoogleBooksService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $googleBooksService;
    
    public function __construct(GoogleBooksService $googleBooksService)
    {
        $this->googleBooksService = $googleBooksService;
    }
    
    public function index()
    {
        $books = Book::with(['authors', 'readingStatus'])->get();
        return view('books.index', compact('books'));
    }
    
    public function create()
    {
        return view('books.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|url',
            'page_count' => 'nullable|integer',
            'published_year' => 'nullable|integer',
            'authors' => 'required|array',
            'authors.*' => 'string|max:255',
        ]);
        
        $book = Book::create([
            'title' => $validated['title'],
            'isbn' => $validated['isbn'],
            'description' => $validated['description'],
            'cover_url' => $validated['cover_url'],
            'page_count' => $validated['page_count'],
            'published_year' => $validated['published_year'],
        ]);
        
        // Handle authors
        foreach ($validated['authors'] as $authorName) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $book->authors()->attach($author);
        }
        
        // Create default reading status
        ReadingStatus::create([
            'book_id' => $book->id,
            'status' => 'not_started',
        ]);
        
        return redirect()->route('books.index')
            ->with('success', 'Book added successfully!');
    }
    
    public function show(Book $book)
    {
        $book->load(['authors', 'readingStatus']);
        return view('books.show', compact('book'));
    }
    
    public function edit(Book $book)
    {
        $book->load('authors');
        return view('books.edit', compact('book'));
    }
    
   
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|url',
            'page_count' => 'nullable|integer',
            'published_year' => 'nullable|integer',
            'authors' => 'required|array',
            'authors.*' => 'string|max:255',
        ]);
        
        $book->update([
            'title' => $validated['title'],
            'isbn' => $validated['isbn'],
            'description' => $validated['description'],
            'cover_url' => $validated['cover_url'],
            'page_count' => $validated['page_count'],
            'published_year' => $validated['published_year'],
        ]);
        
        // Update authors
        $book->authors()->detach();
        foreach ($validated['authors'] as $authorName) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $book->authors()->attach($author);
        }
        
        return redirect()->route('books.show', $book)
            ->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type', 'title');
        
        if (empty($query)) {
            return redirect()->route('books.create')
                ->with('error', 'Please enter a search term');
        }
        
        if ($type === 'isbn') {
            $results = $this->googleBooksService->searchByIsbn($query);
        } else {
            $results = $this->googleBooksService->searchByTitle($query);
        }
        
        return view('books.search-results', compact('results'));
    }

    public function importFromGoogle(Request $request)
    {
        $bookData = json_decode($request->input('book_data'), true);
        
        if (!$bookData) {
            return redirect()->route('books.create')
                ->with('error', 'Invalid book data');
        }
        
        // Extract data from Google Books API response
        $volumeInfo = $bookData['volumeInfo'] ?? [];
        
        $book = Book::create([
            'title' => $volumeInfo['title'] ?? 'Unknown Title',
            'isbn' => $volumeInfo['industryIdentifiers'][0]['identifier'] ?? null,
            'description' => $volumeInfo['description'] ?? null,
            'cover_url' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
            'page_count' => $volumeInfo['pageCount'] ?? null,
            'published_year' => isset($volumeInfo['publishedDate']) ? 
                substr($volumeInfo['publishedDate'], 0, 4) : null,
        ]);
        
        // Handle authors
        if (isset($volumeInfo['authors'])) {
            foreach ($volumeInfo['authors'] as $authorName) {
                $author = Author::firstOrCreate(['name' => $authorName]);
                $book->authors()->attach($author);
            }
        }
        
        // Create default reading status
        ReadingStatus::create([
            'book_id' => $book->id,
            'status' => 'not_started',
        ]);
        
        return redirect()->route('books.show', $book)
            ->with('success', 'Book imported successfully!');
    }
}