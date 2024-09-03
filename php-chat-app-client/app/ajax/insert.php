<?php 
include '../db.conn.php';
session_start();
$_SESSION['username'] = 'badr';
$_SESSION['user_id'] =1;
# check if the user is logged in
if (isset($_SESSION['user_id'])) {

	if (isset($_POST['message']) &&
        isset($_POST['freelancer_id'])) {
	
	# database connection file

	# get data from XHR request and store them in var
	$message = $_POST['message'];
	$freelancer_id = $_POST['freelancer_id'];

	# get the logged in user's username from the SESSION
	$user_id = $_SESSION['user_id'];
	$date=date("Y-m-d H:i ");
	$sql = "INSERT INTO chat (`freelancer_id`,`user_id`,`message`,`created_at`,`type`)
	       VALUES (?, ?, ?,?,?)";
	$stmt = $conn->prepare($sql);
	$res  = $stmt->execute([$freelancer_id, $user_id, $message, $date, 1]);
    # if the message inserted
    if ($res) {
		$chat_id = $conn->lastInsertId(); # Get the last inserted ID
    	/**
       check if this is the first
       conversation between them
       **/
       $sql2 = "SELECT * FROM conversations
               WHERE (user_1=? AND user_2=?)
     ";
       $stmt2 = $conn->prepare($sql2);
	   $stmt2->execute([$freelancer_id, $user_id]);

	    // setting up the time Zone
		// It Depends on your location or your P.c settings
		// define('TIMEZONE', 'Africa/Cairo');
		// date_default_timezone_set(TIMEZONE);

		$time = date("Y-m-d H:i ");

		if ($stmt2->rowCount() == 0 ) {
			# insert them into conversations table 
			$sql3 = "INSERT INTO 
			         conversations(user_1, user_2)
			         VALUES (?,?)";
			$stmt3 = $conn->prepare($sql3); 
			$stmt3->execute([$freelancer_id, $user_id]);
		}
			// Prepare the response data
			$response = [
				'message' => $message,
				'chat_id' => $chat_id, // Retrieve the last inserted ID
				'freelancer_id' => $freelancer_id,
				'created_at' => $time
			];
		
			// Return the response as JSON
			echo json_encode($response);
		} else {
			// Handle the case where the insert failed
			echo json_encode(['error' => 'Failed to insert message.']);
		}
		
		
//     }else{echo "shit";}
//   }
// }else {
// 	header("Location: ../../index.php");
// 	exit;
}
}
?>