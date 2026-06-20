# Render Deployment Guide

This project is a Laravel app with Blade views and Vite assets. Deploy it as one Render Docker Web Service. Do not deploy a separate frontend Static Site for this codebase.

## What is already handled in the repo

1. The Dockerfile builds frontend assets with `npm run build`.
2. The built Vite files are copied to `public/build`.
3. The container starts Laravel with `php artisan serve`.
4. `docker/start.sh` runs `php artisan migrate --force` before the app starts.
5. Missing production tables are now covered by migrations:
   - `admins`
   - `hotels`
   - `apartments`
   - `bookings`

## What you still must do outside the repo

You must do these in Render and your MySQL provider because Codex cannot access your accounts or passwords.

## Step 1: Get a production MySQL database

Use any hosted MySQL database provider, or your existing hosted MySQL database.

You need these values:

```env
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Keep the database public/reachable from Render, or whitelist Render outbound access if your database provider requires IP allowlisting.

## Step 2: Create the Laravel app key

Run this locally:

```bash
php artisan key:generate --show
```

Copy the full value. It starts with `base64:`.

## Step 3: Add Render environment variables

Open Render Dashboard, then your Laravel service, then Environment.

Add these variables:

```env
APP_NAME=Vacation Rental
APP_ENV=production
APP_KEY=base64:paste-your-generated-key-here
APP_DEBUG=false
APP_URL=https://your-render-service.onrender.com

DB_CONNECTION=mysql
DB_HOST=your-mysql-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-user
DB_PASSWORD=your-database-password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_LEVEL=error
```

Never put real passwords into GitHub.

## Step 4: Deploy on Render

Use these Render settings:

```text
Service type: Web Service
Runtime: Docker
Branch: main, or your deployed branch
Dockerfile path: ./Dockerfile
```

Render will run the Dockerfile. During startup, `docker/start.sh` runs migrations and then starts Laravel.

## Step 5: Add existing data

If your local database already has hotels, rooms, bookings, and admins, export it:

```bash
mysqldump -u root -p your_local_database_name > vacation_rental.sql
```

Import it into production MySQL:

```bash
mysql -h your-mysql-host -P 3306 -u your-database-user -p your-database-name < vacation_rental.sql
```

If you import existing tables, include the `migrations` table in the dump when possible. That helps Laravel know which migrations already ran.

## Step 6: Create an admin if needed

If your production database is fresh and you want demo hotels and rooms, open Render Shell for your service and run:

```bash
SEED_DEMO_DATA=true ADMIN_NAME="Admin" ADMIN_EMAIL="admin@example.com" ADMIN_PASSWORD="change-this-password" php artisan db:seed --force
```

This creates sample hotels, rooms, and an admin account.

If you only need to create an admin user, open Render Shell for your service and run:

```bash
php artisan tinker --execute="App\Models\Admin\Admin::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('change-this-password')]);"
```

Then log in at:

```text
https://your-render-service.onrender.com/admin/login
```

After login, create hotels and rooms from the admin panel.

## Step 7: Verify the frontend and data

Open:

```text
https://your-render-service.onrender.com/
```

Check:

1. Homepage loads without a Vite manifest error.
2. Hotels appear.
3. Rooms appear.
4. Register/login works.
5. Booking creates a row in `bookings`.
6. Admin dashboard counts hotels and rooms.

## Important upload warning

The admin panel uploads images into `public/assets/images`. On Render, files written at runtime can disappear after redeploys unless you use persistent storage.

For a final production app, use one of these:

1. Cloudinary or S3 for uploaded images.
2. A Render persistent disk and update the upload path.
3. Commit demo images directly into `public/assets/images`.

For a placement/demo project, the simplest path is to commit demo hotel/room images and avoid relying on runtime uploads.

## Common errors

### Vite manifest not found

Render did not build frontend assets. Confirm the service uses Docker and the Dockerfile includes:

```dockerfile
RUN npm run build
COPY --from=frontend /app/public/build /var/www/public/build
```

### SQLSTATE connection refused

Laravel cannot reach MySQL. Recheck `DB_HOST`, `DB_PORT`, username/password, and database firewall/allowlist.

### Base table not found

Run this in Render Shell:

```bash
php artisan migrate --force
```

### Page loads but no hotels or rooms

Your database is connected, but the `hotels` or `apartments` tables are empty. Import your local data or create hotels and rooms in the admin panel.
