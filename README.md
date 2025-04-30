
# To Do App (Laravel 11)

A simple Trello-style task board built with **Laravel 11**, using **Bootstrap 5** and **Drag & Drop** features.  
Each registered user can manage their own cards across 4 lists: `ToDo`, `In Progress`, `Testing`, and `Done`.

---

## Features
- ✅ Laravel Breeze Authentication (Login, Register)
- ✅ 4 Task Lists (ToDo, In Progress, Testing, Done)
- ✅ Create cards (tasks) — only visible to the card owner
- ✅ Drag and drop cards between lists
- ✅ Edit card titles by double-clicking
- ✅ Delete cards
- ✅ Shows "Created by" user name

---

## Installation Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/durjaygp/laravel-todo-app.git
cd laravel-todo-app
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
Copy the `.env.example` file:
```bash
cp .env.example .env
```

Then generate the app key:
```bash
php artisan key:generate
```

### 4. Configure Database
Open `.env` and set your database connection:
```
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Install and Build Assets
```bash
npm run dev
```
*(For production build, use `npm run build`)*

---

## Authentication Setup
This project uses Laravel Breeze.

To install it manually (if not yet done):

```bash
composer require laravel/breeze --dev
php artisan breeze:install bootstrap
npm install
npm run dev
php artisan migrate
```

---

## Running the App

```bash
php artisan serve
```

Visit: [http://127.0.0.1:8000/](http://127.0.0.1:8000/)

---

## Usage

1. **Register** a new user.
2. On dashboard, you'll see 4 lists:
    - `ToDo`
    - `In Progress`
    - `Testing`
    - `Done`
3. **Add cards** using the form.
4. **Drag and drop** cards to move between lists.
5. **Double click** the card title to edit.
6. **Delete** a card using the red **x** button.

---

## Notes
- Bootstrap is used for styling.
- JavaScript handles drag & drop and inline editing.
---
