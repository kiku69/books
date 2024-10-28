<?php

require_once('./connection.php');

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

// $stmt = $pdo->prepare('SELECT * FROM book_authors ba LEFT JOIN authors a ON ba.authors_id=a.id WHERE ba.book.id = :id');
// $stmt->execute(['id' => $id]);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>Pealkiri: <?= $book['title']?></h1>
    <ul>
        <?php while ( $author = $stmt->fetch() ) { ?>

            <li>
                <?= $author['first_name']; ?>
            </li>
        
        <?php } ?>
    </ul>

    <p>Hind: <?= round($book['price'], 2);?> &euro;</p>

    <a href="./edit.php?id=<?= $id ?>">Muuda</a>

    <form action="./delete.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="submit" name="action" value="Kustuta">
    </form>
    
</body>
</html>