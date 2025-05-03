# User Onboarding & Admin Review System (Laravel 12.x)

A robust, modern Laravel application for secure user onboarding, document verification, and admin review workflows. Built with Laravel 12.x, Breeze, Spatie Laravel Permission, and Tailwind CSS.

---

## Features

### User Onboarding
- Multi-step registration with phone, address, and required file uploads (profile photo, ID front/back)
- Files stored in `storage/app/public/users/{user_id}/`
- User status set to `pending` after registration
- Users notified on registration, approval, and rejection (with reason)
- Only `approved` users can log in; clear feedback for pending/rejected users

### User Dashboard
- `/user/dashboard`: Profile summary and document previews
- Edit profile and edit documents (with validation and file re-upload)
- Navigation tailored to user role

### Admin Review
- `/admin/dashboard`: List/search/filter pending users
- View user details, approve/reject with reason
- Audit logs for all admin actions
- Admin and user notifications
- Role-based access control (RBAC) with Spatie

### Security & Architecture
- All routes protected by appropriate middleware
- RBAC enforced for all sensitive/admin routes
- Responsive, accessible UI with Tailwind CSS
- Comprehensive automated tests for user and admin flows

---

## Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- SQLite/MySQL/Postgres

### Installation
```bash
git clone https://github.com/victorkiambi/user-onboarding.git
cd user-onboarding
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
```

### Database & Storage
```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

### Running the App
```bash
php artisan serve
```
Visit [http://localhost:8000](http://localhost:8000)

---

## Deployment

The app is deployed on Fly.io:

- **Production URL:** [https://user-onboarding.fly.dev/](https://user-onboarding.fly.dev/)

---

## Demo Credentials

Use these credentials to log in as an admin or an approved user (from seeded data):

- **Admin**
  - Email: `admin@example.com`
  - Password: `password`
- **Approved User**
  - Email: `user@example.com`
  - Password: `password`

---

## Testing
Run the full test suite:
```bash
php artisan test
```

---

## Project Structure
- `app/Http/Controllers/Auth/` — Registration, login, and session logic
- `app/Http/Controllers/Admin/` — Admin review and audit
- `resources/views/user/` — User dashboard and profile views
- `resources/views/admin/` — Admin dashboard and review views
- `database/seeders/` — Seeds roles, admin, and test users
- `tests/Feature/` — Automated user and admin flow tests

---

## Contribution
Pull requests welcome! Please:
- Write clear, maintainable code
- Add/expand automated tests for new features
- Follow Laravel and project conventions

---

## License
[MIT](LICENSE)

---

## Documentation
- [System Architecture](docs/ARCHITECTURE.md)
- [Database Design & ERD](docs/DATABASE.md) 