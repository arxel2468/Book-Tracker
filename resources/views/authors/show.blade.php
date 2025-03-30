<!-- resources/views/authors/show.blade.php -->
@extends('layouts.app')

@section('title', $author->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $author->name }}</h1>
        <div>
            <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Authors
            </a>
            <a href="{{ route('authors.edit', $author) }}" class="btn btn-outline-primary ms-2">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('authors.destroy', $author) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger ms-2" 
                    onclick="return confirm('Are you sure you want to delete this author?')">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Books by {{ $author->name }}</h5>
        </div>
        <div class="card-body">
            @if($author->books->count() > 0)
                <div class="row g-4">
                    @foreach($author->books as $book)
                        <div class="col-md-3">
                            <div class="card h-100 book-card">
                                <img src="{{ $book->cover_url ?? 'https://via.placeholder.com/150x200?text=No+Cover' }}" 
                                     class="card-img-top book-cover" alt="{{ $book->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $book->title }}</h5>
                                    @if($book->published_year)
                                        <p class="card-text text-muted">{{ $book->published_year }}</p>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-outline-primary">Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No books found for this author.</p>
            @endif
        </div>
    </div>
@endsection