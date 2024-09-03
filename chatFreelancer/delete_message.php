
<?php
require_once 'db.conn.php';

$chat_id = $_GET['delete'];
$user_id= $_GET['user'];
$sql = "DELETE FROM chat
        WHERE chat_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$chat_id]);

if($stmt){
header("location:home.php?user=$user_id");
}
?>