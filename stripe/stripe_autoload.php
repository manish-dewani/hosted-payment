<?php
require 'vendor/autoload.php';

// This is to fetch stripe configurations it will be inside $_ENV variable
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

