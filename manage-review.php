 <?php
ob_start();
require_once 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* =========================
   HELPER: DEBUG MESSAGE
========================= */
function showDebug($msg) {
    echo "<div class='alert alert-info mt-2'>$msg</div>";
}

/* =========================
   TOGGLE REVIEW STATUS
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['action'])
    && $_POST['action'] === 'toggle_status') {

    $id = (int)$_POST['review_id'];
    $currentStatus = (int)$_POST['current_status'];
    $newStatus = $currentStatus ? 0 : 1;

    $stmt = $conn->prepare(
        "UPDATE customer_reviews SET isActive=? WHERE id=?"
    );
    $stmt->bind_param("ii", $newStatus, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage-review.php");
    exit;
}

/* =========================
   DELETE REVIEW
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['delete-review'])) {

    $id = (int)$_POST['delete_id'];

    $stmt = $conn->prepare(
        "DELETE FROM customer_reviews WHERE id=?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage-review.php");
    exit;
}

/* =========================
   UPDATE REVIEW
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['action'])
    && $_POST['action'] === 'update_review') {

    $id = (int)$_POST['review_id'];
    $author = $_POST['author'];
    $text = $_POST['text'];
    $rating = (int)$_POST['rating'];
    $isActive = isset($_POST['isActive']) ? 1 : 0;

    // Datetime conversion
    $created_at = str_replace('T', ' ', $_POST['created_at']);

    // Preserve existing media
    $image = $_POST['existing_image'];
    $photo = $_POST['existing_photo'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    $stmt = $conn->prepare(
        "UPDATE customer_reviews
         SET author=?, image=?, text=?, photo=?, rating=?, created_at=?, isActive=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "ssssisii",
        $author,
        $image,
        $text,
        $photo,
        $rating,
        $created_at,
        $isActive,
        $id
    );

    $stmt->execute();
    $stmt->close();

    header("Location: manage-review.php?updated=1");
    exit;
}

/* =========================
   FETCH REVIEWS
========================= */
$reviews = [];
$result = $conn->query(
    "SELECT * FROM customer_reviews ORDER BY id DESC"
);

while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Reviews</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
    <h2 class="mb-4">Manage Reviews</h2>

    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success">Review updated successfully.</div>
    <?php endif; ?>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Author</th>
                <th>Image</th>
                <th>Text</th>
                <th>Photo</th>
                <th>Rating</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($reviews as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['author']) ?></td>

                <td>
                    <img src="<?= $row['image'] ?: 'uploads/default-user.png' ?>"
                         width="50">
                </td>

                <td><?= htmlspecialchars($row['text']) ?></td>

                <td>
                    <?php if ($row['photo']): ?>
                        <img src="<?= $row['photo'] ?>" width="60">
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>

                <td><?= (int)$row['rating'] ?></td>
                <td><?= $row['created_at'] ?></td>

                <td>
                    <form method="POST">
                        <input type="hidden" name="action" value="toggle_status">
                        <input type="hidden" name="review_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="current_status" value="<?= $row['isActive'] ?>">
                        <button class="btn btn-sm <?= $row['isActive'] ? 'btn-success' : 'btn-secondary' ?>">
                            <?= $row['isActive'] ? 'Active' : 'Inactive' ?>
                        </button>
                    </form>
                </td>

                <td>
                    <button class="btn btn-primary btn-sm"
                            data-toggle="modal"
                            data-target="#edit<?= $row['id'] ?>">
                        Edit
                    </button>

                    <form method="POST" style="display:inline">
                        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                        <button class="btn btn-danger btn-sm" name="delete-review">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>

            <!-- EDIT MODAL -->
            <div class="modal fade" id="edit<?= $row['id'] ?>">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content text-dark">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update_review">
                            <input type="hidden" name="review_id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="existing_image" value="<?= $row['image'] ?>">
                            <input type="hidden" name="existing_photo" value="<?= $row['photo'] ?>">

                            <div class="modal-header">
                                <h5>Edit Review</h5>
                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <input class="form-control mb-2" name="author" value="<?= $row['author'] ?>">
                                <textarea class="form-control mb-2" name="text"><?= $row['text'] ?></textarea>
                                <input type="file" class="form-control mb-2" name="image">
                                <input type="file" class="form-control mb-2" name="photo">
                                <input type="number" class="form-control mb-2" name="rating" value="<?= $row['rating'] ?>">
                                <input type="datetime-local" class="form-control mb-2" name="created_at"
                                       value="<?= date('Y-m-d\TH:i', strtotime($row['created_at'])) ?>">

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="isActive"
                                        <?= $row['isActive'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
