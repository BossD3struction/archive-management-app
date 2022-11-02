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
- Python >= 3.9 
    - (required [eye3D](https://eyed3.readthedocs.io/en/latest/installation.html))
- npm/Node.js
- Composer

## Installation
1. find python install folder location, open Scripts folder, open cmd and run command 'pip install eyeD3'
2. create database named 'laravel_bachelor_project'
3. in project root directory open cmd and run commands
    - 'npm install'
    - 'composer install'
    - 'npm run dev'
    - 'php artisan migrate'    
    - 'php artisan serve'
