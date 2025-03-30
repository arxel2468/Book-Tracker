<!-- resources/views/authors/create.blade.php -->
@extends('layouts.app')

@section('title', 'Add Author')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add New Author</h1>
        <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Authors
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('authors.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                        id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Author
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection