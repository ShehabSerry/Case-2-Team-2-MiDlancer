<?php 

function getChats($id_1, $id_2, $conn){
   
   $sql = "SELECT * FROM chat
           WHERE (freelancer_id=? AND user_id=?)
           ORDER BY created_at ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_1, $id_2]);

    if ($stmt->rowCount() > 0) {
    	$chats = $stmt->fetchAll();
    	return $chats;
    }else {
    	$chats = [];
    	return $chats;
    }

}