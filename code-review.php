<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit-review'])) {
    // Collect form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $review = $_POST['review'];

    // Simple validation (could be more complex)
    if (!empty($username) && !empty($email) && !empty($review)) {
        require_once 'config.php';
 

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO reviews (username, email, review) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $review);

        if ($stmt->execute()) {
            echo "<script>
            alert('Your review has been submitted successfully!');
            setTimeout(function() {
                window.location.href = 'dash.php';
            }, 1000);  
          </script>";
        } else {
            echo "<script>alert('Error submitting review.');</script>";
        }

        $stmt->close();
        $conn->close();

    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
?>
