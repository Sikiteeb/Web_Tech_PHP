<?php
require_once 'socket.php';
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Use environment variables
$host = $_ENV['HOST'];
$secret = $_ENV['SECRET'];
$sessionId = $_ENV['PHPSESSID'];
$username = $_ENV['USERNAME'];
$key = $_ENV['KEY'];

$request = "GET /~makalm/icd0007/foorum/?message=deleted&username=$username&key=$key HTTP/1.1
Host: $host
Content-Type: application/x-www-form-urlencoded
Content-Length: 0
X-Secret: $secret
Cookie: PHPSESSID=$sessionId

";

print makeWebRequest($host, 443, $request);
