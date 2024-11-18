<?php

require_once('./connection.php');

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT * FROM book_authors ba LEFT JOIN authors a ON ba.author_id=a.id WHERE ba.book_id = :id');
$stmt->execute(['id' => $id]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

<div class="container mx-auto py-8 px-4">
    <div class="mb-6">
        <a href="./index.php" 
           class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
            &larr; Back
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
        
        <h2 class="text-xl font-semibold text-gray-700 mb-2">Authors:</h2>
        <ul class="list-disc pl-5 mb-4">
            <?php while ($author = $stmt->fetch()) { ?>
                <li class="text-gray-600">
                    <?= htmlspecialchars($author['first_name'], ENT_QUOTES, 'UTF-8'); ?> 
                    <?= htmlspecialchars($author['last_name'], ENT_QUOTES, 'UTF-8'); ?>
                </li>
            <?php } ?>
        </ul>

        <p class="text-lg font-medium mb-4">
            <span class="text-gray-700">Price:</span> 
            <span class="text-gray-900"><?= round($book['price'], 2); ?> &euro;</span>
        </p>

        <div class="flex space-x-4">
            <a href="./edit.php?id=<?= $id; ?>" 
               class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Edit
            </a>
            <form action="./delete.php" method="post">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <button type="submit" name="action" value="Kustuta" 
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
