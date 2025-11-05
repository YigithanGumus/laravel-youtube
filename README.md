# 🎬 Laravel YouTube Clone

> Full-stack video sharing platform built with **Laravel**, **Vue 3**, **Vite**, and **Tailwind CSS**.  
> Includes background jobs, real-time interactivity, and a clean modern UI.

---

## 🧩 About

This project is a **YouTube-like platform** developed as a full-stack Laravel application.  
It demonstrates advanced use of Laravel’s backend ecosystem with **Job Queues**, **Eloquent**, and **Blade + Vue integration**,  
while leveraging **Vite** and **Tailwind CSS** for a fast, modern frontend experience.

💡 Built for learning, experimentation, and as a showcase of modern Laravel + Vue architecture.

---

## 🚀 Features

- 🎥 **Video Upload & Processing**
  - Queue-based conversion and thumbnail generation using Laravel Jobs
  - Auto-handled duration, resolution, and format detection
- 💬 **Comments & Replies**
  - Nested comments (threaded structure) with Vue reactivity
  - Instant count updates without page reload
- 👍 **Like / Dislike System**
  - Reactive like/dislike counters powered by Vue + Axios
- 🔔 **Subscriptions**
  - Subscribe/unsubscribe to channels with real-time updates
- 🔍 **Search & Categories**
  - Video filters and category-based listings
  - Clean white-themed search results page
- ⚙️ **Backend**
  - RESTful Laravel 11 API with Eloquent relationships
  - Background jobs for async operations
  - Optimized queries & caching ready
- 🎨 **Frontend**
  - Vue 3 + Vite + Tailwind CSS
  - Responsive white theme UI
- 🔐 **Auth System**
  - Laravel Breeze / Sanctum ready (optional)

---

## 🧠 Tech Stack

| Layer | Technology |
|-------|-------------|
| **Backend** | Laravel 11 (PHP 8.3) |
| **Frontend** | Vue 3 + Vite |
| **Styling** | Tailwind CSS |
| **Database** | MySQL / MariaDB |
| **Jobs / Queues** | Redis or Database Queue |
| **HTTP Client** | Axios |
| **Storage** | Local / S3 compatible driver |

---

## 🛠️ Installation

```bash
# Clone the repository
git clone https://github.com/YigithanGumus/laravel-youtube.git
cd laravel-youtube

# Install backend dependencies
composer install

# Install frontend dependencies
npm install && npm run dev

# Environment setup
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start servers
php artisan serve
npm run dev

# Start jobs
php artisan queue:work

# 📁 Folder Structure
app/
 ├── Http/
 │    ├── Controllers/
 │    ├── Requests/
 │    └── Resources/
 ├── Jobs/                  # Video processing, encoding, etc.
 ├── Models/
 └── Policies/

resources/
 ├── js/                    # Vue 3 components
 │    ├── components/
 │    └── pages/
 ├── views/                 # Blade templates
 └── css/                   # Tailwind CSS styles

# Pages
| Page             | Description                                  |
| ---------------- | -------------------------------------------- |
| **Home Page**    | Video list & category filters                |
| **Video Page**   | Player, likes, comments, replies             |
| **Channel Page** | Channel info + videos                        |
| **Upload Page**  | Video upload with progress & background jobs |
| **Search Page**  | Clean responsive white layout                |
