<?php

require_once('./connection.php');

$stmt = $pdo->query('SELECT * FROM books WHERE is_deleted = 0');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Book List</h1>
    <ul class="max-w-lg mx-auto bg-white shadow-md rounded-lg">
        <?php while ($book = $stmt->fetch()) { ?>
            <li class="border-b border-gray-200">
                <a href="./book.php?id=<?= $book['id']; ?>" 
                   class="block px-4 py-4 hover:bg-gray-100 transition text-gray-700">
                    <?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

</body>
</html>
