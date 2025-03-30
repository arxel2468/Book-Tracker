# Book Tracker 📚

A modern Laravel application for managing your personal book collection, tracking reading progress, and maintaining a comprehensive reading list.

## ✨ Features

- 📖 Add books manually or import from Google Books API
- 📊 Track reading status (not started, in progress, finished)
- 📅 Record reading progress, start/end dates, and ratings
- 👥 Organize books by authors
- 📈 Interactive dashboard with reading statistics
- 🔍 Advanced search and filtering capabilities
- 📱 Responsive design for all devices

## 🚀 Tech Stack

- PHP 8.1+
- Laravel Framework
- SQLite (default) / MySQL / PostgreSQL
- Bootstrap 5
- Google Books API

## 📋 Prerequisites

- PHP 8.1 or higher
- Composer
- SQLite (or other database of your choice)
- Node.js & NPM (for frontend assets)

## 🛠️ Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/arxel2468/book-tracker.git
   cd book-tracker
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   - Edit `.env` file:
     ```
     DB_CONNECTION=sqlite
     DB_DATABASE=/absolute/path/to/database.sqlite
     ```
   - Create SQLite database:
     ```bash
     touch database/database.sqlite
     ```

5. **Run migrations and seed data**
   ```bash
   php artisan migrate
   php artisan db:seed  # Optional: adds sample data
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   Visit `http://localhost:8000` in your browser

## 📱 Features in Detail

### Dashboard
- View reading statistics and progress
- Track recently added and finished books
- Monitor reading goals and achievements

### Book Management
- Add books manually or via Google Books API
- Track reading status and progress
- Rate and review finished books
- Organize books by categories and tags

### Author Management
- Maintain author profiles
- View all books by specific authors
- Track author statistics

### Search & Filter
- Advanced search functionality
- Filter by reading status
- Sort by various criteria
- Quick access to favorite books

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🙏 Acknowledgments

- Laravel Framework
- Google Books API
- Bootstrap 5
- All contributors and users of this project

---

Made with ❤️ by Amit Pandit