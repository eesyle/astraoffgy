<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
require_once 'config.php';

// Check if admin is submitting a reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_reply'])) {
    $review_id = $_POST['review_id'];
    $admin_reply = $_POST['admin_reply'];

    // Insert the admin's reply into the review_replies table
    $stmt = $conn->prepare('INSERT INTO review_replies (review_id, admin_reply, replied_at) VALUES (?, ?, NOW())');
    $stmt->bind_param('is', $review_id, $admin_reply);
    $stmt->execute();

    // Redirect to avoid form resubmission on page refresh
    header("Location: admin_reply.php");
    exit();
}

// Fetch reviews and their replies from the database
$reviews_query = 'SELECT cr.*, rr.admin_reply, rr.user_reply, rr.replied_at, rr.user_replied_at 
                  FROM customer_reviews cr
                  LEFT JOIN review_replies rr ON cr.id = rr.review_id
                  ORDER BY cr.id DESC';
$result = $conn->query($reviews_query);

$rows = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reply to Reviews</title>
    <style>
        /* Modern Design with Soft Colors and Hover Effects */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }
        .reviews-container {
            width: 90%;
            max-width: 1000px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 2rem;
        }
        .review-card {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
        }
        .review-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .review-author {
            font-weight: bold;
            margin-bottom: 5px;
            color: #007bff;
        }
        .review-text {
            margin-bottom: 10px;
            font-size: 1.1rem;
            color: #555;
        }
        .review-rating span {
            font-size: 1.5rem;
        }
        .admin-reply, .user-reply {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 1rem;
            color: #333;
        }
        .conversation-thread {
            margin-top: 10px;
            padding-left: 10px;
            border-left: 4px solid #007bff;
        }
        .admin-reply-form {
            margin-top: 20px;
        }
        .admin-reply-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            margin-bottom: 10px;
        }
        .admin-reply-form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .admin-reply-form button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .admin-reply-form button:active {
            background-color: #004089;
            transform: translateY(0);
        }

        /* Modern buttons for Activate/Deactivate */
        .toggle-btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .toggle-btn.deactivate {
            background-color: #dc3545;
        }
        .toggle-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        .toggle-btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>
    <div class="reviews-container">
        <h1>Admin Reply to Reviews</h1>
        <?php foreach ($rows as $row): ?>
            <div class="review-card">
                <div class="review-author"><?= htmlspecialchars($row['author']); ?></div>
                <div class="review-text"><?= htmlspecialchars($row['text']); ?></div>
                <div class="review-rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span style="color:<?= $i <= $row['rating'] ? '#ffcc00' : '#ccc'; ?>">★</span>
                    <?php endfor; ?>
                </div>
                <small>Reviewed on <?= date('F j, Y, g:i a', strtotime($row['created_at'])); ?></small>

                <!-- Conversation thread -->
                <div class="conversation-thread">
                    <?php if ($row['user_reply']): ?>
                        <div class="user-reply">
                            <strong>User Reply:</strong>
                            <p><?= htmlspecialchars($row['user_reply']); ?></p>
                            <small>Replied on <?= date('F j, Y, g:i a', strtotime($row['replied_at'])); ?></small>
                        </div>
                    <?php endif; ?>

                    <?php if ($row['admin_reply']): ?>
                        <div class="admin-reply">
                            <strong>Admin Reply:</strong>
                            <p><?= htmlspecialchars($row['admin_reply']); ?></p>
                            <small>Replied on <?= date('F j, Y, g:i a', strtotime($row['replied_at'])); ?></small>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Admin reply form -->
                <div class="admin-reply-form">
                    <form action="" method="POST">
                        <input type="hidden" name="review_id" value="<?= $row['id']; ?>">
                        <textarea name="admin_reply" rows="3" placeholder="Write a reply..." required></textarea>
                        <button type="submit" name="submit">Submit Reply</button>
                    </form>
                </div>

                <!-- Toggle isActive status -->
                <form action="activate.php" method="POST">
                    <input type="hidden" name="review_id" value="<?= $row['id']; ?>">
                    <input type="hidden" name="isActive" value="<?= $row['isActive']; ?>">
                    <button type="submit" class="toggle-btn <?= $row['isActive'] ? 'deactivate' : ''; ?>">
                        <?= $row['isActive'] ? 'Deactivate' : 'Activate'; ?> Review
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
