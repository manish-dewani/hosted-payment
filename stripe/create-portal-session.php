<?php

require_once 'stripe_autoload.php';

// This is your real test secret API key.
\Stripe\Stripe::setApiKey($_ENV['API_KEY']);

header('Content-Type: application/json');

$YOUR_DOMAIN = $_ENV['RETURN_URL'];

// Disable SSL certificate verification for developement purpose only remove below on line code if its in production
\Stripe\Stripe::setVerifySslCerts(false);

try {
  $checkout_session = \Stripe\Checkout\Session::retrieve($_POST['session_id']);
  $return_url = $YOUR_DOMAIN;

  // Authenticate your user.
  $session = \Stripe\BillingPortal\Session::create([
    'customer' => $checkout_session->customer,
    'return_url' => $return_url,
  ]);
  header("HTTP/1.1 303 See Other");
  header("Location: " . $session->url);
} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}