# 🚀 Setup Guide for Groupmates

Follow these steps **exactly** in order. Don't skip any step!

---

## STEP 1: Download the Project from GitHub

1. Open your browser
2. Go to the GitHub repository link (ask your groupmate for the link)
3. Click the green **"Code"** button
4. Click **"Download ZIP"**
5. Extract/Unzip the folder to your Desktop

**OR** if you know Git:
```bash
git clone <repository-url>
```

---

## STEP 2: Install Required Software

Make sure you have these installed:

- ✅ **XAMPP** (for MySQL database) - [Download here](https://www.apachefriends.org/)
- ✅ **Composer** (for PHP packages) - [Download here](https://getcomposer.org/)
- ✅ **Node.js** (for frontend) - [Download here](https://nodejs.org/)
- ✅ **VS Code** (code editor) - [Download here](https://code.visualstudio.com/)

---

## STEP 3: Start XAMPP

1. Open **XAMPP Control Panel**
2. Click **Start** next to **Apache**
3. Click **Start** next to **MySQL**
4. Both should turn **GREEN** ✅

![XAMPP should look like this - Apache and MySQL are green]

---

## STEP 4: Create the Database

1. Open your browser
2. Go to: **http://localhost/phpmyadmin**
3. Click **"New"** on the left sidebar
4. Type the database name: `enrollment`
5. Click **"Create"**

**IMPORTANT:** The database should be empty! Don't add any tables manually.

---

## STEP 5: Open the Project in VS Code

1. Open **VS Code**
2. Click **File** → **Open Folder**
3. Navigate to the extracted project folder
4. Open the **`enrollment`** folder (the one inside Laravel_Finals)

---

## STEP 6: Create the .env File

1. In VS Code, look at the left sidebar (file explorer)
2. Find the file named **`.env.example`**
3. **Right-click** on it → **Copy**
4. **Right-click** in the same folder → **Paste**
5. **Rename** the copied file to just **`.env`** (remove the .example part)

---

## STEP 7: Edit the .env File

1. Open the **`.env`** file
2. Find these lines and make sure they look like this:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=enrollment
DB_USERNAME=root
DB_PASSWORD=
```

**NOTE:** Leave `DB_PASSWORD=` empty (no password) unless you set one in XAMPP.

3. **Save the file** (Ctrl + S)

---

## STEP 8: Open Terminal in VS Code

1. In VS Code, click **Terminal** in the top menu
2. Click **New Terminal**
3. A terminal window opens at the bottom
4. Make sure you're in the **enrollment** folder (it should show in the terminal path)

---

## STEP 9: Install PHP Packages

Type this command and press **Enter**:

```bash
composer install
```

⏳ **Wait** for it to finish. This may take 2-5 minutes.

---

## STEP 10: Generate App Key

Type this command and press **Enter**:

```bash
php artisan key:generate
```

You should see: `Application key set successfully.`

---

## STEP 11: Create Database Tables

Type this command and press **Enter**:

```bash
php artisan migrate
```

If it asks: `Do you want to create it?` → Type **yes** and press Enter.

You should see a list of tables being created ✅

---

## STEP 12: (Optional) Add Sample Data

If your project has seeders (sample data), run:

```bash
php artisan db:seed
```

---

## STEP 13: Install Frontend Packages

Type this command and press **Enter**:

```bash
npm install
```

⏳ **Wait** for it to finish.

---

## STEP 14: Run the Project!

Type this command and press **Enter**:

```bash
php artisan serve
```

You should see:
```
Starting Laravel development server: http://127.0.0.1:8000
```

---

## STEP 15: Open in Browser

1. Open your browser
2. Go to: **http://127.0.0.1:8000** or **http://localhost:8000**
3. 🎉 The website should load!

---

# ❓ Troubleshooting

### "XAMPP MySQL won't start"
- Close XAMPP
- Open Task Manager (Ctrl + Shift + Esc)
- End any process named "mysqld"
- Restart XAMPP

### "Composer is not recognized"
- Restart your computer after installing Composer
- Make sure you installed Composer globally

### "php is not recognized"
- You need to add PHP to your system PATH
- Or use XAMPP's PHP: `C:\xampp\php\php.exe`

### "Table already exists" error
Run this to reset:
```bash
php artisan migrate:fresh
```
⚠️ WARNING: This deletes all data!

### "Could not find driver" error
1. Open `C:\xampp\php\php.ini`
2. Find `;extension=pdo_mysql`
3. Remove the `;` at the start
4. Restart Apache in XAMPP

---

# 📱 Quick Commands Reference

| What You Want | Command |
|---------------|---------|
| Start the server | `php artisan serve` |
| Create tables | `php artisan migrate` |
| Reset database | `php artisan migrate:fresh` |
| Add sample data | `php artisan db:seed` |
| Stop the server | Press `Ctrl + C` in terminal |

---

## Need Help?

Contact your groupmate who set up the project! 📞
