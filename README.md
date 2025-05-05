# BRACU Research Repository — Laravel Edition (Patch)

[Demonstration Video for the Full Project](https://drive.google.com/drive/folders/14txPoOPVSpPDhjxw53NXhYe_WOGWYLKD?usp=sharing)

This archive contains **only the application code** (models, migrations, controllers, Blade templates, routes, seeders)
needed to replicate the features of your legacy PHP research repository in Laravel 11.

## Prerequisites

1. PHP 8.2+
2. Composer
3. MySQL (or MariaDB)
4. Node 18+ (for Vite + Tailwind) — optional for UI polish
5. A fresh Laravel 11 project

```bash
composer create-project laravel/laravel bracu_repo
cd bracu_repo
```

## How to apply this patch

1. **Unzip** the archive inside the root of your fresh Laravel project **and overwrite** when prompted.
   This will drop `app/`, `database/`, `resources/`, and `routes/` files into place.
2. Copy the example env and adjust DB creds:

    ```bash
    cp .env.example .env
    php artisan key:generate
    # edit .env -> DB_DATABASE, DB_USERNAME, DB_PASSWORD
    ```
3. **Install dependencies** (Jetstream for ready‑made auth + profile management):

    ```bash
    composer require laravel/jetstream
    php artisan jetstream:install livewire
    npm install && npm run build   # or yarn
    php artisan migrate
    ```

4. **Seed the database** with a demo admin user (optional):

    ```bash
    php artisan db:seed --class=DemoSeeder
    ```

5. **Serve**:

    ```bash
    php artisan serve
    ```

Visit <http://127.0.0.1:8000> and sign up / sign in.

## Key Features Implemented

| Legacy PHP | Laravel Replacement |
|------------|--------------------|
| Raw sessions & SQL | Laravel Sanctum sessions + Eloquent |
| Mixed PHP/HTML | Blade templates |
| Duplicate DB code | Reusable Eloquent models & repositories |
| No routing layer | `routes/web.php` + controllers |
| Manual file uploads | `Storage::disk('public')` with validation |
| No RBAC | Gate‑based `Role` middleware |
| SQL‑injection risk | Prepared statements by default |

## Next Steps

* Tailwind + Livewire components to refine UI/UX.
* Add full‑text search (Laravel Scout + Meilisearch) instead of crude `LIKE`.
* Queue notification e‑mails on paper borrow/return.

---
_Generated 2025-04-26 05:55 automatically._
