@echo off
title Online Voting System Launcher
echo Starting PHP Development Server...
echo Your application will be available at: http://localhost:8000
echo.
echo Please do not close this window while using the application.
echo.
start http://localhost:8000
"C:\xampp\php\php.exe" -S localhost:8000 -t "%~dp0"
pause
