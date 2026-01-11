<?php
 ob_start(); // Start output buffering to prevent header errors
 require_once 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper to show debug on page
function showDebug($msg) {
    echo "<div class='alert alert-info alert-dismissible fade show' role='alert' style='z-index: 9999; position: relative;'>
            <strong>DEBUG:</strong> " . htmlspecialchars($msg) . "
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
}

// Quick Toggle Status Logic (New Feature)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle_status') {
    // Show debug info
    showDebug("Toggle Status Requested. POST Data: " . json_encode($_POST));

    $id = (int)$_POST['review_id'];
    $currentStatus = (int)$_POST['current_status'];
    $newStatus = $currentStatus ? 0 : 1; // Toggle: 1 -> 0, 0 -> 1
    
    showDebug("Toggling ID $id from $currentStatus to $newStatus");

    if ($conn->connect_error) {
        showDebug("DB Connection Failed: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare('UPDATE customer_reviews SET isActive=? WHERE id=?');
    if (!$stmt) {
        showDebug("Prepare Failed: " . $conn->error);
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('ii', $newStatus, $id);
    
    try {
        if ($stmt->execute()) {
            // Success - Show success message
            $affected = $stmt->affected_rows;
            showDebug("Update Successful! Affected Rows: $affected");
            
            if ($affected === 0) {
                showDebug("Warning: No rows were changed. Did you make any edits?");
            }
            
            // Disable auto-redirect for debugging purposes
            echo "<div class='alert alert-success' style='z-index: 9999; position: relative;'>
                    <strong>Operation Completed.</strong><br>
                    Please check the database or the table below to see if changes applied.<br>
                    <a href='manage-review.php' class='btn btn-primary mt-2'>Click here to Refresh/Continue</a>
                  </div>";
        }
    } catch (Exception $e) {
        showDebug("Exception during execution: " . $e->getMessage());
        die("Error updating status: " . $e->getMessage());
    }
    $stmt->close();
}

// Delete review logic (optional, aligns with existing UI)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-review']) && isset($_POST['delete_id'])) {
    $delId = (int)$_POST['delete_id'];
    $stmt = $conn->prepare('DELETE FROM customer_reviews WHERE id=?');
    $stmt->bind_param('i', $delId);
    try {
        $stmt->execute();
        echo "<script>alert('Review deleted successfully!'); window.location.href = 'manage-review.php';</script>";
    } catch (Exception $e) {
        showDebug("Delete Failed: " . $e->getMessage());
        echo "<script>alert('Error deleting review: " . addslashes($e->getMessage()) . "');</script>";
    }
    exit();
}

// Update review logic for customer_reviews
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['update-review']) || (isset($_POST['action']) && $_POST['action'] === 'update_review'))) {
    // Show debug info
    showDebug("Update Review Requested. POST Data: " . json_encode($_POST));

    $id = (int)$_POST['review_id'];
    $author = $_POST['author'];
    $text = $_POST['text'];
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $created_at_input = isset($_POST['created_at']) ? $_POST['created_at'] : '';
    $isActive = isset($_POST['isActive']) ? 1 : 0;

    // Normalize datetime-local to MySQL DATETIME
    $created_at = !empty($created_at_input) ? str_replace('T', ' ', $created_at_input) : date('Y-m-d H:i:s');

    // Preserve existing image/photo unless a new file is uploaded
    $image = isset($_POST['existing_image']) ? $_POST['existing_image'] : null;
    $photo = isset($_POST['existing_photo']) ? $_POST['existing_photo'] : null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
        showDebug("New image uploaded: $image");
    }
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
        showDebug("New photo uploaded: $photo");
    }

    $stmt = $conn->prepare('UPDATE customer_reviews SET author=?, image=?, text=?, photo=?, rating=?, created_at=?, isActive=? WHERE id=?');
    if (!$stmt) {
        showDebug("Update Prepare Failed: " . $conn->error);
        die("Update prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param('ssssisii', $author, $image, $text, $photo, $rating, $created_at, $isActive, $id);

    try {
        if ($stmt->execute()) {
            $affected = $stmt->affected_rows;
            showDebug("Update Successful! Affected Rows: $affected");
            
            if ($affected === 0) {
                showDebug("Warning: No rows were changed. This usually means the data was identical to what was already in the database.");
            }
    
            echo "<div class='alert alert-success' style='z-index: 9999; position: relative;'>
                    <strong>Review Updated.</strong><br>
                    Affected Rows: $affected<br>
                    <a href='manage-review.php' class='btn btn-primary mt-2'>Click here to Refresh/Continue</a>
                  </div>";
        }
    } catch (Exception $e) {
        showDebug("Update Execute Failed: " . $e->getMessage());
        echo "<script>alert('Error updating review: " . addslashes($e->getMessage()) . "');</script>";
    }

    $stmt->close();
}

// Fetch reviews from customer_reviews
$result = $conn->query("SELECT * FROM customer_reviews ORDER BY id DESC");
$reviews = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews</title>
    <!-- Include Bootstrap CSS first, then our overrides -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleee.css">
    <style>
        /* Fix for modal z-index issues if they occur */
        .modal-backdrop {
            z-index: 1040 !important;
        }
        .modal-content {
            z-index: 1100 !important;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <?php include 'adminSideBar.php'; ?>
        <div class="main-content">
            <header class="admin-header">
                <h1>Manage Reviews</h1>
                <a class="logout-btn" href="LogOut.php">Logout</a>
            </header>

            <section class="content-section">
                <h2>Reviews Management Section</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th>Author</th>
                                <th>Image</th>
                                <th>Text</th>
                                <th>Photo</th>
                                <th>Rating</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reviews as $row) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['author']); ?></td>
                                    <td>
                                        <?php $img = !empty($row['image']) ? $row['image'] : 'uploads/default-user.png'; ?>
                                        <img src="<?php echo $img; ?>" alt="Image" style="width:50px;height:50px;border-radius:6px;object-fit:cover;">
                                    </td>
                                    <td><?php echo nl2br(htmlspecialchars($row['text'])); ?></td>
                                    <td>
                                        <?php if (!empty($row['photo'])) { ?>
                                            <img src="<?php echo $row['photo']; ?>" alt="Photo" style="width:70px;height:50px;border-radius:6px;object-fit:cover;">
                                        <?php } else { echo '<span class="text-muted">None</span>'; } ?>
                                    </td>
                                    <td><?php echo (int)$row['rating']; ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    <td>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="action" value="toggle_status">
                                            <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="current_status" value="<?php echo $row['isActive']; ?>">
                                            <button type="submit" class="btn btn-sm <?php echo $row['isActive'] ? 'btn-success' : 'btn-secondary'; ?>" title="Click to Toggle Status">
                                                <?php echo $row['isActive'] ? 'Deactivate' : 'Activate'; ?>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Edit Button triggers modal -->
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editReviewModal<?php echo $row['id']; ?>">Edit</button>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete-review">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <!-- Modals outside the table structure -->
    <?php foreach ($reviews as $row) { ?>
        <!-- Edit Review Modal -->
        <div class="modal fade" id="editReviewModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="update_review">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Review</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-dark">
                            <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" class="form-control" name="author" value="<?php echo htmlspecialchars($row['author']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="text">Text</label>
                                <textarea class="form-control" name="text" rows="3" required><?php echo htmlspecialchars($row['text']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($row['image']); ?>">
                                <?php if (!empty($row['image'])) { ?>
                                    <div class="mt-2">
                                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Current Image" class="media-thumb" style="max-width: 100px;">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <input type="file" class="form-control" name="photo" accept="image/*">
                                <input type="hidden" name="existing_photo" value="<?php echo htmlspecialchars($row['photo']); ?>">
                                <?php if (!empty($row['photo'])) { ?>
                                    <div class="mt-2">
                                        <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Current Photo" class="media-thumb" style="max-width: 100px;">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <input type="number" class="form-control" name="rating" min="0" max="5" value="<?php echo (int)$row['rating']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="created_at">Created At</label>
                                <input type="datetime-local" class="form-control" name="created_at" value="<?php echo date('Y-m-d\TH:i', strtotime($row['created_at'])); ?>" required>
                            </div>
                            
                            <!-- Improved Switch Design for Active Status -->
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="isActive" id="isActiveSwitch<?php echo $row['id']; ?>" <?php echo $row['isActive'] ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="isActiveSwitch<?php echo $row['id']; ?>">
                                        Make this review active
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="update-review">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
