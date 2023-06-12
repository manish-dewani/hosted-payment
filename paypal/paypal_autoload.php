<?php

$envVariables = parse_ini_file('.env');

if ($envVariables === false) {
    // Handle error if .env file cannot be parsed
}

foreach ($envVariables as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key] = $value;
}