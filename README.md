## Project Name
TaskMe is an web application that can save all your task. 
You can customize your task by how urgency it is, due date of the task, and even add files.

## Installation
Clone the project repository

```bash
  git clone https://github.com/ChronoIII/Task-Me-Laravel
```

## Install XAMPP
Install XAMPP with PHP version 7.4

- **[XAMPP (Windows)](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.33/)**

## Install SSL Certificate
Follow [this guide](https://shellcreeper.com/how-to-create-valid-ssl-in-localhost-for-xampp/) on how to create SSL Certificate

For the vhost configuration, you can copy the configuration below. 
```
<VirtualHost *:80>
    DocumentRoot "C:\{path-to-project}\public"
    ServerName task-me.local
    Redirect permanent / "https://task-me.local"
</VirtualHost>

<VirtualHost *:443>
	ServerName          task-me.local
	ServerAlias         task-me.local
	DocumentRoot        "C:\{path-to-project}\public"
	SSLEngine on
	SSLCertificateFile "C:\xampp\apache\conf\ssl.crt\server.crt"
	SSLCertificateKeyFile "C:\xampp\apache\conf\ssl.key\server.key"

    <Directory "C:\{path-to-project}">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Install NodeJS
NodeJS is necessary for running npm.
You can download it [here](https://nodejs.org/en).

Download the LTS version and install.

## Install Composer
Composer is tool for dependency management in PHP.
It is necessary to install/update Laravel libraries.
You can download it [here](https://getcomposer.org/download/).

## Install Dependencies
Run this commands under the project terminal
```
composer install
npm install
npm run dev
```

## Environment Variables
Copy the .env.example file
```
cp .env.example .env
```

## Generate Secret App Key
Run key:generate under project directory terminal to generate encrypted key
```
php artisan key:generate
```

## Create Database
First, access the phpMyAdmin page
- http://localhost/phpmyadmin/

On the left sidebar, 
- Click New 
- Type "laravel" as Database name.
- Click on Create button

## Migrate Database tables
Run this commands under the project terminal
```
php artisan migrate
```

## Access webpage
Site can now be access on:
- https://task-me.local
