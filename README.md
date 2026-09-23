## ESTABLISH THE LARAVEL PROJECT AND MAP ITS DEVOPS WORKFLOW
## Project Description

This project is a Laravel-based web application developed as part of Laboratory 1. It demonstrates the basic setup of a Laravel project, MySQL database integration, Git version control, and GitHub repository management. The project also serves as a practical introduction to establishing a simple DevOps workflow for web application development.

John Lloyd E. Escultura
BSIT 4-3

## Software Requirements

* **PHP** 8.2 or later
* **Composer** – PHP dependency manager
* **Laravel** – Web application framework
* **MySQL** – Database management system
* **phpMyAdmin** – Database administration tool
* **Git** – Version control system
* **GitHub** – Remote repository hosting
* **Node.js and npm** – For Laravel frontend asset management
* **Web Browser** – Google Chrome, Microsoft Edge, or Mozilla Firefox
* **Visual Studio Code** – Recommended code editor

## Laravel Installation Instructions

1. Install PHP, Composer, MySQL, Git, and Node.js/npm on the computer.
2. Create a new Laravel project using Composer:

   ```bash
   composer create-project laravel/laravel laravel-request-system
   ```
3. Navigate to the project directory:

   ```bash
   cd laravel-request-system
   ```
4. Copy `.env.example` to `.env`:

   ```bash
   cp .env.example .env
   ```

   On Windows:

   ```cmd
   copy .env.example .env
   ```
5. Generate the Laravel application key:

   ```bash
   php artisan key:generate
   ```
6. Create a MySQL database named:

   ```text
   laravel_request_system_db
   ```
7. Configure the database settings in the `.env` file:

   ```env
   DB_DATABASE=laravel_request_system_db
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```
8. Run the database migrations:

   ```bash
   php artisan migrate
   ```
9. Start the Laravel development server:

   ```bash
   php artisan serve
   ```
10. Open the application in a web browser:

```text
http://127.0.0.1:8000
```
laravel_request_system_db
## Database Import Instructions

1. Start **MySQL** using XAMPP.
2. Open **phpMyAdmin** at `http://localhost/phpmyadmin`.
3. Create a database named:

   ```text
   laravel_request_system_db
   ```
4. Select the `laravel_request_system_db` database.
5. Click the **Import** tab.
6. Select the provided `.sql` database file.
7. Make sure the format is set to **SQL**.
8. Click **Import** to restore the database.
9. Verify that the database tables were successfully created.
10. Configure the Laravel `.env` file with the correct database connection settings.
11. Run the application using:

```bash
php artisan serve
```

## Commands Needed to Run the Project


```bash
cd DevOps
```

Install the PHP dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

For Windows:

```cmd
copy .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Configure the MySQL database in the `.env` file, then run the migrations:

```bash
php artisan migrate
```

Start the Laravel development server:

```bash
php artisan serve
```

Open the application in a web browser:

```text
http://127.0.0.1:8000
```



## Github Repository link

https://github.com/JL1502/DevOps.git
