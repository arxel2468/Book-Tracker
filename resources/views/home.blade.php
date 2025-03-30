<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">My Reading Dashboard</h1>
    
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-book"></i> Total Books</h5>
                    <h2 class="card-text">{{ $totalBooks }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-hourglass-split"></i> Currently Reading</h5>
                    <h2 class="card-text">{{ $currentlyReading }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-check-circle"></i> Completed</h5>
                    <h2 class="card-text">{{ $completed }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-plus-circle"></i> Recently Added</h5>
                </div>
                <div class="card-body">
                    @if($recentlyAdded->count() > 0)
                        <div class="list-group">
                            @foreach($recentlyAdded as $book)
                                <a href="{{ route('books.show', $book) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $book->title }}</h6>
                                        <small>{{ $book->created_at->diffForHumans() }}</small>
                                    </div>
                                    <small>{{ $book->authors->pluck('name')->join(', ') }}</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No books added yet.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-check-circle"></i> Recently Finished</h5>
                </div>
                <div class="card-body">
                    @if($recentlyFinished->count() > 0)
                        <div class="list-group">
                            @foreach($recentlyFinished as $book)
                                <a href="{{ route('books.show', $book) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $book->title }}</h6>
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= ($book->readingStatus->rating ?? 0) ? 'bi-star-fill' : 'bi-star' }} rating"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <small>{{ $book->authors->pluck('name')->join(', ') }}</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No books finished yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="{{ route('books.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Add New Book
        </a>
    </div>
@endsection