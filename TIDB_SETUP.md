# ☁️ TiDB Cloud Database Setup Guide

Using an online database like TiDB solves the issue of sharing data (accounts, payments, enrollments) with your groupmates.

---

## 🚀 Step 1: Create a Free TiDB Account
1. Go to **[TiDB Cloud](https://tidbcloud.com/)** and sign up (Free Tier is generous).
2. Create a new **Serverless Tier** cluster (it's free).
3. Give it a name (e.g., `enrollment-db`).
4. Create a **Root Password** (SAVE THIS! You cannot see it again).

## 🔗 Step 2: Get Connection Details
1. Once your cluster is ready, click **Connect**.
2. Select **Connect with SQL Client** or look for specific parameters.
3. You need these 4 things:
   - **Host:** (e.g., `gateway01.us-west-2.prod.aws.tidbcloud.com`)
   - **Port:** `4000`
   - **User:** (e.g., `2a3b4c5d.root`)
   - **Password:** (The one you created)

## ⚙️ Step 3: Update Your `.env` File
Share these exact details with ALL your groupmates. everyone must have the exact same `.env` settings for DB.

**In your VS Code `.env` file:**
```env
DB_CONNECTION=mysql
DB_HOST=gateway01.us-west-2.prod.aws.tidbcloud.com  <-- Replace with YOUR TiDB Host
DB_PORT=4000
DB_DATABASE=test                                     <-- TiDB default is usually 'test', or create 'db_enrollment'
DB_USERNAME=2a3b4c5d.root                            <-- Replace with YOUR TiDB User
DB_PASSWORD=your_secure_password                     <-- Replace with YOUR Password
DB_SSL_CA=                                           <-- Leave empty for now, TiDB handles SSL automatically usually
```

## 🛡️ Step 4: Safety & Billing Limits (Crucial!)
To prevent getting a bill or hitting limits:

### 1. In TiDB Console:
- Go to **Cluster Settings** or **Spending Limit**.
- Set **Monthly Spending Limit** to **$0**.
- This ensures the database strictly pauses if you exceed the free tier (Request Units).

### 2. In Laravel (Already Done ✅):
I have added a **Rate Limiter** to your application code.
- **Limit:** 60 requests per minute per user.
- **Why:** If someone spams your site, they execute database queries. This limiter stops them before they hit the database too hard.
- **File:** `app/Providers/AppServiceProvider.php`

## 🔄 Step 5: Push Your Data
Once connected, **ONE PERSON** needs to push the local tables to the cloud:
```bash
php artisan migrate:fresh --seed
```
*Only do this once! Everyone else simply connects and uses the data.* 
