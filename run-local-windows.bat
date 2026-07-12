@echo off
setlocal

echo ==============================================
echo MAHAPRABHU TECH - Local Development Launcher
echo ==============================================

if not exist backend\.env copy backend\.env.example backend\.env
if not exist frontend\.env copy frontend\.env.example frontend\.env
if not exist backend\database\database.sqlite type nul > backend\database\database.sqlite

start "Mahaprabhu Laravel API" cmd /k "cd /d %~dp0backend && composer install && php artisan key:generate --force && php artisan migrate --seed && php artisan storage:link && php artisan serve"
start "Mahaprabhu React Website" cmd /k "cd /d %~dp0frontend && npm install && npm run dev"

echo Two terminal windows were opened.
echo Website: http://localhost:5173
echo API:     http://127.0.0.1:8000
pause
