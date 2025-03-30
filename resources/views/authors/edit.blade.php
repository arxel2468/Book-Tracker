<!-- resources/views/authors/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Author')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Author</h1>
        <a href="{{ route('authors.show', $author) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Author
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('authors.update', $author) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                        id="name" name="name" value="{{ old('name', $author->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection