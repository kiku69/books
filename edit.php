<?php

require_once('./connection.php');

$id = $_GET['id'];

// get book data
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

// get book authors
$bookAuthorsStmt = $pdo->prepare('SELECT * FROM book_authors ba LEFT JOIN authors a ON ba.author_id = a.id WHERE ba.book_id = :id');
$bookAuthorsStmt->execute(['id' => $id]);

// get available authors
$availableAuthorsStmt = $pdo->prepare('SELECT * FROM authors WHERE id NOT IN (SELECT author_id FROM book_authors WHERE book_id = :book_id)');
$availableAuthorsStmt->execute(['book_id' => $id]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

<div class="container mx-auto py-8 px-4">
    <nav class="mb-6">
        <a href="./book.php?id=<?= $id; ?>" class="text-blue-500 hover:underline">&larr; Back</a>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6 max-w-2xl mx-auto">
        <h3 class="text-2xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></h3>

        <form action="./update_book.php?id=<?= $id; ?>" method="post" class="space-y-4">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
                <input type="text" id="price" name="price" value="<?= htmlspecialchars($book['price'], ENT_QUOTES, 'UTF-8'); ?>" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <button type="submit" name="action" value="save" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    Save
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 max-w-2xl mx-auto mt-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Authors:</h3>

        <ul class="space-y-4">
            <?php while ($author = $bookAuthorsStmt->fetch()) { ?>
                <li class="flex justify-between items-center border-b border-gray-200 pb-2">
                    <span class="text-gray-700"><?= htmlspecialchars($author['first_name'], ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars($author['last_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <form action="./remove_author.php?id=<?= $id; ?>" method="post" class="flex items-center">
                        <input type="hidden" name="author_id" value="<?= $author['id']; ?>">
                        <button type="submit" name="action" value="remove_author" 
                                class="text-red-500 hover:text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash">
                                <path d="M5.5 5.5v10h5v-10h-5zM14.5 3v1H1v-1h13.5zM6 5.5H5v10h1v-10zm2 10v-10H7v10h1zm2-10H9v10h1v-10z"/>
                            </svg>
                        </button>
                    </form>
                </li>
            <?php } ?>
        </ul>

        <form action="./add_author.php" method="post" class="mt-6 space-y-4">
            <input type="hidden" name="book_id" value="<?= $id; ?>">
            
            <!-- Select existing author -->
            <div>
                <label for="author_id" class="block text-sm font-medium text-gray-700">Select an existing author:</label>
                <select name="author_id" id="author_id" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="" selected>Choose an author</option>
                    <?php while ($author = $availableAuthorsStmt->fetch()) { ?>
                        <option value="<?= $author['id']; ?>">
                            <?= htmlspecialchars($author['first_name'], ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars($author['last_name'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Add new author -->
            <div>
                <label for="new_author_first_name" class="block text-sm font-medium text-gray-700">Add a new author:</label>
                <div class="flex space-x-4">
                    <input type="text" name="new_author_first_name" id="new_author_first_name" placeholder="First name" 
                           class="block w-1/2 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <input type="text" name="new_author_last_name" id="new_author_last_name" placeholder="Last name" 
                           class="block w-1/2 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <button type="submit" name="action" value="add_author" 
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                Add Author
            </button>
        </form>
    </div>
</div>

</body>
</html>
