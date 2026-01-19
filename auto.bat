@echo off
taskkill /f /im chromedriver.exe >nul 2>&1

start "" ".\chromedriver.exe" --port=9515
timeout /t 2 >nul

node .\control.js