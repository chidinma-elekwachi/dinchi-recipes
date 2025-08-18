<?php
require_once __DIR__ . '/Database.php';

class Auth {
  public static function start() { if(session_status()!==PHP_SESSION_ACTIVE) session_start(); }

  public static function register($full_name, $email, $username, $password) {
    $existing = DB::findOne('users', ['$or'=>[['email'=>$email], ['username'=>$username]]]);
    if ($existing) return [false, 'User already exists'];
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $user = DB::insert('users', [
      'full_name'=>$full_name,
      'email'=>$email,
      'username'=>$username,
      'password'=>$hash,
      'created_at'=>date('c')
    ]);
    return [true, $user];
  }

  public static function login($username, $password) {
    $user = DB::findOne('users', ['username'=>$username]);
    if(!$user || !password_verify($password, $user['password'])) return [false, 'Invalid credentials'];
    self::start();
    $_SESSION['user'] = ['id'=>$user['_id']['$oid'] ?? null, 'username'=>$user['username'], 'email'=>$user['email'], 'full_name'=>$user['full_name']];
    return [true, $user];
  }

  public static function user() {
    self::start();
    return $_SESSION['user'] ?? null;
  }

  public static function logout() {
    self::start();
    session_destroy();
  }
}