<!-- resources/views/books/search-results.blade.php -->
@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Search Results</h1>
        <div>
            <a href="{{ route('books.create') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Add Book
            </a>
            <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-book"></i> My Books
            </a>
        </div>
    </div>
    
    @if(isset($results['items']) && count($results['items']) > 0)
        <div class="row g-4">
            @foreach($results['items'] as $item)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150x200?text=No+Cover' }}" 
                                    class="img-fluid rounded-start" alt="{{ $item['volumeInfo']['title'] ?? 'Book cover' }}">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item['volumeInfo']['title'] ?? 'Unknown Title' }}</h5>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            {{ isset($item['volumeInfo']['authors']) ? implode(', ', $item['volumeInfo']['authors']) : 'Unknown Author' }}
                                        </small>
                                    </p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            {{ $item['volumeInfo']['publishedDate'] ?? 'Unknown Date' }} • 
                                            {{ $item['volumeInfo']['pageCount'] ?? '?' }} pages
                                        </small>
                                    </p>
                                    <form action="{{ route('books.import') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="book_data" value="{{ json_encode($item) }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Add to Library
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <p>No books found matching your search criteria.</p>
            <a href="{{ route('books.create') }}" class="btn btn-outline-primary mt-2">Try Another Search</a>
        </div>
    @endif
@endsection