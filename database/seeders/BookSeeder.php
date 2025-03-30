<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\ReadingStatus;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        // Create some authors
        $author1 = Author::create(['name' => 'J.K. Rowling']);
        $author2 = Author::create(['name' => 'George R.R. Martin']);
        $author3 = Author::create(['name' => 'J.R.R. Tolkien']);
        
        // Create some books
        $book1 = Book::create([
            'title' => 'Harry Potter and the Philosopher\'s Stone',
            'isbn' => '9780747532743',
            'description' => 'Harry Potter has never even heard of Hogwarts when the letters start dropping on the doormat at number four, Privet Drive...',
            'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780747532743-L.jpg',
            'page_count' => 223,
            'published_year' => 1997,
        ]);
        $book1->authors()->attach($author1);
        ReadingStatus::create([
            'book_id' => $book1->id,
            'status' => 'finished',
            'current_page' => 223,
            'started_at' => now()->subMonths(2),
            'finished_at' => now()->subMonths(1),
            'rating' => 5,
            'notes' => 'Loved this book! Great introduction to the wizarding world.',
        ]);
        
        $book2 = Book::create([
            'title' => 'A Game of Thrones',
            'isbn' => '9780553573404',
            'description' => 'In a land where summers can last decades and winters a lifetime, trouble is brewing...',
            'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780553573404-L.jpg',
            'page_count' => 694,
            'published_year' => 1996,
        ]);
        $book2->authors()->attach($author2);
        ReadingStatus::create([
            'book_id' => $book2->id,
            'status' => 'in_progress',
            'current_page' => 350,
            'started_at' => now()->subWeeks(2),
        ]);
        
        $book3 = Book::create([
            'title' => 'The Lord of the Rings',
            'isbn' => '9780618640157',
            'description' => 'One Ring to rule them all, One Ring to find them, One Ring to bring them all and in the darkness bind them...',
            'cover_url' => 'https://covers.openlibrary.org/b/isbn/9780618640157-L.jpg',
            'page_count' => 1178,
            'published_year' => 1954,
        ]);
        $book3->authors()->attach($author3);
        ReadingStatus::create([
            'book_id' => $book3->id,
            'status' => 'not_started',
        ]);
    }
}