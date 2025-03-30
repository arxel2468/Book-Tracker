# Book Tracker

A Laravel application for managing your book collection, tracking your reading progress, and maintaining a reading list.

## Features

- Add books manually or import from Google Books API
- Track reading status (not started, in progress, finished)
- Record reading progress, start/end dates, and ratings
- Organize books by authors
- Dashboard with reading statistics

## Requirements

- PHP 8.1 or higher
- Composer
- SQLite (or other database of your choice)

## Installation

1. Clone the repository:
git clone https://github.com/arxel2468/book-tracker.git
cd book-tracker



2. Install dependencies:
composer install



3. Copy environment file:
cp .env.example .env



4. Generate application key:
php artisan key:generate



5. Configure database in `.env` file:
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite



6. Create SQLite database:
touch database/database.sqlite



7. Run migrations:
php artisan migrate



8. (Optional) Seed the database with sample data:
php artisan db:seed



9. Start the development server:
php artisan serve



10. Visit `http://localhost:8000` in your browser to use the application.

## Usage

- **Dashboard**: View your reading statistics and recently added/finished books
- **My Books**: Browse, filter, and search your book collection
- **Authors**: View and manage authors in your collection
- **Add Book**: Add books manually or search by ISBN/title using Google Books API
To use this application, you'll need to run the following commands:


php artisan db:seed  # Optional, to add sample data
php artisan serve    # Start the development server
This completes the Book Collection Tracker application in Laravel. The application includes:

A dashboard with reading statistics
Book management (add, edit, delete)
Author management (add, edit, delete)
Reading status tracking (not started, in progress, finished)
Google Books API integration for importing books
Responsive UI using Bootstrap 5
Filtering and searching capabilities
Rating system for finished books