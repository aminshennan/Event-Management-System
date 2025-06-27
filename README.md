# Event Management System

A comprehensive Laravel-based Event Management Platform for creating, joining, and managing events with robust user and admin features.

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Usage](#usage)
- [Database Structure](#database-structure)
- [Contribution](#contribution)
- [License](#license)
- [Author](#author)

---

## Overview

Event Management System is a full-featured event management web application built with Laravel. It allows users to register, create events, join or leave events, and manage their profiles. Admins can approve or reject events, ensuring only quality events are published. The project demonstrates best practices in Laravel, including MVC structure, middleware, validation, and role-based access.

---

## Features

### User Features

- **Registration & Authentication:** Secure user registration, login, password reset, and email verification.
- **Profile Management:** Edit profile, update password, and delete account.
- **Event Management:**
  - Create, edit, and delete events.
  - Join or leave events (with checks for capacity, approval, and creator restriction).
  - View events created and joined.
- **Landing Page:** See popular event types and upcoming approved events.

### Admin Features

- **Admin Dashboard:** View all pending and rejected events.
- **Event Moderation:** Approve or reject events.
- **Role-Based Access:** Admin-only routes protected by custom middleware.

### General

- **Validation:** Strong validation for all forms.
- **Responsive UI:** Built with Blade templates and Tailwind CSS.
- **Database Relationships:** Users, Events, EventDates, and Participants with clear Eloquent relationships.

---

## Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Blade, JavaScript, Tailwind CSS
- **Database:** MySQL (or compatible)
- **Build Tools:** Composer, npm, Vite

---

## Project Structure

```
app/
  Http/
    Controllers/         # All controllers (Admin, Auth, Event, Dashboard, etc.)
    Middleware/          # Custom and core middleware (e.g., AdminMiddleware)
    Requests/            # Form request validation
  Models/                # Eloquent models (User, Event, EventDate, Participant)
resources/
  views/                 # Blade templates for UI
public/                  # Public assets (CSS, JS, images)
routes/
  web.php                # Main web routes
database/
  migrations/            # Table schemas
  seeders/               # Example data for events
```

---

## Installation

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd EventManagementSystem
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node dependencies:**
   ```bash
   npm install
   ```

4. **Copy and configure environment file:**
   ```bash
   cp .env.example .env
   # Edit .env for your DB and mail settings
   ```

5. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations and seeders:**
   ```bash
   php artisan migrate --seed
   ```

7. **Build frontend assets:**
   ```bash
   npm run dev
   # or for production
   npm run build
   ```

8. **Start the server:**
   ```bash
   php artisan serve
   ```

---

## Usage

- Visit `http://localhost:8000` in your browser.
- Register as a user or log in.
- Admins can access the admin dashboard to approve/reject events.
- Users can create, join, leave, and manage events.
- Manage your profile and password.
- The landing page displays popular event types and upcoming events.

---

## Database Structure

- **users:** Stores user information, roles, and profile data.
- **events:** Stores event details, creator, status, and approval info.
- **event_dates:** Stores start/end dates and times for events.
- **participants:** Pivot table for users joining events.

---

## Contribution

1. Fork the repository
2. Create a new branch (`git checkout -b feature/your-feature`)
3. Commit your changes
4. Push to your branch
5. Open a Pull Request

---

## License

This project was created for educational purposes. Add a license if you wish to open source it.

---

## Author

Developed by Amin.  
