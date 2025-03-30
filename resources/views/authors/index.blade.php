<!-- resources/views/authors/index.blade.php -->
@extends('layouts.app')

@section('title', 'Authors')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Authors</h1>
        <a href="{{ route('authors.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Author
        </a>
    </div>
    
    @if($authors->count() > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Books</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($authors as $author)
                                        <tr>
                                            <td>{{ $author->name }}</td>
                                            <td>{{ $author->books_count }}</td>
                                            <td>
                                                <a href="{{ route('authors.show', $author) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                                <a href="{{ route('authors.edit', $author) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('authors.destroy', $author) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this author?')">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <p>No authors found. <a href="{{ route('authors.create') }}">Add your first author</a>.</p>
        </div>
    @endif
@endsection