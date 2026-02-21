@echo off
echo Starting Portfolio CMS Server (Docker)...

:: Check if Docker is running
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo Docker is not running! Please start Docker Desktop and try again.
    pause
    exit /b
)

:: Start Containers
echo Building and starting containers...
docker-compose up -d --build

:: Check status
if %errorlevel% neq 0 (
    echo Failed to start containers. Check logs.
    pause
    exit /b
)

echo.
echo Server is running!
echo Frontend: http://localhost
echo Admin: http://localhost/admin/login.html
echo.
echo Opening website...
timeout /t 5 >nul
start http://localhost

pause
