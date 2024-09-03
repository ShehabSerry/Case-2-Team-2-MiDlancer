<?php  

function getUser($username, $conn){
   $sql = "SELECT * FROM user
           WHERE user_name=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$username]);

   if ($stmt->rowCount() === 1) {
   	 $user = $stmt->fetch();
   	 return $user;
   }else {
   	$user = [];
   	return $user;
   }
}
function getFree($free_id, $conn){
   $sql = "SELECT * FROM freelancer
           WHERE freelancer_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$free_id]);

   if ($stmt->rowCount() === 1) {
   	 $free = $stmt->fetch();
   	 return $free;
   }else {
   	$free = [];
   	return $free;
   }
}