<?php
session_start();
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
require_once 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author = $_POST['author'];
    $text = $_POST['text'];
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
    $image = null;
    $photo = null;

    // Handle file uploads for profile image and review photo
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    // Insert the new review into the database
    $stmt = $conn->prepare('INSERT INTO customer_reviews (author, image, text, photo, rating,isActive) VALUES (?, ?, ?, ?, ?,0)');
    $stmt->bind_param('ssssi', $author, $image, $text, $photo, $rating);
    $stmt->execute();

    // Redirect to avoid resubmitting the form on page refresh
    header("Location: review.php");
    exit();
}

// Fetch reviews that are active or belong to the current user
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$reviews = 'SELECT cr.*, rr.admin_reply, rr.replied_at 
            FROM customer_reviews cr
            LEFT JOIN review_replies rr ON cr.id = rr.review_id
            WHERE cr.isActive = 1 OR cr.author = ?
            ORDER BY cr.id DESC';

$stmt = $conn->prepare($reviews);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $rows = [];
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
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
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 2.5rem;
        }

        .review-card {
            display: flex;
            margin-bottom: 30px;
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            transition: transform 0.2s ease;
        }

        .review-card:hover {
            transform: scale(1.02);
        }

        .review-image {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 20px;
        }

        .review-content {
            flex-grow: 1;
        }

        .review-author {
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 8px;
            color: #333;
        }

        .review-text {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
        }

        .review-photo img {
            margin-top: 15px;
            max-width: 100%;
            border-radius: 8px;
        }

        .review-form {
            margin-top: 40px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .review-form h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-group textarea {
            height: 100px;
        }

        .form-group button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #218838;
        }
        .star-rating {
    display: flex;
    direction: row-reverse;
    justify-content: flex-end;
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 2rem;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s ease-in-out;
}

.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffcc00;
}

    </style>
</head>
<body>
    <div class="reviews-container">
        <h1>Customer Reviews</h1>
        <div id="reviews-list">
            <?php foreach ($rows as $rows): ?>
                 
                <div class="review-card">
    <img class="review-image" src="<?= $rows['image'] ?: 'uploads/default-user.png'; ?>" alt="Profile Image">
    <div class="review-content">
        <div class="review-author"><?= htmlspecialchars($rows['author']); ?></div>
        <div class="review-date">
            <small>Reviewed on <?= date('F j, Y, g:i a', strtotime($rows['created_at'])); ?></small>
        </div>
        <div class="review-text"><?= htmlspecialchars($rows['text']); ?></div>
        
        <!-- Display star rating -->
        <div class="review-rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span style="color:<?= $i <= $rows['rating'] ? '#ffcc00' : '#ccc'; ?>">★</span>
            <?php endfor; ?>
        </div>

        <!-- Check if admin_reply exists before displaying it -->
        <?php if (isset($rows['admin_reply']) && !empty($rows['admin_reply'])): ?>
            <div class="admin-reply">
                <strong>Admin Reply:</strong>
                <p><?= htmlspecialchars($rows['admin_reply']); ?></p>
                <small>Replied on <?= date('F j, Y, g:i a', strtotime($rows['replied_at'])); ?></small>
            </div>
        <?php endif; ?>

        <?php if ($rows['photo']): ?>
        <div class="review-photo">
            <img src="<?= $rows['photo']; ?>" alt="Review Photo">
        </div>
        <?php endif; ?>
    </div>
</div>


            <?php endforeach; ?>
        </div>
    </div>

    <div class="review-form">
        <h2">Submit Your Review</h2>
        <form action=" " method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="author">Your Name</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="text">Your Review</label>
                <textarea id="text" name="text" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Your Profile Picture (optional)</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="photo">Upload a Photo (optional)</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>
            <div class="form-group">
    <label for="rating">Rating (1-5 stars)</label>
    <div class="star-rating">
        <input type="radio" id="star5" name="rating" value="5" />
        <label for="star5" title="5 stars">★</label>
        <input type="radio" id="star4" name="rating" value="4" />
        <label for="star4" title="4 stars">★</label>
        <input type="radio" id="star3" name="rating" value="3" />
        <label for="star3" title="3 stars">★</label>
        <input type="radio" id="star2" name="rating" value="2" />
        <label for="star2" title="2 stars">★</label>
        <input type="radio" id="star1" name="rating" value="1" />
        <label for="star1" title="1 star">★</label>
    </div>
</div>

            <div class="form-group">
                <button type="submit" name="submit">Submit Review</button>
            </div>
        </form>
    </div>
</body>
</html>
