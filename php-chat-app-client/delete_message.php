
<?php
require_once 'db.conn.php';

$chat_id = $_GET['delete'];
$freelancer_id= $_GET['freelancer'];
$sql = "DELETE FROM chat
        WHERE chat_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$chat_id]);

if($stmt){
header("location:home.php?freelancer=$freelancer_id");
}
?>