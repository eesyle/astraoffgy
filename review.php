<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
require_once "codeForLogs.php";

// Fetch reviews that are active or belong to the current user
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Handle form submission for new review
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $author = $username;
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
    $stmt = $conn->prepare('INSERT INTO customer_reviews (author, image, text, photo, rating, isActive) VALUES (?, ?, ?, ?, ?, 0)');
    $stmt->bind_param('ssssi', $author, $image, $text, $photo, $rating);
    $stmt->execute();

    // Redirect to avoid resubmitting the form on page refresh
    header("Location: review.php");
    exit();
}

// Handle user reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_reply']) && isset($_POST['review_id'])) {
    $user_reply = $_POST['user_reply'];
    $review_id = $_POST['review_id'];

    // Insert the user's reply into the review_replies table
    $stmt = $conn->prepare('INSERT INTO review_replies (review_id, user_reply, replied_at) VALUES (?, ?, NOW())');
    $stmt->bind_param('is', $review_id, $user_reply);
    $stmt->execute();

    // Redirect to avoid form resubmission
    header("Location: review.php");
    exit();
}

// Fetch reviews and all associated replies
$reviews = 'SELECT cr.id AS review_id, cr.author, cr.image, cr.text, cr.photo, cr.rating, cr.created_at,
                   rr.admin_reply, rr.user_reply, rr.replied_at, rr.replied_at
            FROM customer_reviews cr
            LEFT JOIN review_replies rr ON cr.id = rr.review_id
            WHERE cr.isActive = 1 OR cr.author = ?
            ORDER BY cr.id DESC, rr.replied_at ASC';

$stmt = $conn->prepare($reviews);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

$reviews_data = [];
while ($row = $result->fetch_assoc()) {
    $reviews_data[$row['review_id']]['review'] = [
        'author' => $row['author'],
        'image' => $row['image'],
        'text' => $row['text'],
        'photo' => $row['photo'],
        'rating' => $row['rating'],
        'created_at' => $row['created_at'],
    ];

    $reviews_data[$row['review_id']]['replies'][] = [
        'admin_reply' => $row['admin_reply'],
        'user_reply' => $row['user_reply'],
        'replied_at' => $row['replied_at'],
        'replied_at' => $row['replied_at'],
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <title>Altrexy  </title>
    <meta property="og:title" content="Astradox Pro — Us Banks">
    <meta property="og:description" content="Explicit Dumps">
    <meta property="og:image" content="assets/logo.png">

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="assets/logo.png">
    <link rel="stylesheet" href="xui-main/vendor/toastr/css/toastr.min.css">
    <link href="xui-main/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="xui-main/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="xui-main/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="xui-main/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Style css -->
    <link href="xui-main/css/style.css" rel="stylesheet">
    


    <style>
       
       .reviews-container {
    width: 100%;
    max-width: 1000px;
    margin: 0px auto;
    background-color:  #4D3498;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    padding: 40px; /* Reduce padding for better small screen layout */
}

/* Make the heading responsive */
h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    font-size: 2rem; /* Reduce font size for smaller screens */
}

/* Review card styling */
.review-card {
    width: 100%;
    display: flex;
    flex-direction: row;
    margin-bottom: 30px;
    background-color: #C3BBDC;
    border-radius: 10px;
    padding: 70px;
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
    font-size: 1.2rem;
    line-height: 1.6;
    color: #555;
}

.review-photo img {
    margin-top: 15px;
    max-width: 50%;
    border-radius: 8px;
}

/* Review form styling */
.review-form {
    position: relative; /* Better for responsiveness than absolute */
    margin-top: 40px;
    padding: 20px;
    background-color: #4D3498;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
    display: flex;
    flex-direction: column;
    align-items: flex-start; /* Align the content inside the form */
    left: 21%; /* Responsive positioning */
    right: 0; /* Responsive positioning */
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
            color: black;
        }
/* Media Queries for responsiveness */
@media (max-width: 768px) {
    h1 {
        font-size: 1.8rem; /* Smaller font for small screens */
    }
    
    .review-card {
        flex-direction: column; /* Stack the review card for smaller screens */
        padding: 10px;
    }

    .review-form {
        margin: 20px auto; /* Center the form on small screens */
        padding: 10px; /* Adjust padding for smaller screens */
        max-width: 90%; /* Ensure the form fits within the screen */
    }

    .review-image {
        width: 60px; /* Reduce the image size */
        height: 60px;
        margin-right: 10px;
    }

    .form-group input,
    .form-group textarea {
        font-size: 0.9rem; /* Adjust font size for smaller screens */
        width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;

            
            
    }

    .form-group button {
        font-size: 0.9rem; /* Adjust button size for smaller screens */
        padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            
            cursor: pointer;
    }
    .form-group textarea {
            height: 100px;
        }
}
.star-rating {
    display: flex;
    direction: row-reverse;
    justify-content: flex-start;
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 3rem;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s ease-in-out;
}

.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffcc00;
}

/* Media Queries for very small screens */
@media (max-width: 480px) {
    h1 {
        font-size: 1.5rem;
    }
    
    .review-card {
        padding: 5px;
    }

    .review-image {
        width: 50px;
        height: 50px;
    }

    .review-form {
        padding: 10px;
        max-width: 100%; /* Take full width on very small screens */
    }
}
 


    </style>
    
    <link href="static/css/grayscale.css" rel="stylesheet">
</head>

