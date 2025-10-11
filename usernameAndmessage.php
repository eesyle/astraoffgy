<?php
 require_once 'config.php';

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch usernames and reviews
$sql = "SELECT username, review FROM reviews where isActive = 1";
$result = $conn->query($sql);

$reviews_data = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $reviews_data[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();

// Output data in JSON format
header('Content-Type: application/json');
echo json_encode($reviews_data);
?>
