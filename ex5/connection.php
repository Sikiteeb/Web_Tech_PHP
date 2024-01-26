<?php
function getConnection(): PDO {
    $host = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];

    $address = sprintf('mysql:host=%s;port=3306;dbname=%s', $host, $username);

    return new PDO($address, $username, $password);
}


