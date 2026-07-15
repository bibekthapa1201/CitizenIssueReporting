
<?php

$dotenv = parse_ini_file(__DIR__ . '/../.env');

$host = $dotenv['HOST'];
$user = $dotenv['USERNAME'];
$password = $dotenv['PASSWORD'];
$database  = $dotenv['DATABASE'];
// $port = $_ENV['DB_PORT'];

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>