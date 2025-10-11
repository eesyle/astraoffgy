<?php
 require_once 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update review logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-review'])) {
    $id = $_POST['review_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $review = $_POST['review'];
    $isActive = isset($_POST['isActive']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE reviews SET username=?, email=?, review=?, isActive=? WHERE id=?");
    $stmt->bind_param("sssii", $username, $email, $review, $isActive, $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Review updated successfully!');
                window.location.href = 'manage-review';
              </script>";
    } else {
        echo "<script>alert('Error updating review. Please try again.');</script>";
    }

    $stmt->close();
}

// Fetch reviews from the database
$result = $conn->query("SELECT * FROM reviews");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Reviews</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Review</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['review']; ?></td>
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
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="POST" action="">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Review</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="review">Review</label>
                                            <textarea class="form-control" name="review" rows="3" required><?php echo $row['review']; ?></textarea>
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

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
