#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")" && pwd)"
[ -f "$ROOT/backend/.env" ] || cp "$ROOT/backend/.env.example" "$ROOT/backend/.env"
[ -f "$ROOT/frontend/.env" ] || cp "$ROOT/frontend/.env.example" "$ROOT/frontend/.env"
touch "$ROOT/backend/database/database.sqlite"

(
  cd "$ROOT/backend"
  composer install
  php artisan key:generate --force
  php artisan migrate --seed
  php artisan storage:link || true
  php artisan serve
) &
BACKEND_PID=$!

(
  cd "$ROOT/frontend"
  npm install
  npm run dev
) &
FRONTEND_PID=$!

trap 'kill "$BACKEND_PID" "$FRONTEND_PID" 2>/dev/null || true' EXIT
wait
