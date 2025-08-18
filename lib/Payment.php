<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/Database.php';

class Payment {
  public static function initiateCheckout($orderId, $name, $email, $phone, $amountKobo, $redirectUrl, $webhookUrl=null) {
    $payload = [
      'public_key' => env('MSFT_PUBLIC_KEY'),
      'request_type' => env('MSFT_REQUEST_TYPE'), // 'live' or 'test'
      'merchant_tx_ref' => $orderId,
      'redirect_url' => $redirectUrl,
      'name' => $name,
      'email_address' => $email,
      'phone_number' => $phone,
      'amount' => (string)$amountKobo,
      'currency' => 'NGN',
      'user_bear_charge' => 'no',
      'description' => 'Recipe purchase #' . $orderId,
    ];
    if ($webhookUrl) $payload['webhook_url'] = $webhookUrl;

    $ch = curl_init('https://checkout.marasoftpay.live/initiate_transaction');
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $payload,
      CURLOPT_TIMEOUT => 30,
    ]);
    $resp = curl_exec($ch);
    if ($resp === false) {
      return [false, curl_error($ch)];
    }
    curl_close($ch);
    $data = json_decode($resp, true);
    if (isset($data['url'])) {
      return [true, $data['url']];
    }
    return [false, 'Invalid response: ' . $resp];
  }
}