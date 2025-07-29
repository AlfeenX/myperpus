# MyPerpus

MyPerpus is a Laravel-based library management system. It provides features for managing books, members, borrowings, and user authentication, with a modern UI powered by Filament and Livewire.

## Features

- Book management (CRUD)
- Member management (CRUD)
- Borrowing records and status tracking
- User authentication and profile management
- Responsive UI with Filament and Tailwind CSS

## Requirements

- PHP >= 8.1
- Composer
- Node.js & npm
- SQLite (default) or other supported database

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/yourusername/myperpus.git
   cd myperpus
   ```

2. **Install PHP dependencies:**
   ```sh
   composer install
   ```

3. **Install JavaScript dependencies:**
   ```sh
   npm install
   ```

4. **Copy and configure environment variables:**
   ```sh
   cp .env.example .env
   # Edit .env as needed
   ```

5. **Generate application key:**
   ```sh
   php artisan key:generate
   ```

6. **Run migrations:**
   ```sh
   php artisan migrate
   ```

7. **Build frontend assets:**
   ```sh
   npm run build
   ```

8. **Start the development server:**
   ```sh
   php artisan serve
   ```

## Running Tests

```sh
php artisan test
```

## Folder Structure

- `app/Filament/Resources`: Filament resource classes for CRUD operations
- `app/Models`: Eloquent models
- `resources/views`: Blade templates
- `database/migrations`: Database schema
- `config`: Configuration files

## License

This project is open-source and available under the [MIT license](LICENSE).

---

Feel free to customize this README for your specific
