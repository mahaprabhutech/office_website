# 6. Local Installation

## Requirements

- PHP 8.3+
- Composer
- Node.js 20+
- npm
- MySQL/PostgreSQL, or SQLite for local use

## Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

Create the SQLite file:

```powershell
New-Item database/database.sqlite -ItemType File
```

Run:

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Backend: `http://127.0.0.1:8000`

## Frontend

```bash
cd frontend
npm install
cp .env.example .env
npm run dev
```

Frontend: `http://localhost:5173`

## Admin login

- Email: `admin@mahaprabhutech.com`
- Password: `ChangeMe@123`

## Production frontend build

```bash
npm run build
```
