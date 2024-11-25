<?php

require_once('./connection.php');

if (isset($_POST['action']) && $_POST['action'] == 'add_author') {
    $book_id = $_POST['book_id'];
    $author_id = $_POST['author_id'];
    $new_first_name = trim($_POST['new_author_first_name']);
    $new_last_name = trim($_POST['new_author_last_name']);

    if (!empty($author_id)) {
        // Add existing author
        $stmt = $pdo->prepare('INSERT INTO book_authors (book_id, author_id) VALUES (:book_id, :author_id)');
        $stmt->execute(['book_id' => $book_id, 'author_id' => $author_id]);
    } elseif (!empty($new_first_name) && !empty($new_last_name)) {
        // Add new author
        $pdo->beginTransaction();

        try {
            // Insert new author
            $stmt = $pdo->prepare('INSERT INTO authors (first_name, last_name) VALUES (:first_name, :last_name)');
            $stmt->execute(['first_name' => $new_first_name, 'last_name' => $new_last_name]);
            $new_author_id = $pdo->lastInsertId();

            // Link new author to book
            $stmt = $pdo->prepare('INSERT INTO book_authors (book_id, author_id) VALUES (:book_id, :author_id)');
            $stmt->execute(['book_id' => $book_id, 'author_id' => $new_author_id]);

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            die('Error: ' . $e->getMessage());
        }
    } else {
        die('Please select an author or provide new author details.');
    }

    // Redirect to edit page
    header("Location: ./edit.php?id={$book_id}");
    exit;
} else {
    // Redirect to index page if no valid action is found
    header("Location: ./index.php");
    exit;
}
?>
