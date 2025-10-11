<?php
 

require_once 'conkt.php';
 


 

 
if ($conn->connect_error) die("Fatal Error");
// Create connection
 
 
// Fetch a random user from the database
$sql = "SELECT username FROM users  ORDER BY RAND()";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $randomUserData = [
        'username' => $row['username'],
    ];
    echo json_encode($randomUserData);
} else {
    echo json_encode(['error' => 'No users found']);
}

 
?>
