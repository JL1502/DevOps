## ESTABLISH THE LARAVEL PROJECT AND MAP ITS DEVOPS WORKFLOW
## Project Description

This project is a Laravel-based web application developed as part of Laboratory 1. It demonstrates the basic setup of a Laravel project, MySQL database integration, Git version control, and GitHub repository management. The project also serves as a practical introduction to establishing a simple DevOps workflow for web application development.

John Lloyd E. Escultura, Raydan Tagub
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

## PLAN AND IMPLEMENT THE REQUEST DATA MODEL
 
## Project Description
 
This project is a continuation of Laboratory 1, extending the Laravel request-system project with a data model for handling requests. It introduces a `requests` table, a Laravel migration to create it, and verification steps using MySQL and phpMyAdmin. The project demonstrates how to plan a data model through user stories and a data dictionary before implementing it as a reversible Laravel migration.
 
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
* **Visual Studio Code** – Recommended code editor
## Database Configuration
 
* Database name: `[laravel_request_system_db]`
* The `.env` file contains the local database credentials and is excluded from version control via `.gitignore`. It is never committed or pushed to GitHub.
* Connection can be verified at any time with:
```bash
php artisan migrate:status
```
 
## User Stories
 
**Requester**
 
> As a requester, I want to submit a request with an item name, quantity, and purpose, so that staff can review and approve what I need.
 
* Given valid item name, quantity, and purpose, when the requester submits the form, then a new request is created with status "pending".
* Given a quantity of zero or less, when the requester submits the form, then the system rejects the request and shows a validation error.
**Staff Reviewer**
 
> As a staff reviewer, I want to view all submitted requests with their current status, so that I can decide which ones to approve or reject.
 
* Given at least one request exists, when the reviewer opens the request list, then each request displays its requester name, item name, quantity, and status.
* Given a request with status "pending", when the reviewer changes its status, then the updated status is saved and visible immediately.
**Record Keeper**
 
> As a record keeper, I want every request to store a creation and last-updated timestamp, so that I can track when records were submitted and last changed for auditing.
 
* Given a new request is created, when it is saved, then `created_at` and `updated_at` are automatically recorded.
* Given an existing request is modified, when it is saved again, then `updated_at` changes while `created_at` stays the same.
## Data Dictionary: `requests` Table
 
| Field | Type | Constraint | Purpose |
|---|---|---|---|
| id | bigIncrements | Primary key, auto-increment | Unique request number |
| requester_name | string(100) | Required | Person submitting the request |
| requester_email | string(255) | Required | Contact address |
| item_name | string(150) | Required | Requested item or service |
| quantity | unsignedInteger | Required, must be > 0 | Requested quantity |
| purpose | text | Required | Reason for the request |
| status | string(20) | Default: `pending` | Current request state |
| created_at | timestamp | Auto-set on creation | Creation time |
| updated_at | timestamp | Auto-updated on change | Last update time |
 
## Migration Instructions
 
1. Create the migration file:
```bash
php artisan make:migration create_requests_table
```
 
2. Define the `requests` table inside the migration's `up()` method with all required fields listed above.
3. Define the rollback logic inside the `down()` method using `Schema::dropIfExists('requests')`, so the migration can be safely reversed.
4. Run the migration and confirm it was applied:
```bash
php artisan migrate
php artisan migrate:status
```
 
## Verifying the Table
 
1. Run `php artisan migrate:status` and confirm `create_requests_table` is listed as **Ran**.
2. Open the project database in phpMyAdmin and inspect the `requests` table's **Structure** tab to confirm all nine columns, their types, and the `status` default value match the data dictionary above.
3. Query the table to confirm sample data and the default status behavior:
```sql
SELECT id, requester_name, item_name, quantity, status FROM requests;
```
 
A row inserted without an explicit `status` value should display `pending`, confirming the column's default constraint works as defined in the migration.
 
## Repository Notes
 
* The `.env` file is excluded from version control and must never be committed.
* No database export (`.sql`) files are included in this repository.
* Sample data used for testing is documented in the lab report, not committed to the repository.

## File Responsibilities and Maintainers

| Area | Files | Maintainer |
|---|---|---|
| Policy | `app/Policies/ServiceRequestPolicy.php` | John Lloyd |
| Controller | `app/Http/Controllers/ServiceRequestController.php`, `app/Http/Requests/` | John Lloyd |
| Routes | `routes/web.php` | John Lloyd |
| Views | `resources/views/requests/` | Raydan |
| Tests | `tests/Feature/` | Raydan |

Changes to these areas must be reviewed by a maintainer other than the author. Review ownership is also enforced through `.github/CODEOWNERS`.

## Access Rules
- Guests are redirected to login.
- Students list and view only their own requests (ownership is based on `user_id`).
- Administrators can list and view all requests and are the only users who can update status.
- Unauthorized access to another student's record returns **403 Forbidden**. This was chosen because Laravel's `Gate::authorize` returns it natively and it is applied consistently across all protected routes.
