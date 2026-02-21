@echo off
setlocal
title Portfolio CMS Launcher

echo ==========================================
echo      Portfolio CMS Docker Launcher
echo ==========================================
echo.

:: Check Docker
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Docker is not running! Please start Docker Desktop.
    pause
    exit /b
)

:: Start Containers
echo [INFO] Starting containers...
docker-compose up -d --build

if %errorlevel% neq 0 (
    echo [ERROR] Failed to start containers.
    pause
    exit /b
)

echo.
echo [SUCCESS] Containers are running.
echo.

:: Database Init Prompt
set /p init_db="Do you want to reset and seed the database? (y/N): "
if /i "%init_db%"=="y" (
    echo.
    echo [INFO] Resetting database...
    docker-compose exec app php artisan migrate:fresh --seed
    echo [SUCCESS] Database initialized.
) else (
    echo [INFO] Skipping database initialization.
)

:: Open Browser
echo.
echo [INFO] Opening website...
timeout /t 3 >nul
start http://localhost

echo.
echo ==========================================
echo    System Running! Close window to exit.
echo ==========================================
pause
