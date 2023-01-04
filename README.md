# Aplikace pro správu archiválií na síťovém disku / Application for archive management on network storage

Cílem práce je navrhnout a implementovat aplikaci, která bude fungovat na síťovém disku na platformě PHP
s úložištěm MySQL. Aplikaci uživatel poskytne adresář, ve kterém jsou nahrány archiválie (zvukové soubory
MP3, fotky PNG a JPG). Tyto soubory aplikace načte a získá z nich metadata, které následně uloží do databáze.
Po načtení souborů je možno metadata upravovat a rozšiřovat (např. vytvářet skupinu fotek). Aplikace na
vyžádání uživatele upravená metadata zapíše zpětně do souborů.

## Requirements
- Recommended to use [XAMPP 7.4.25](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.25/)
    - PHP >= 7.4.25
    - MariaDB >= 10.4.21
- npm/Node.js
- Composer

## Installation
1. create database named 'archive_management_app'
2. if needed change database connection values in .env file
3. in project root directory open cmd and run commands (DEVELOPMENT):
    - Apply changes to .env file:
        - APP_ENV=local
        - APP_DEBUG=true
    - 'npm install'
    - 'composer install'
    - 'php artisan migrate'
    - 'npm run dev'
4. in project root directory open cmd and run commands (PRODUCTION):
    - Apply changes to .env file:
        - APP_ENV=production
        - APP_DEBUG=false
    - 'npm install'
    - 'composer install'
    - 'php artisan migrate --force'
    - 'npm run production'
    - 'php artisan route:cache'
    - 'php artisan view:cache'

## How to start application
- in project root directory open cmd and run command 'php artisan serve'

## Installation using Docker
1. copy values from 'docker.env' into '.env'
2. 'docker.env' is located in '.env configs' folder
3. '.env' is located in project root directory
4. in project root directory open cmd and run command 'bash ./vendor/bin/sail up'

## Optional Requirements
- [eye3D](https://eyed3.readthedocs.io/en/latest/installation.html) (Python >= 3.9)

## Optional Installation
1. find python install folder location, open Scripts folder, open cmd and run command 'pip install eyeD3'
2. in Mp3FilesController at line-101 change 'updateMp3MetaData' to 'updateMp3MetaDataWithPythonEyeD3'
