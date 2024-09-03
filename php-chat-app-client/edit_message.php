<?php
include("db.conn.php");
if(isset($_POST['message'])){
$chat_id =$_POST['chat_id'];
$freelancer_id = $_POST['freelancer_id'];
$message= $_POST['message'];
$sql = "UPDATE chat
        SET message = ?
        WHERE chat_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$message,$chat_id]);
}elseif(isset($_POST["star"])){
        $star=1;
        $chat_id= $_POST["chat_id"];
        $sql1 = "UPDATE chat
        SET star = ?
        WHERE chat_id = ?";
        $stmt = $conn->prepare($sql1);
        $stmt->execute([$star,$chat_id]);
}elseif(isset($_POST["unstar"])){
        $star=0;
        $chat_id= $_POST["chat_id"];
        $sql1 = "UPDATE chat
        SET star = ?
        WHERE chat_id = ?";
        $stmt = $conn->prepare($sql1);
        $stmt->execute([$star,$chat_id]);
}
// header("location:home.php?freelancer=$freelancer_id");

// if($stmt->execute()){
//     echo 222;
// }
?>