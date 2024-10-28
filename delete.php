<?php

require_once('./connection.php');

$id = $_GET['id'];

if ( isset($_POST['action']) && $_POST['action'] == 'Kustuta' ){

    $id = $_POST['id'];

    $stmt = $pdo->prepare('UPDATE books SET is_deleted = 1 WHERE id = :id');
    $stmt->execute(['id' => $id]);

    header("Location: ./book.php?id={ $id }");
};

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

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