<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Database connection details
require_once 'config.php';

try {
   

    // Check if the form is submitted via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $author = $_POST['author'];
        $text = $_POST['text'];

        // Handle file uploads (profile image and photo)
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }

        $photo = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photo = 'uploads/' . basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
        }

        // Insert review into the database
        $stmt = $pdo->prepare('INSERT INTO customer_reviews (author, image, text, photo) VALUES (:author, :image, :text, :photo)');
        $stmt->execute([
            ':author' => $author,
            ':image' => $image,
            ':text' => $text,
            ':photo' => $photo
        ]);

        // Return success response
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Invalid request method');
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
