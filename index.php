<?php

require_once('./connection.php');

// Handle search query
$search = $_GET['search'] ?? '';
$stmt = $pdo->prepare('SELECT * FROM books WHERE is_deleted = 0 AND title LIKE :search');
$stmt->execute(['search' => "%$search%"]);

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

    <!-- Search Bar -->
    <form action="./index.php" method="get" class="max-w-lg mx-auto mb-6">
        <div class="flex">
            <input 
                type="text" 
                name="search" 
                value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>" 
                placeholder="Search for a book..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-blue-500 focus:border-blue-500"
            >
            <button 
                type="submit" 
                class="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 transition">
                Search
            </button>
        </div>
    </form>

    <!-- Book List -->
    <ul class="max-w-lg mx-auto bg-white shadow-md rounded-lg">
        <?php while ($book = $stmt->fetch()) { ?>
            <li class="border-b border-gray-200">
                <a href="./book.php?id=<?= $book['id']; ?>" 
                   class="block px-4 py-4 hover:bg-gray-100 transition text-gray-700">
                    <?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </li>
        <?php } ?>
        <?php if ($stmt->rowCount() === 0) { ?>
            <li class="px-4 py-4 text-gray-500 text-center">No books found.</li>
        <?php } ?>
    </ul>
</div>

</body>
</html>
