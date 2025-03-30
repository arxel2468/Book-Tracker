<!-- resources/views/books/index.blade.php -->
@extends('layouts.app')

@section('title', 'My Books')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Books</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Book
        </a>
    </div>
    
    <div class="mb-4">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary active filter-btn" data-filter="all">All</button>
            <button type="button" class="btn btn-outline-primary filter-btn" data-filter="not_started">Not Started</button>
            <button type="button" class="btn btn-outline-primary filter-btn" data-filter="in_progress">In Progress</button>
            <button type="button" class="btn btn-outline-primary filter-btn" data-filter="finished">Finished</button>
        </div>
    </div>
    
    @if($books->count() > 0)
        <div class="row g-4">
            @foreach($books as $book)
                <div class="col-md-3 book-item" data-status="{{ $book->readingStatus->status ?? 'not_started' }}">
                    <div class="card h-100 book-card">
                        <div class="position-relative">
                            <img src="{{ $book->cover_url ?? 'https://via.placeholder.com/150x200?text=No+Cover' }}" 
                                 class="card-img-top book-cover" alt="{{ $book->title }}">
                            <div class="position-absolute top-0 end-0 p-2">
                                @if(isset($book->readingStatus))
                                    @if($book->readingStatus->status == 'not_started')
                                        <span class="badge bg-secondary">Not Started</span>
                                    @elseif($book->readingStatus->status == 'in_progress')
                                        <span class="badge bg-primary">Reading</span>
                                    @elseif($book->readingStatus->status == 'finished')
                                        <span class="badge bg-success">Finished</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Not Started</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text text-muted">
                                {{ $book->authors->pluck('name')->join(', ') }}
                            </p>
                            @if(isset($book->readingStatus) && $book->readingStatus->status == 'in_progress')
                                <div class="progress mb-2">
                                    @php
                                        $progress = $book->page_count ? min(100, round(($book->readingStatus->current_page / $book->page_count) * 100)) : 0;
                                    @endphp
                                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%">
                                        {{ $progress }}%
                                    </div>
                                </div>
                            @endif
                            @if(isset($book->readingStatus) && $book->readingStatus->rating)
                                <div class="mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $book->readingStatus->rating ? 'bi-star-fill' : 'bi-star' }} rating"></i>
                                    @endfor
                                </div>
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
        <div class="alert alert-info">
            <p>You haven't added any books yet. <a href="{{ route('books.create') }}">Add your first book</a>.</p>
        </div>
    @endif
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const bookItems = document.querySelectorAll('.book-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Toggle active class
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter books
                bookItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-status') === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endsection