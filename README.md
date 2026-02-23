# BookStock Management System

A robust book stock management system built with **Laravel 12**, **Blade Templating**, and **PHP Query Builder**.

## Key Features
- **User Authentication**: Secure Login, Registration, and Logout.
- **Profile Management**: Update user profile and change passwords.
- **Author Management**: Full CRUD operations for authors.
- **Category Management**: Full CRUD operations for categories.
- **Book Management**: Full CRUD operations for books with cover image upload.
- **Cascading Deletes**: Automatic deletion of related books when an author or category is removed.

## Tech Stack
- **Framework**: Laravel 12
- **Frontend**: Blade & CSS
- **Database Logic**: PHP Query Builder


## Setup Procedures
1. **Dependencies**: `composer install` & `npm install`
2. **Environment**: `cp .env.example .env` & `php artisan key:generate`
3. **Database & Storage**: Configure `.env`, run `php artisan migrate`, and run **`php artisan storage:link`** (required for book cover images).
4. **Assets**: `npm run dev` or `npm run build`
5. **Run**: `php artisan serve`

## Initial Steps
1. **Create Account**: After setting up the project, navigate to the **Signup** page to create your account first.
2. **Manage Content**: Log in to access the dashboard where you can create, edit, and delete **Categories**, **Authors**, and **Books**.