<body>
    <div id="main-wrapper">
        <?php include "navHeader.php"; ?>
        <div class="header" style="background: #2d2362; opacity: .9;">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">Ratings/Reviews</div>
                        </div>
                        <?php include 'header.php'; ?>
                    </div>
                </nav>
            </div>
        </div>
         
                <!--**********************************
            Sidebar start
        ***********************************-->
        <?php include 'sidebar.php'; ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <br>
        <br>
        <br>
        <div class="reviews-container">
    <h1 style="color: #fff;">Customer Reviews</h1>
    <div id="reviews-list">
        <?php foreach ($reviews_data as $review_id => $data): ?>
            <div class="review-card">
                <img class="review-image" src="<?= $data['review']['image'] ?: 'uploads/default-user.png'; ?>" alt="Profile Image">
                <div class="review-content">
                    <div class="review-author"><?= htmlspecialchars($data['review']['author']); ?></div>
                    <div class="review-date">
                        <small style="font-size: 1rem;">Reviewed on <?= date('F j, Y, g:i a', strtotime($data['review']['created_at'])); ?></small>
                    </div>
                    <div class="review-text"><?= htmlspecialchars($data['review']['text']); ?></div>

                    <!-- Display star rating -->
                    <div class="review-rating" style="font-size: 2rem;">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span style="color:<?= $i <= $data['review']['rating'] ? '#ffcc00' : '#ccc'; ?>">★</span>
                        <?php endfor; ?>
                    </div>

                    <!-- Conversation thread between user and admin -->
                    <div class="conversation-thread">
                        <?php foreach ($data['replies'] as $reply): ?>
                            <?php if (!empty($reply['admin_reply'])): ?>
                                <div class="admin-reply">
                                    <strong style="color: #fff;">Admin Reply:</strong>
                                    <p style="font-size: 1.2rem; color: #000;"><?= htmlspecialchars($reply['admin_reply']); ?></p>
                                    <small style="font-size: 1rem;">Replied on <?= date('F j, Y, g:i a', strtotime($reply['replied_at'])); ?></small>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($reply['user_reply'])): ?>
                                <div class="user-reply">
                                    <strong style="color: #fff;">Your Reply:</strong>
                                    <p style="font-size: 1.2rem; color: #000;"><?= htmlspecialchars($reply['user_reply']); ?></p>
                                    <small style="font-size: 1rem;">Replied on <?= date('F j, Y, g:i a', strtotime($reply['replied_at'])); ?></small>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Keep showing the reply form for user if admin has replied -->
                    <?php if (!empty(end($data['replies'])['admin_reply'])): ?>
                        <div class="reply-form">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="user_reply" style="color: #fff;">Your Reply</label>
                                    <textarea id="user_reply" name="user_reply" style="font-size: 0.9rem; width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;" required></textarea>
                                </div>
                                <input type="hidden" name="review_id" value="<?= $review_id; ?>">
                                <div class="form-group">
                                    <button type="submit" name="submit_reply" style="padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; font-size: 1rem;">Submit Reply</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <!-- Display review photo if it exists -->
                    <?php if ($data['review']['photo']): ?>
                        <div class="review-photo">
                            <img src="<?= $data['review']['photo']; ?>" alt="Review Photo">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

    <div class="review-form">
        <h2  style="color: #fff;">Submit Your Review</h2>
        <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
    <label for="author" style="color: #fff;">Your Name</label>
    <input type="text" id="author" name="author" value="<?= htmlspecialchars($username); ?>" style=" font-size: 0.9rem;  
        width: 100%;
        padding: 10px;
        color: #fff;
        border-radius: 5px;
        border: 1px solid #ddd;" disabled>
</div>

            <div class="form-group">
                <label for="text" style="color: #fff;" >Your Review</label>
                <textarea id="text" name="text" style=" font-size: 0.9rem;  
        width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;" required></textarea>
            </div>
            <div class="form-group">
                <label for="image" style="color: #fff;">Your Profile Picture (optional)</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="photo" style="color: #fff;">Upload a Photo (optional)</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>
            <div class="form-group">
    <label for="rating" style="color: #fff;">Rating (1-5 stars)</label>
    <div class="star-rating" style="font-size: 3rem;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s ease-in-out;">
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
                <button type="submit" name="submit"   style="padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;">Submit Review</button>
            </div>
        </form>
    </div>

         
    </div>

        <!-- Modal -->
   <?php include 'topModel.php'; ?>
    <!-- /Modal -->

    <!-- Modal -->
   <?php include 'supportModel.php'; ?>
    <!-- /Modal -->

  

    <!-- Required vendors -->
    <script src="xui-main/vendor/global/global.min.js"></script>
    <script src="xui-main/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="xui-main/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
    <script src="xui-main/vendor/toastr/js/toastr.min.js"></script>
    <script src="xui-main/vendor/apexchart/apexchart.js"></script>
    <script src="xui-main/vendor/peity/jquery.peity.min.js"></script>
    <script src="xui-main/vendor/chartist/js/chartist.min.js"></script>
    <script src="xui-main/vendor/jquery-autocomplete/jquery-ui.js"></script>
    <script src="xui-main/js/dashboard/dashboard-1.js"></script>
    <script src="xui-main/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="xui-main/js/plugins-init/datatables.init.js"></script>
    <script src="xui-main/js/custom.min.js"></script>
    <script src="xui-main/js/dlabnav-init.js"></script>
    <script src="xui-main/js/styleSwitcher.js"></script>
    <script src="xui-main/js/demo.js"></script>
    <script src="index.js"></script>

    <script type="text/javascript">
        function copyToClip(c) {
            navigator.clipboard.writeText(c);
            alert("Copied: " + c);
        }
    </script>
</body>

</html>
