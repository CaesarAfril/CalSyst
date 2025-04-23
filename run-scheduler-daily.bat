@echo off
cd C:\laragon\www\CalSyst
php artisan schedule:run >> storage/logs/scheduler.log 2>&1