# 🚀 SUPER SIMPLE SETUP GUIDE

**READ THIS CAREFULLY. FOLLOW EVERY STEP. DO NOT SKIP ANYTHING.**

---

## 🛠️ STEP 1: INSTALL THESE FIRST
Make sure you have these installed on your computer. If not, download and install them now:
1. **XAMPP** - [Download](https://www.apachefriends.org/)
2. **Composer** - [Download](https://getcomposer.org/)
3. **Node.js** - [Download](https://nodejs.org/)
4. **VS Code** - [Download](https://code.visualstudio.com/)

---

## 📂 STEP 2: OPEN THE PROJECT PROPERLY
1. **Download** the project folder to your Desktop.
2. Open **VS Code**.
3. Click the **File** menu (top left) → Click **Open Folder**.
4. Select the main folder **`Laravel_Finals`**.
   - *Important:* Do not just open a single file. Open the whole folder.

---

## 🗄️ STEP 3: SETUP THE DATABASE
1. Open **XAMPP Control Panel**.
2. Click **Start** next to **Apache**.
3. Click **Start** next to **MySQL**.
4. Open your browser (Chrome/Edge) and go to: `http://localhost/phpmyadmin`
5. Click **New** on the left sidebar.
6. In the box "Database name", type: `db_enrollment`
7. Click **Create**.

**IMPORT DATA:**
1. Click **`db_enrollment`** on the left sidebar to select it.
2. Click the **Import** tab at the top.
3. Click **Choose File**.
4. Select the **`db_enrollment.sql`** file (Ask your groupmate for this file!).
5. Click **Go** at the very bottom.
6. You should see a green success message.

---

## 🔑 STEP 4: CREATE THE .ENV FILE (CRITICAL!)
The project is missing a file called `.env`. You must create it manually.

1. In VS Code, look at the left sidebar files.
2. Open the **`enrollment`** folder.
3. **Right-click** inside the `enrollment` folder → Click **New File**.
4. Name the file: `.env` (Start with a dot!).
5. **Copy ALL the code below** and paste it into your new `.env` file:

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

6. **IMPORTANT:** Ask your groupmate for their **APP_KEY**.
   - Paste it right after `APP_KEY=` in line 3.
   - Example: `APP_KEY=base64:sOmERandOmString...`
7. Save the file (**Ctrl + S**).

---

## � STEP 5: INSTALL PACKAGES (DO NOT SKIP THIS)
1. In VS Code, click **Terminal** (top menu) → **New Terminal**.
2. **TYPE THIS COMMAND FIRST AND PRESS ENTER:**
   ```bash
   cd enrollment
   ```
   *(You must see `enrollment` in your terminal path before continuing!)*

3. Now run this command to install backend tools:
   ```bash
   composer install
   ```

4. Now run this command to install frontend tools:
   ```bash
   npm install
   ```

---

## 🚀 STEP 6: START THE WEBSITE
1. In the same terminal (make sure you are still in `enrollment` folder), run:
   ```bash
   php artisan config:clear
   ```
   
2. Then run:
   ```bash
   php artisan serve
   ```

3. Open your browser and go to: `http://127.0.0.1:8000`

---

## ❓ COMMON PROBLEMS

**"Invalid Credentials" error?**
- You have the wrong `APP_KEY` in your `.env` file. Ask your groupmate for theirs again.

**"Directory not found" or "Could not open input file artisan"?**
- You forgot to run `cd enrollment` in Step 5.

**"Table does not exist"?**
- You missed Step 3 (Importing the database).

---
