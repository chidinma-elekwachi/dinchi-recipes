<?php
// === Environment Configuration ===
// Rename this file to env.local.php in production and keep it outside version control if possible.

return [
  // App
  'APP_URL' => getenv('APP_URL') ?: 'http://localhost/dinchi-recipes',

  // MongoDB (Atlas or local) — Example URI; replace with your own
  'MONGO_URI' => getenv('MONGO_URI') ?: 'mongodb://localhost:27017',
  'MONGO_DB'  => getenv('MONGO_DB') ?: 'dinchi_recipes',

  // MarasoftPay 
  'MSFT_PUBLIC_KEY' => getenv('MSFT_PUBLIC_KEY') ?: 'MSFT_live_S4X0Q0AQOVGR0AAX3I55BKLOUFZM6R0',
  'MSFT_REQUEST_TYPE' => getenv('MSFT_REQUEST_TYPE') ?: 'live', // 'test' or 'live'

  // Email (PHP mail() by default; optionally configure SMTP headers or integrate PHPMailer)
  'MAIL_FROM' => getenv('MAIL_FROM') ?: 'support@dinchi.com',
  'ADMIN_EMAIL' => getenv('ADMIN_EMAIL') ?: 'elexisbiz@gmail.com',
];