# DinChi Recipes — PHP + MongoDB + MarasoftPay (Standard Checkout)

A minimal e‑commerce portal selling recipe PDFs. Users can register, login, add items to cart, pay via **MarasoftPay Standard Checkout**, and receive a secure download link by email after payment (via webhook).

## Features
- User Registration & Login (vanilla PHP)
- Catalogue (HTML/CSS, Vanilla JS)
- Cart & Checkout
- MarasoftPay **Standard** checkout integration (server → `initiate_transaction` → redirect)
- Webhook handler that marks orders as **paid** and emails one‑time download link (24h expiry)
- Secure **download.php** validates token before streaming the PDF

## Quick Start (Local)
1. **Requirements**
   - PHP 8+ with `mongodb` extension enabled
   - MongoDB (local) or **MongoDB Atlas** connection string
   - An SMTP-capable environment if `mail()` is not supported (or swap in PHPMailer)

2. **Configure env**
   - Copy `config/env.php` and adjust:
     ```php
     'APP_URL' => 'http://localhost',   // change when hosted
     'MONGO_URI' => 'mongodb://localhost:27017',
     'MONGO_DB'  => 'recipe_store',
     'MSFT_PUBLIC_KEY' => 'MSFT_live_S4X0Q0AQOVGR0AAX3I55BKLOUFZM6R0',
     'MSFT_REQUEST_TYPE' => 'live', // or 'test'
     'MAIL_FROM' => 'no-reply@yourdomain.com',
     'ADMIN_EMAIL' => 'you@yourdomain.com',
     ```

3. **Serve**
   - Point your web server document root to `/public`.
   - Visit `/catalogue.php`, add items, go to `/view-cart.php`, then **Checkout**.

4. **Payment Flow**
   - `public/checkout.php` creates an order in MongoDB and calls
     `https://checkout.marasoftpay.live/initiate_transaction`.
   - The API returns `{ url: "https://checkout.marasoftpay.com/pay?id=..." }` and the user is redirected.
   - After payment, MarasoftPay redirects back to `success.php` (and sends a **webhook** to `webhook.php`).

5. **Webhooks**
   - Configure your MarasoftPay dashboard to POST events to:
     `https://YOUR_DOMAIN/webhook.php`
   - The handler sets `status=paid`, generates `download_token`, and emails the buyer & admin.

6. **Emailing**
   - For production, replace `lib/Mailer.php` with PHPMailer + SMTP or a transactional provider.

## Endpoints
- `/index.php` — Home
- `/catalogue.php` — Products
- `/cart.php` — Cart API (add/clear)
- `/view-cart.php` — View cart
- `/checkout.php` — Start checkout (POST)
- `/success.php` — Post‑payment landing
- `/webhook.php` — Payment notification
- `/download.php?token=...` — Secure download

## Notes
- Prices are in NGN; amount sent to MarasoftPay is in **kobo** (`price * 100`).
- The sample PDFs are small placeholder files for demo; replace with real PDFs in `public/products/`.
- If your host does not support `mongodb` extension, switch to MySQL quickly by replacing `lib/Database.php` logic.