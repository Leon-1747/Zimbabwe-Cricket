<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zimbabwe_cricket_db";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    
    if (empty($name) || empty($email) || empty($comment)) {
        echo json_encode(['error' => 'All fields are required.']);
        exit();
    }

    
    $stmt = $conn->prepare("INSERT INTO comments (name, email, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $comment);

   
    if ($stmt->execute()) {
        echo json_encode(['success' => 'Comment added successfully!']);
    } else {
        echo json_encode(['error' => 'Failed to add comment: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    
    $result = $conn->query("SELECT * FROM comments ORDER BY created_at DESC");
    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    echo json_encode($comments);
}

$conn->close();
?>
