<?php
session_start(); // Ensure session is started

include("db.conn.php");

if(isset($_SESSION['user_id'])){
    $id_1 = $_SESSION['user_id'];
    
    $sql = "SELECT * FROM chat WHERE user_id = ? AND star = 1 ORDER BY chat_id ASC";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([$id_1]);
        $chats = $stmt->fetchAll();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        $chats = [];
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Starred Messages</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container mt-5">
            <h2>Starred Messages</h2>
            <?php if (!empty($chats)) { ?>
                <ul class="list-group">
                    <?php foreach ($chats as $chat) { ?>
                        <li class="list-group-item">
                            <p class="ltext border rounded p-2 mb-1">
                                <?= htmlspecialchars($chat['message']) ?> 
                                <small class="d-block">
                                    <?= $chat['created_at'] ?>
                                </small>      
                            </p>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <div class="alert alert-info text-center">
                    <i class="fa fa-comments d-block fs-big"></i>
                    No starred messages yet.
                </div>
            <?php } ?>
            <a href="home.php" class="btn btn-secondary mt-3">Back to Chat</a>
        </div>
    </body>
    </html>
    <?php
} else {
    header("Location: index.php");
    exit;
}
?>
