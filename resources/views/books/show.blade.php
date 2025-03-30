<!-- resources/views/books/show.blade.php -->
@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Book Details</h1>
        <div>
            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Books
            </a>
            <a href="{{ route('books.edit', $book) }}" class="btn btn-outline-primary ms-2">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger ms-2" onclick="return confirm('Are you sure you want to delete this book?')">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ $book->cover_url ?? 'https://via.placeholder.com/300x450?text=No+Cover' }}" 
                    class="card-img-top" alt="{{ $book->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="card-text">
                        <strong>Author(s):</strong> {{ $book->authors->pluck('name')->join(', ') }}
                    </p>
                    @if($book->isbn)
                        <p class="card-text">
                            <strong>ISBN:</strong> {{ $book->isbn }}
                        </p>
                    @endif
                    @if($book->published_year)
                        <p class="card-text">
                            <strong>Published:</strong> {{ $book->published_year }}
                        </p>
                    @endif
                    @if($book->page_count)
                        <p class="card-text">
                            <strong>Pages:</strong> {{ $book->page_count }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Description</h5>
                </div>
                <div class="card-body">
                    @if($book->description)
                        <p class="card-text">{{ $book->description }}</p>
                    @else
                        <p class="text-muted">No description available.</p>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Reading Status</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                        <i class="bi bi-pencil"></i> Update
                    </button>
                </div>
                <div class="card-body">
                    @if($book->readingStatus)
                        <div class="mb-3">
                            <h6>Status</h6>
                            @if($book->readingStatus->status == 'not_started')
                                <span class="badge bg-secondary">Not Started</span>
                            @elseif($book->readingStatus->status == 'in_progress')
                                <span class="badge bg-primary">Currently Reading</span>
                            @elseif($book->readingStatus->status == 'finished')
                                <span class="badge bg-success">Finished</span>
                            @endif
                        </div>
                        
                        @if($book->readingStatus->status == 'in_progress' && $book->page_count)
                            <div class="mb-3">
                                <h6>Progress</h6>
                                <div class="progress">
                                    @php
                                        $progress = min(100, round(($book->readingStatus->current_page / $book->page_count) * 100));
                                    @endphp
                                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%">
                                        {{ $progress }}% ({{ $book->readingStatus->current_page }} of {{ $book->page_count }} pages)
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="row mb-3">
                            @if($book->readingStatus->started_at)
                                <div class="col-md-6">
                                    <h6>Started Reading</h6>
                                    <p>{{ $book->readingStatus->started_at->format('F j, Y') }}</p>
                                </div>
                            @endif
                            
                            @if($book->readingStatus->finished_at)
                                <div class="col-md-6">
                                    <h6>Finished Reading</h6>
                                    <p>{{ $book->readingStatus->finished_at->format('F j, Y') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($book->readingStatus->rating)
                            <div class="mb-3">
                                <h6>My Rating</h6>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $book->readingStatus->rating ? 'bi-star-fill' : 'bi-star' }} rating"></i>
                                    @endfor
                                    <span class="ms-2 text-muted">{{ $book->readingStatus->rating }}/5</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($book->readingStatus->notes)
                            <div class="mb-3">
                                <h6>Notes</h6>
                                <p>{{ $book->readingStatus->notes }}</p>
                            </div>
                        @endif
                    @else
                        <p class="text-muted">No reading status available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Update Reading Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('reading-status.update', $book) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">Update Reading Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="not_started" {{ ($book->readingStatus->status ?? '') == 'not_started' ? 'selected' : '' }}>Not Started</option>
                                <option value="in_progress" {{ ($book->readingStatus->status ?? '') == 'in_progress' ? 'selected' : '' }}>Currently Reading</option>
                                <option value="finished" {{ ($book->readingStatus->status ?? '') == 'finished' ? 'selected' : '' }}>Finished</option>
                            </select>
                        </div>
                        
                        <div class="mb-3 reading-field">
                            <label for="current_page" class="form-label">Current Page</label>
                            <input type="number" class="form-control" id="current_page" name="current_page" 
                                value="{{ $book->readingStatus->current_page ?? 0 }}" min="0" max="{{ $book->page_count ?? 9999 }}">
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 reading-field">
                                <label for="started_at" class="form-label">Date Started</label>
                                <input type="date" class="form-control" id="started_at" name="started_at" 
                                    value="{{ optional(optional($book->readingStatus)->started_at)->format('Y-m-d') }}">
                            </div>
                            
                            <div class="col-md-6 finished-field">
                                <label for="finished_at" class="form-label">Date Finished</label>
                                <input type="date" class="form-control" id="finished_at" name="finished_at" 
                                    value="{{ optional(optional($book->readingStatus)->finished_at)->format('Y-m-d') }}">
                            </div>
                        </div>
                        
                        <div class="mb-3 finished-field">
                            <label for="rating" class="form-label">Rating</label>
                            <div class="rating-input">
                                <div class="d-flex align-items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input visually-hidden" type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                                                {{ ($book->readingStatus->rating ?? 0) == $i ? 'checked' : '' }}>
                                            <label class="form-check-label" for="star{{ $i }}">
                                                <i class="bi bi-star-fill {{ ($book->readingStatus->rating ?? 0) >= $i ? 'text-warning' : 'text-secondary' }}"></i>
                                            </label>
                                        </div>
                                    @endfor
                                    <span class="ms-2 rating-text">
                                        {{ ($book->readingStatus->rating ?? 0) > 0 ? ($book->readingStatus->rating . '/5') : 'No rating' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ $book->readingStatus->notes ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded successfully');
        
        // Get elements
        const statusSelect = document.getElementById('status');
        const readingFields = document.querySelectorAll('.reading-field');
        const finishedFields = document.querySelectorAll('.finished-field');
        
        console.log('Status select:', statusSelect);
        console.log('Reading fields:', readingFields.length);
        console.log('Finished fields:', finishedFields.length);
        
        // Initially set display property directly with !important to override any CSS
        readingFields.forEach(field => {
            if (statusSelect.value === 'not_started') {
                field.setAttribute('style', 'display: none !important');
            } else {
                field.setAttribute('style', 'display: block !important');
            }
        });
        
        finishedFields.forEach(field => {
            if (statusSelect.value === 'finished') {
                field.setAttribute('style', 'display: block !important');
            } else {
                field.setAttribute('style', 'display: none !important');
            }
        });
        
        // Add event listener to status select
        statusSelect.addEventListener('change', function() {
            console.log('Status changed to:', this.value);
            
            readingFields.forEach(field => {
                if (this.value === 'not_started') {
                    field.setAttribute('style', 'display: none !important');
                } else {
                    field.setAttribute('style', 'display: block !important');
                }
            });
            
            finishedFields.forEach(field => {
                if (this.value === 'finished') {
                    field.setAttribute('style', 'display: block !important');
                } else {
                    field.setAttribute('style', 'display: none !important');
                }
            });
        });
        
        // Star rating functionality
        const ratingInputs = document.querySelectorAll('.rating-input input[type="radio"]');
        const ratingLabels = document.querySelectorAll('.rating-input label');
        const ratingStars = document.querySelectorAll('.rating-input label i');
        const ratingText = document.querySelector('.rating-text');
        
        ratingLabels.forEach((label, index) => {
            // When hovering over a star
            label.addEventListener('mouseenter', function() {
                // Highlight this star and all previous stars
                for (let i = 0; i <= index; i++) {
                    ratingStars[i].classList.add('text-warning');
                    ratingStars[i].classList.remove('text-secondary');
                }
                // Un-highlight all following stars
                for (let i = index + 1; i < ratingStars.length; i++) {
                    ratingStars[i].classList.remove('text-warning');
                    ratingStars[i].classList.add('text-secondary');
                }
            });
            
            // When clicking a star
            label.addEventListener('click', function() {
                const starValue = index + 1;
                ratingInputs[index].checked = true;
                if (ratingText) {
                    ratingText.textContent = starValue + '/5';
                }
            });
        });
        
        // When mouse leaves the rating container
        const ratingContainer = document.querySelector('.rating-input');
        if (ratingContainer) {
            ratingContainer.addEventListener('mouseleave', function() {
                // Find which star is selected
                let selectedIndex = -1;
                ratingInputs.forEach((input, i) => {
                    if (input.checked) {
                        selectedIndex = i;
                    }
                });
                
                // Reset stars based on selection
                ratingStars.forEach((star, i) => {
                    if (i <= selectedIndex) {
                        star.classList.add('text-warning');
                        star.classList.remove('text-secondary');
                    } else {
                        star.classList.remove('text-warning');
                        star.classList.add('text-secondary');
                    }
                });
            });
        }
    });
</script>
@endsection