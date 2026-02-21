@echo off
echo Initializing Portfolio CMS (Docker)...

echo Running Migrations and Seeding...
docker-compose exec app php artisan migrate:fresh --seed

echo.
echo Initialization Complete!
pause
