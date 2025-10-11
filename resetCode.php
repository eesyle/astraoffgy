<?php
session_start();
include 'config.php';  

if (isset($_POST['resetPassword']) && isset($_SESSION['username'])) {
    $newPassword = $_POST['newpass'];
    $confirmPassword = $_POST['confirmPass'];
    $username = $_SESSION['username'];  

    if ($newPassword === $confirmPassword) {
        // $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param('ss', $newPassword, $username);
        $result = $stmt->execute();

        if ($result) {
            echo "<script>
                    alert('Password updated successfully.');
                    window.location.href='profile.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error updating password.');
                    window.location.href='profile.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Passwords do not match.');
                window.location.href='profile.php';
              </script>";
    }
}
?>
