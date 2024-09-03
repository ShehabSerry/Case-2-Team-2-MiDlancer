<?php 

function opened($id_1, $conn, $chats){
    foreach ($chats as $chat) {
    	if ($chat['opened'] == 0) {
    		$opened = 1;
    		$chat_id = $chat['chat_id'];

    		$sql = "UPDATE chat
    		        SET   opened = ?
    		        WHERE user_id=? 
    		        AND   chat_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$opened, $id_1, $chat_id]);

    	}
    }
}