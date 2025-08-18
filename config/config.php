<?php
// Loads env and exposes helpers
$ENV = include __DIR__ . '/env.php';

function env($key, $default = null) {
  global $ENV;
  return $ENV[$key] ?? $default;
}