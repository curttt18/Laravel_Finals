# 🚀 Ultimate Setup Guide for Groupmates

Follow these steps **exactly** in order. Don't skip any step!

---

## 🛠️ STEP 1: Prerequisites
Make sure you have these installed:
- ✅ **XAMPP** (for MySQL database) - [Download here](https://www.apachefriends.org/)
- ✅ **Composer** (for PHP packages) - [Download here](https://getcomposer.org/)
- ✅ **Node.js** (for frontend) - [Download here](https://nodejs.org/)
- ✅ **VS Code** (code editor) - [Download here](https://code.visualstudio.com/)

---

## 📂 STEP 2: Get the Project
1. **Download/Clone** the project repository to your Desktop.
2. **Extract** the folder if it's a ZIP file.
3. Open **VS Code**.
4. Click **File** → **Open Folder** → Select the `enrollment` folder (inside Laravel_Finals).

---

## 🗄️ STEP 3: Database Setup
1. Open **XAMPP Control Panel** and Start **Apache** and **MySQL**.
2. Go to **http://localhost/phpmyadmin** in your browser.
3. Click **"New"** on the left sidebar.
4. Database name: `db_enrollment`
5. Click **"Create"**.

### Import the Database
1. Ask your groupmate for the **`db_enrollment.sql`** file.
2. Click **`db_enrollment`** on the left sidebar.
3. Click the **Import** tab at the top.
4. Click **Choose File** → Select the `.sql` file.
5. Click **Go** at the bottom.
6. Wait for the green success message. ✅

---

## 🔑 STEP 4: Environment Setup (CRITICAL STEP)
**Since `.env.example` might be missing, do this manually:**

1. In VS Code, inside the `enrollment` folder:
2. **Right-click** on the sidebar → **New File**
3. Name it **`.env`** (starts with a dot).
4. **Copy and Paste** the following code into it:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_enrollment
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

5. **Now, update the `APP_KEY` line:**
   - Ask your groupmate (the one who gave you the database) for THEIR `APP_KEY`.
   - It looks like: `base64:sOmERandomStr1ngOsMkl...`
   - Paste it after `APP_KEY=` in your new `.env` file.
   - **Example:** `APP_KEY=base64:YourUniqueKeyHere...`

6. Save the file (Ctrl+S).

---

## 📦 STEP 5: Install Dependencies
Open the **Terminal** in VS Code (Ctrl + `) and run these commands one by one:

1. Install PHP packages:
```bash
composer install
```

2. Install Frontend packages:
```bash
npm install
```

---

## 🚀 STEP 6: Run the Project
1. Clear any old configurations:
```bash
php artisan config:clear
php artisan cache:clear
```

2. Start the server:
```bash
php artisan serve
```

3. Open your browser and go to: **http://127.0.0.1:8000**

---

## ❓ Troubleshooting

### "Invalid Credentials" when logging in
- **Cause:** Your `APP_KEY` in `.env` is different from the one used to encrypt the passwords in the database.
- **Fix:** Get the `APP_KEY` from the groupmate who gave you the SQL file and paste it into your `.env`. Then run `php artisan config:clear`.

### "Table 'db_enrollment.users' doesn't exist"
- **Cause:** You didn't import the database or named it wrong.
- **Fix:** Go back to **Step 3**, check the database name is exactly `db_enrollment`, and import the SQL file again.

### "Vite manifest not found"
- **Cause:** Frontend assets aren't built.
- **Fix:** Run `npm run build` in a new terminal window.

---

## 📱 Quick Commands
| Goal | Command |
|------|---------|
| Start Server | `php artisan serve` |
| Stop Server | `Ctrl + C` |
| Clear Cache | `php artisan optimize:clear` |
