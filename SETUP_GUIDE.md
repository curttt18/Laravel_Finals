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

---

## STEP 4: Create the Database

1. Open your browser
2. Go to: **http://localhost/phpmyadmin**
3. Click **"New"** on the left sidebar
4. Type the database name: `db_enrollment`
5. Click **"Create"**

---

## STEP 5: Import the Database File

**Your groupmate should have sent you a file called `db_enrollment.sql`**

1. In phpMyAdmin, click **`db_enrollment`** on the left sidebar
2. Click the **Import** tab at the top
3. Click **Choose File**
4. Select the `.sql` file your groupmate sent
5. Scroll down and click **Go**
6. Wait for "Import has been successfully finished" ✅

---

## STEP 6: Open the Project in VS Code

1. Open **VS Code**
2. Click **File** → **Open Folder**
3. Navigate to the extracted project folder
4. Open the **`db_enrollment`** folder (the one inside Laravel_Finals)

---

## STEP 7: Create the .env File

1. In VS Code, find the file named **`.env.example`**
2. **Right-click** on it → **Copy**
3. **Right-click** in the same folder → **Paste**
4. **Rename** the copied file to just **`.env`**

---

## STEP 8: Edit the .env File

1. Open the **`.env`** file
2. Find these lines and make sure they look like this:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_enrollment
DB_USERNAME=root
DB_PASSWORD=
```

3. **Save the file** (Ctrl + S)

---

## STEP 9: Open Terminal in VS Code

1. Click **Terminal** in the top menu
2. Click **New Terminal**

---

## STEP 10: Install PHP Packages

Type and press Enter:

```bash
composer install
```

⏳ Wait for it to finish (2-5 minutes)

---

## STEP 11: Generate App Key

Type and press Enter:

```bash
php artisan key:generate
```

---

## STEP 12: Install Frontend Packages

Type and press Enter:

```bash
npm install
```

---

## STEP 13: Run the Project!

Type and press Enter:

```bash
php artisan serve
```

---

## STEP 14: Open in Browser

1. Open your browser
2. Go to: **http://127.0.0.1:8000**
3. 🎉 The website should load with all the data!

---

# ❓ Troubleshooting

| Problem | Solution |
|---------|----------|
| XAMPP MySQL won't start | Open Task Manager, end "mysqld" process, restart XAMPP |
| "Composer is not recognized" | Restart computer after installing Composer |
| "php is not recognized" | Add PHP to PATH or use `C:\xampp\php\php.exe` |
| Import fails in phpMyAdmin | Make sure you selected the `enrollment` database first |
| "Could not find driver" | Edit `C:\xampp\php\php.ini`, remove `;` before `extension=pdo_mysql` |

---

# 📱 Quick Commands

| What You Want | Command |
|---------------|---------|
| Start the server | `php artisan serve` |
| Stop the server | Press `Ctrl + C` |

---

## Need Help?

Contact your groupmate who set up the project! 📞
