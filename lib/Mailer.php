<?php
require_once __DIR__ . '/../config/config.php';

class Mailer {
  public static function send($to, $subject, $message) {
    $headers = "From: " . env('MAIL_FROM') . "\r\n" .
               "MIME-Version: 1.0\r\n" .
               "Content-Type: text/html; charset=UTF-8\r\n";
    return mail($to, $subject, $message, $headers);
  }
}