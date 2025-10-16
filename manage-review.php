<?php
 require_once 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete review logic (optional, aligns with existing UI)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-review']) && isset($_POST['delete_id'])) {
    $delId = (int)$_POST['delete_id'];
    $stmt = $conn->prepare('DELETE FROM customer_reviews WHERE id=?');
    $stmt->bind_param('i', $delId);
    $stmt->execute();
    echo "<script>alert('Review deleted successfully!'); window.location.href = 'manage-review.php';</script>";
    exit();
}

// Update review logic for customer_reviews
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-review'])) {
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
    }
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    $stmt = $conn->prepare('UPDATE customer_reviews SET author=?, image=?, text=?, photo=?, rating=?, created_at=?, isActive=? WHERE id=?');
    $stmt->bind_param('ssssisii', $author, $image, $text, $photo, $rating, $created_at, $isActive, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Review updated successfully!'); window.location.href = 'manage-review.php';</script>";
    } else {
        echo "<script>alert('Error updating review. Please try again.');</script>";
    }

    $stmt->close();
}

// Fetch reviews from customer_reviews
$result = $conn->query("SELECT * FROM customer_reviews ORDER BY id DESC");

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
                <?php while ($row = $result->fetch_assoc()) { ?>
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
                        <td><?php echo $row['isActive'] ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>'; ?></td>
                        <td>
                            <!-- Edit Button triggers modal -->
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editReviewModal<?php echo $row['id']; ?>">Edit</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm" name="delete-review">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Review Modal -->
                    <div class="modal fade" id="editReviewModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Review</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
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
                                                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Current Image" class="media-thumb">
                                            <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="photo">Photo</label>
                                            <input type="file" class="form-control" name="photo" accept="image/*">
                                            <input type="hidden" name="existing_photo" value="<?php echo htmlspecialchars($row['photo']); ?>">
                                            <?php if (!empty($row['photo'])) { ?>
                                                <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Current Photo" class="media-thumb">
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
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="isActive" <?php echo $row['isActive'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="isActive">Active</label>
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
            </tbody>
        </table>
                </div>
            </section>
        </div>
    </div>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
