<?php
require_once __DIR__ . '/Database.php';
class Cart {
  public static function start() { if(session_status()!==PHP_SESSION_ACTIVE) session_start(); }
  public static function items() { self::start(); return $_SESSION['cart'] ?? []; }
  public static function add($sku, $qty=1) {
    self::start();
    if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
    $_SESSION['cart'][$sku] = ($_SESSION['cart'][$sku] ?? 0) + $qty;
    return $_SESSION['cart'];
  }
  public static function remove($sku) { self::start(); if(isset($_SESSION['cart'][$sku])) unset($_SESSION['cart'][$sku']); }
  public static function clear(){ self::start(); $_SESSION['cart']=[]; }
}