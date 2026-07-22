@echo off
echo ========================================
Angkor Shop - Laravel 13 Setup
echo ========================================
echo.

REM Try to find PHP 8.4+ in common locations
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo PHP not found in PATH, checking common locations...
    if exist "C:\laragon\bin\php\php-8.4*" (
        for /d %%i in ("C:\laragon\bin\php\php-8.4*") do set PATH=%%i;%PATH%
    ) else if exist "C:\xampp\php\php.exe" (
        set PATH=C:\xampp\php;%PATH%
    ) else (
        echo ERROR: PHP 8.4+ not found!
        echo Please install PHP 8.4 or add it to your PATH.
        pause
        exit /b 1
    )
)

php -v
echo.

echo Installing Composer dependencies...
composer install --no-interaction --prefer-dist
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed!
    pause
    exit /b 1
)

echo.
echo Creating storage link...
php artisan storage:link

echo.
echo Running migrations...
php artisan migrate --force

echo.
echo Seeding database...
php artisan db:seed --force

echo.
echo Installing NPM dependencies...
call npm install

echo.
echo Building frontend assets...
call npm run build

echo.
echo ========================================
echo Setup complete!
echo Run "php artisan serve" to start the server.
echo.
echo Admin login: admin@angkorshop.com / admin123
echo Test user: user@example.com / password
echo ========================================
pause
