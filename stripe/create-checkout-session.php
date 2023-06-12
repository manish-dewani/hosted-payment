<?php

require_once 'stripe_autoload.php';

// This is to fetch stripe configurations it will be inside $_ENV variable
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// This is your test secret API key.
\Stripe\Stripe::setApiKey($_ENV['API_KEY']);

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost/stripe';

// Disable SSL certificate verification for developement purpose only remove below on line code if its in production
\Stripe\Stripe::setVerifySslCerts(false);

(empty($_POST['lookup_key'])) ? $_POST['lookup_key'] = $_ENV['LOOKUP_KEY'] : $_POST['lookup_key'];

try {

  $prices = \Stripe\Price::all([
    // retrieve lookup_key from form data POST body
    'lookup_keys' => [],
    'expand' => ['data.product']
  ]);

  $checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => [[
      'price' => $prices->data[0]->id,
      'quantity' => 1,
    ]],
    'mode' => 'subscription',
    'success_url' => $YOUR_DOMAIN . '/success.html?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
  ]);

  header("HTTP/1.1 303 See Other");
  header("Location: " . $checkout_session->url);
} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}