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

## SECURE REQUEST ACCESS THROUGH REVIEWED CHANGES (Laboratory 3)

## Project Description

This laboratory adds authentication, ownership checks, and administrator-only status updates to the request system from Laboratory 2. Access is enforced on the server with a Laravel policy, input is validated on the server, and every change was made on a feature branch and reviewed through a pull request.

## Project Maintainers

* **Driver (implements changes):** [Full Name] (@driver-username)
* **Reviewer (inspects and tests changes):** [Full Name] (@reviewer-username)

Driver and reviewer duties were exchanged during the session. Authors never approve their own pull request.

## File Responsibilities

| Area | Files | Maintainer |
|---|---|---|
| Policy | `app/Policies/ServiceRequestPolicy.php` | @driver-username |
| Controller | `app/Http/Controllers/ServiceRequestController.php` | @driver-username |
| Validation | `app/Http/Requests/StoreServiceRequestRequest.php`, `app/Http/Requests/UpdateServiceRequestStatusRequest.php` | @driver-username |
| Model | `app/Models/ServiceRequest.php` | @driver-username |
| Routes | `routes/web.php` | @driver-username |
| Views | `resources/views/requests/` | @reviewer-username |
| Tests | `tests/Feature/` | @reviewer-username |

Review ownership is also set in `.github/CODEOWNERS`.

## Review Settings

* Branch protection and required pull-request reviews: [enabled / not available on this plan].
* If these are unavailable, merging requires recorded peer approval on the pull request from the other maintainer. Accounts and access tokens are never shared.

## Ownership Rules

* Guests are redirected to login and see no request data.
* A student lists and opens only their own requests. Ownership is decided by `user_id`, never by `requester_name` or `requester_email`.
* An administrator can list and view all requests.
* Any authenticated student can create a request.
* Only an administrator can update a request's status.
* Students cannot set `user_id`, `status`, `is_admin`, or `role`. The server sets `user_id`, `requester_name`, and `requester_email` from the signed-in account, and sets the initial status to `pending`.

## Authorization Response

Authorization is enforced on the server with `ServiceRequestPolicy` through `Gate::authorize()` before any protected data is returned or any row is written. Blade `@can` directives only control button visibility.

When a student opens another student's record, or sends a status update they are not allowed to make, the application returns **403 Forbidden**. This was chosen because Laravel's policy system returns it natively, so the response is consistent on every protected route without custom exception handling. The denial response contains no details of the record.

## Route Summary

| Method | URL | Action | Access |
|---|---|---|---|
| GET | `/requests` | List requests | Signed-in users (students see only their own) |
| GET | `/requests/create` | Show the create form | Students |
| POST | `/requests` | Create a request | Students |
| GET | `/requests/{id}` | View one request | Owner or administrator |
| PATCH | `/requests/{id}/status` | Update status | Administrator only |

All routes above are protected by `auth` middleware. Login and registration routes remain available to guests.

## Setup and Migration Steps

1. Complete the Laboratory 1 setup and Laboratory 2 data-model steps above.
2. Authentication scaffolding was added with Laravel Breeze (login, registration, and password hashing):

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
```

3. Switch to the feature branch:

```bash
git switch feature/lab3-secure-requests
```

4. Run the migrations. Laboratory 3 adds `user_id` to `requests` and `is_admin` to `users`:

```bash
php artisan migrate
php artisan migrate:status
```

5. Create fictional accounts (two students and one administrator) with hashed passwords, for example through `php artisan tinker` or a seeder. The administrator flag is set only through trusted setup, never through a form. Do not commit passwords.
6. Link the Laboratory 2 sample requests to the student accounts through `user_id` without deleting any rows.
7. Start the application:

```bash
php artisan serve
```

## Testing Steps

Use separate browser sessions, or log out between accounts. Run all tests on the local test project.

1. **T01:** While logged out, open `/requests` and `/requests/{id}`. Expect a login redirect and no request data.
2. **T02:** Log in as Student A, then Student B. Each sees only their own requests and can open them.
3. **T03:** Each student opens the other student's record ID directly. Expect 403 and no details.
4. **T04:** Each student sends a status PATCH with a valid session and CSRF token. Expect 403 and an unchanged database status.
5. **T05:** The administrator lists all requests, opens one, and updates its status. Expect the change to be saved.
6. **T06:** Submit quantity `0`, `-1`, a non-integer, or a blank item name. Expect rejection and no new row.
7. **T07:** Submit `user_id`, `status`, `is_admin`, or `role` as a student. Expect rejection with no spoofed values saved.
8. **T08:** Submit text containing `<b>LAB3</b>` and an apostrophe. Expect the markup shown literally and the apostrophe stored safely.
9. **T09:** Send a write with a missing or invalid CSRF token through the live browser or an HTTP request. Expect 419 and an unchanged database. (Automated feature tests normally disable CSRF middleware, so this test is run live.)
10. **T10:** As administrator, submit an invalid status. Expect rejection and an unchanged status.

Verify each denied write by comparing the database values before and after the attempt.

## Security Notes

* Passwords are hashed with Laravel's `Hash` facade.
* `.env` is excluded through `.gitignore`, and `.env.example` contains no real credentials.
* `APP_DEBUG` is `false` in shared or deployed environments, so errors do not reveal SQL details or secrets.
* Queries use Eloquent with an explicit allowlist of validated input. `$request->all()` is not used for inserts or updates.
* Output is escaped with Blade `{{ }}`, and `@csrf` is present on every POST and PATCH form.

## Dependency Audit

* **`composer audit`:** No security vulnerability advisories found.
* **`npm audit`:** [N] vulnerabilities reported ([x] moderate, [y] high), including `braces` (high, denial of service through deeply nested patterns) and `postcss-selector-parser` (moderate, CPU exhaustion). All findings trace back to `tailwindcss` and its build-time dependencies.
* **`npm audit --omit=dev`:** [record the actual result].
* The suggested `npm audit fix --force` would install `tailwindcss@4.3.3`, a breaking change, so it was **not** applied.
* **Follow-up:** plan a reviewed Tailwind CSS upgrade in a separate pull request, then rerun `npm audit`, rebuild the assets, and retest the pages. No packages were upgraded without review.

## Exposed Secret Response

If a secret such as a database password or API key is ever committed, it must first be revoked or rotated so the old value is useless. It must then be removed from the repository, and its history must be addressed (for example with `git filter-repo` or BFG Repo-Cleaner, followed by a force push and a fresh clone for collaborators). Deleting the file in a later commit is not enough, because the secret remains in Git history.

## Repository Notes

* The `.env` file is excluded from version control and must never be committed.
* No database export (`.sql`) files are included in this repository.
* Sample data used for testing is documented in the lab reports, not committed to the repository.
