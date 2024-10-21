<?php

$host = 'd124553.mysql.zonevs.eu';
$db   = 'd124553_bookstore';
$user = 'd124553_book';
$pass = 'mingisugunebook';
$charset = 'utf8mb4';

$host = 'localhost';
$db   = 'd124553_bookstore';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);

$stmt = $pdo->query('SELECT * FROM books');

while ($row = $stmt->fetch())
{
    echo $row['title'] . "<br>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

</body>
</html>