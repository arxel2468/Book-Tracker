<!-- resources/views/books/create.blade.php -->
@extends('layouts.app')

@section('title', 'Add Book')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add New Book</h1>
        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Books
        </a>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Search for a Book</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('books.search') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="query" class="form-control" placeholder="Enter ISBN or title">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="isbn">Search by ISBN</option>
                        <option value="title">Search by Title</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5>Manual Entry</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('books.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                                id="isbn" name="isbn" value="{{ old('isbn') }}">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Authors *</label>
                            <div id="authors-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control @error('authors.0') is-invalid @enderror" 
                                        name="authors[]" value="{{ old('authors.0') }}" required>
                                    <button type="button" class="btn btn-outline-secondary add-author">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                @if(old('authors'))
                                    @foreach(old('authors') as $key => $author)
                                        @if($key > 0)
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control @error('authors.'.$key) is-invalid @enderror" 
                                                    name="authors[]" value="{{ $author }}">
                                                <button type="button" class="btn btn-outline-danger remove-author">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            @error('authors.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="page_count" class="form-label">Page Count</label>
                                <input type="number" class="form-control @error('page_count') is-invalid @enderror" 
                                    id="page_count" name="page_count" value="{{ old('page_count') }}">
                                @error('page_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="published_year" class="form-label">Published Year</label>
                                <input type="number" class="form-control @error('published_year') is-invalid @enderror" 
                                    id="published_year" name="published_year" value="{{ old('published_year') }}">
                                @error('published_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cover_url" class="form-label">Cover Image URL</label>
                            <input type="url" class="form-control @error('cover_url') is-invalid @enderror" 
                                id="cover_url" name="cover_url" value="{{ old('cover_url') }}">
                            @error('cover_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="cover-preview" class="mt-2 text-center d-none">
                                <img src="" alt="Cover preview" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="6">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Book
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle adding more author fields
        document.querySelector('.add-author').addEventListener('click', function() {
            const container = document.getElementById('authors-container');
            const newAuthorField = document.createElement('div');
            newAuthorField.className = 'input-group mb-2';
            newAuthorField.innerHTML = `
                <input type="text" class="form-control" name="authors[]">
                <button type="button" class="btn btn-outline-danger remove-author">
                    <i class="bi bi-dash"></i>
                </button>
            `;
            container.appendChild(newAuthorField);
            
            // Add event listener to the new remove button
            newAuthorField.querySelector('.remove-author').addEventListener('click', function() {
                container.removeChild(newAuthorField);
            });
        });
        
        // Handle removing author fields (for dynamically added ones)
        document.querySelectorAll('.remove-author').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.input-group').remove();
            });
        });
        
        // Cover image preview
        const coverUrlInput = document.getElementById('cover_url');
        const coverPreview = document.getElementById('cover-preview');
        
        coverUrlInput.addEventListener('input', function() {
            const url = this.value.trim();
            if (url) {
                coverPreview.classList.remove('d-none');
                coverPreview.querySelector('img').src = url;
            } else {
                coverPreview.classList.add('d-none');
            }
        });
        
        // Initialize cover preview if URL exists
        if (coverUrlInput.value.trim()) {
            coverPreview.classList.remove('d-none');
            coverPreview.querySelector('img').src = coverUrlInput.value.trim();
        }
    });
</script>
@endsection