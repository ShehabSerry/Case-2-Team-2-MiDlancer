<?php 

function getConversation($user_id, $conn){
    /**
      Getting all the conversations 
      for the current (logged-in) user
    **/
    $sql = "SELECT * FROM conversations 
             JOIN freelancer ON freelancer.freelancer_id = conversations.user_1
            WHERE conversations.user_2 = ?
            ORDER BY conversation_id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    if ($stmt->rowCount() > 0) {
        $user_data = [];

        // Fetch each conversation row one by one
        while ($conversation = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Push each conversation as a separate entry into $user_data
            $user_data[] = $conversation;
        }

        return $user_data;
    } else {
        return [];
    }
}

