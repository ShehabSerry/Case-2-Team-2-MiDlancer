<?php 
session_start();
// $_SESSION['freelancer_name'] = 'Anna. ';
$freelancer_id=$_SESSION['freelancer_id'];

  if (isset($_SESSION['freelancer_id'])) {
  	# database connection file
  	include 'app/db.conn.php';

  	include 'app/helpers/user.php';
  	include 'app/helpers/conversations.php';
    include 'app/helpers/timeAgo.php';
    include 'app/helpers/last_chat.php';
    include 'app/helpers/chat.php';
  	include 'app/helpers/opened.php';
    # Getting User data data
    $user = getFree($_SESSION['freelancer_id'], $conn);
    
    # Getting User conversations
    $conversations = getConversation($user['freelancer_id'], $conn);
    


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chat App - Home</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" 
	      href="css/style.css">
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


	<style>
			.popup {
    display: none;
    width: 25%;
    background-color: #86b7fe;
    position: absolute;
    bottom: 35%;
    left: 48%;
}
.popup h3{
	text-align: center;
}
.btn-primary {
    /* color: #fff; */
    /* background-color: #0d6efd; */
    /* border-color: #0d6efd; */
    border-radius: 15px;
    background-color: #080a74;
    margin-top: 2%;
    padding: 12px;
    text-decoration: none;
    color: white;
    transition: all 0.5s ease;
}
.popup.show {
    display: block;
}

	</style>

	<script type="text/javascript">
		function chkalert(chat_id,user_id){
			sts= confirm("Are you sure you want to delete this message?");
			if(sts){
				document.location.href='delete_message.php?delete='+chat_id+ "&" + 'user=' +user_id;
				return true;
			}
		}
		function openEditPopup(chat_id, message) {
			document.getElementById('edit-popup-' + chat_id).classList.add('show');
			document.getElementById('edit-message-' + chat_id).value = message;
		}
		function closeEditPopup(chat_id) {
    		document.getElementById('edit-popup-' + chat_id).classList.remove('show');
		}
	function save(chat_id, user_id){
    // $('.edit-popup form').submit(function(event) {
        var form = document.querySelector('#edit-popup-' + chat_id + ' form');
    	var message = form.querySelector('textarea').value;
        $.ajax({
            type: 'POST',
            url: 'edit_message.php',
            data: { chat_id: chat_id, user_id: user_id, message: message },
            success: function(data) {
                // Update the message in the chat box
                $('#chatBox').append(data);
                scrollDown();
				document.location.href='home.php?user=' +user_id;
				closeEditPopup(chat_id)
            }
        });
    };
	function star(chatF, user_id){
		// $("button").click(function() {
		// 	var star = $("button").val();
		// 	// alert(fired_button);
		// 	console.log("help");
		// });
		$.ajax({
            type: 'POST',
            url: 'edit_message.php',
            data: { chat_id: chatF, user_id: user_id, star: true},
            success: function(data) {
				console.log("Star action was successful");
            // Example of handling the success, you may need to update UI or alert user
            	// alert("Message starred successfully!");
				document.location.href='home.php?user=' +user_id;
            },
        	error: function(xhr, status, error) {
            console.error("Error in star action:", status, error);
        }
        });
	}
	function unstar(chatF, user_id){
		// $("button").click(function() {
		// 	var star = $("button").val();
		// 	// alert(fired_button);
		// 	console.log("help");
		// });
		$.ajax({
            type: 'POST',
            url: 'edit_message.php',
            data: { chat_id: chatF, user_id: user_id, unstar: true},
            success: function(data) {
				console.log("Star action was successful");
            // Example of handling the success, you may need to update UI or alert user
            	// alert("Message unstarred successfully!");
				document.location.href='home.php?user=' +user_id;
            },
        	error: function(xhr, status, error) {
            console.error("Error in unstar action:", status, error);
        }
        });
	}

	
	</script>
</head>
<body class="d-flex
             justify-content-center
             align-items-center
             vh-100">
    <div class="p-2 w-350
                rounded shadow">
    	<div>
    		<div class="d-flex
    		            mb-3 p-3 bg-light
			            justify-content-between
			            align-items-center">
    			<div class="d-flex
    			            align-items-center">
    			    <!-- <img src="uploads/"
    			         class="w-25 rounded-circle"> -->
                    <h3 class="fs-xs m-2"><?=$user['freelancer_name']?></h3> 
    			</div>
    			<a href="home.php?star=1"
    			   class="btn btn-dark">Starred</a>
    		</div>

    		<div class="input-group mb-3">
    			<input type="text"
    			       placeholder="Search..."
    			       id="searchText"
    			       class="form-control">
    			<button class="btn btn-primary" 
    			        id="serachBtn">
    			        <i class="fa fa-search"></i>	
    			</button>       
    		</div>
    		<ul id="chatList"
    		    class="list-group mvh-50 overflow-auto">
    			<?php if (!empty($conversations)) { ?>
    			    <?php 

    			    foreach ($conversations as $conversation){ ?>
			    
	    			<li class="list-group-item">
	    				<a href="home.php?user=<?=$conversation['user_2']?>"
	    				   class="d-flex
	    				          justify-content-between
	    				          align-items-center p-2">
	    					<div class="d-flex
	    					            align-items-center">
	    					    <!-- <img src="uploads/"
	    					         class="w-10 rounded-circle"> -->
	    					    <h3 class="fs-xs m-2">
	    					    	<?=$conversation['user_name']?>
							<br>
                      <small>
                        <?php 
                        	$lastChatMessage= lastChat($_SESSION['freelancer_id'],$conversation['user_id'], $conn);
							$trimmedMessage = substr(trim($lastChatMessage), 0, 25); 
                        	echo $trimmedMessage . (strlen($lastChatMessage) > 25 ? '...' : '');
                        ?>
                      </small>
	    					    </h3>            	
	    					</div>
	    					<?php if (last_seen($conversation['last_seen']) == "Active") { ?>
		    					<div title="online">
		    						<div class="online"></div>
		    					</div>
	    					<?php } ?>
	    				</a>
	    			</li>
    			    <?php } ?>
    			<?php }else{ ?>
				
    				<div class="alert alert-info 
    				            text-center">
					   <i class="fa fa-comments d-block fs-big"></i>
                       No messages yet, Start the conversation
					</div>
    			<?php } ?>
    		</ul>
    	</div>
    </div>
	<?php  if(isset($_GET['user'])){
    # Getting User data data
  	$chatWith = getUser($_GET['user'], $conn);

  	if (empty($chatWith)) {
  		header("Location: home.php");
  		exit;
  	}

  	$chats = getChats($_SESSION['freelancer_id'],$chatWith['user_id'],  $conn);

  	opened($chatWith['user_id'], $conn, $chats);
    };
?>
<?php if(isset($_GET['user'])){?>
    <div class="w-400 shadow p-4 rounded">
    	<a href="home.php"
    	   class="fs-4 link-dark">&#8592;</a>

    	   <div class="d-flex align-items-center">
    	   	  <!-- <img src="uploads/"
    	   	       class="w-15 rounded-circle"> -->

               <h3 class="display-4 fs-sm m-2">
               	  <?=$chatWith['user_name']?> <br>
               	  <div class="d-flex
               	              align-items-center"
               	        title="online">
               	    <?php
                        if (last_seen($chatWith['last_seen']) == "Active") {
               	    ?>
               	        <div class="online"></div>
               	        <small class="d-block p-1">Online</small>
               	  	<?php }else{ ?>
               	         <small class="d-block p-1">
               	         	Last seen:
               	         	<?=last_seen($chatWith['last_seen'])?>
               	         </small>
               	  	<?php } ?>
               	  </div>
               </h3>
    	   </div>

    	   <div class="shadow p-4 rounded
    	               d-flex flex-column
    	               mt-2 chat-box"
    	        id="chatBox">
    	        <?php 
                     if (!empty($chats)) {
						 foreach($chats as $chat){
							 if(($chat['freelancer_id'] == $_SESSION['freelancer_id']) && ($chat['type']==0))
							 { ?>
						<?php $chat_id=$chat['chat_id'];
						// echo $chat_id=$chat['chat_id'];
						$user_id=$chat['user_id'];
						?>
						<div class="yousab">
							<p class="rtext align-self-end
							border mb-1" id="farah">
							<?=$chat['message']?>
							<?php // echo 4; ?>
							<small class="d-block">
								<?=$chat['created_at']?>
							</small>  
							<div class="dropdown d-inline">
								<button class="fa-solid fa-ellipsis-vertical" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
									<li><a class="dropdown-item" href="javascript:void()" onClick="chkalert(<?php echo $chat_id?>,<?php echo $user_id;?>)" >Delete</a></li>
									<li><a class="dropdown-item" href="javascript:void()" onClick="openEditPopup(<?php echo $chat_id?>,<?php echo $chat['message']?>)" >Edit</a></li>
	
								</ul>
							</div>
							<!-- heya de gw ael 3 dots -->
							<!-- <a href="javascript:void()" onClick="chkalert(<?php echo $chat_id?>,<?php echo $user_id;?>)">delete</a>
							<a href="javascript:void()" onClick="openEditPopup(<?php echo $chat_id?>, '<?php echo $chat['message']?>')">edit</a> -->
							<div class="popup edit-popup" id="edit-popup-<?php echo $chat_id?>">
								<!--heya dehhhhhhhh 3 dots el -->
							<h3>Edit Message</h3>
								<form onsubmit="event.preventDefault(); save(<?php echo $chat_id?>, <?php echo $user_id?>);">
									<textarea id="edit-message-<?php echo $chat_id?>" class="form-control"><?php echo $chat['message']?></textarea>
									<button type="submit" class="btn btn-primary">Save</button>
									<button type="button" class="btn btn-secondary" onClick="closeEditPopup(<?php echo $chat_id?>)">Cancel</button>
								</form>
							</div>
							<!-- <a href="edit_delete_message.php?delete=<?php // echo $chat_id; ?>">delete</a> -->
							  	
						</p>
						</div>
                    <?php }elseif($chat['type']==1){ ?>
						<?php $chatF=$chat['chat_id']?>
						<div class="tarek">
					<p class="ltext border 
					         rounded mb-1" id="malak">
							 <?=$chat['message']?> 
							 
					    <small class="d-block">
					    	<?=$chat['created_at']?>
							<?php if($chat['star'] == 0){?>
							 	<button onClick="star(<?php echo $chatF;?>, <?php echo $user_id; ?>)"><i class="fa-regular fa-star" style="color:#ffc100"></i></button>
							 <?php }elseif($chat['star']== 1){?>
								<button onClick="unstar(<?php echo $chatF;?>, <?php echo $user_id; ?>)"><i class="fa-solid fa-star" style="color:#ffc100"></i></button>
							<?php } ?>	
					    </small>      	
					</p>
					</div>
                    <?php } 
                     }	
    	        }else{ ?>
               <div class="alert alert-info 
    				            text-center">
				   <i class="fa fa-comments d-block fs-big"></i>
	               No messages yet, Start the conversation
			   </div>
    	   	<?php } ?>
    	   </div>
    	   <div class="input-group mb-3">
								<textarea cols="3"
										  id="message"
										  class="form-control"></textarea>
								
								<button class="btn btn-primary"
										id="sendBtn">
									  <i class="fa fa-paper-plane"></i>
								</button>
    	   </div>

    </div>
 


<?php }elseif(isset($_GET['star'])){ ?>
<?php 
if(isset($_SESSION['freelancer_id']) && isset($_GET['star'])){
    $id_1 = $_SESSION['freelancer_id'];
    
    $sql = "SELECT * FROM chat WHERE freelancer_id = ? AND `star` = 1 AND `type` = 1 ORDER BY chat_id DESC";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([$id_1]);
        $chats = $stmt->fetchAll();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        $chats = [];
    }
 
 
 $localhost= "localhost";
	$username= "root";
	$password= "";
	$database= "case2";
	
	$connect=mysqli_connect($localhost,$username,$password,$database);
	$selectNum="SELECT * FROM chat where type=0 and star=1 and freelancer_id=$freelancer_id";
	$RunSelect=mysqli_query($connect, $selectNum);
	$numRows=mysqli_num_rows($RunSelect);
 ?>
 
                 <div class="w-400 shadow p-4 rounded ">
					<div class="d-flex align-items-center " style="font-size: 24px; color: #0804a7;"> Hello, MR. you have <?php echo $numRows?> starred messages </div>
					<div class="shadow p-4 rounded d-flex flex-column mt-2 chat-box" >
                     <?php foreach ($chats as $chat) { ?>

	<div class="tarek">
					<p class="ltext border 
					         rounded mb-1" id="malak">
							 <?=$chat['message']?> 
							 
					    <small class="d-block">
					    	<?=$chat['created_at']?>
							<?php if($chat['star'] == 0){?>
							 	<button onClick="star(<?php echo $chatF;?>, <?php echo $user_id; ?>)"><i class="fa-regular fa-star" style="color:#ffc100"></i></button>
							 <?php }elseif($chat['star']== 1){?>
								<button onClick="unstar(<?php echo $chatF;?>, <?php echo $user_id; ?>)"><i class="fa-solid fa-star" style="color:#ffc100"></i></button>
							<?php } ?>	
					    </small>      	
					</p>
					</div>
					<?php } ?>
					</div>
					</div>
					
	<?php }} ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
	var scrollDown = function(){
        let chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
	}

	scrollDown();

	$(document).ready(function(){
      
      $("#sendBtn").on('click', function(){
      	var message = $("#message").val();
      	if (message == "") return;

      	$.post("app/ajax/insert.php",
      		   {
      		   	message: message,
      		   	user_id: <?=$chatWith['user_id']?>
      		   },
      		   function(data, status){
				if (status === "success") {
                var response = JSON.parse(data);
                
                if (response.error) {
                    console.error(response.error);
                } else {
                    $("#message").val("");

                    var newMessageHtml = `
					<div class="yousab">
							<p class="rtext align-self-end
							border mb-1" id="farah">
							    ${response.message}
							<small class="d-block">
								${response.created_at}
							</small>  
							<div class="dropdown d-inline">
								<button class="fa-solid fa-ellipsis-vertical" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
									<li><a class="dropdown-item" href="javascript:void()" onClick="chkalert(${response.chat_id}, ${response.freelancer_id})" >Delete</a></li>
									<li><a class="dropdown-item" href="javascript:void()" onClick="openEditPopup(${response.chat_id}, '${response.message}')" >Edit</a></li>
	
								</ul>
							</div>
							<div class="popup edit-popup" id="edit-popup-<?php echo $chat_id?>">
							<h3>Edit Message</h3>
								<form onsubmit="event.preventDefault(); save(${response.chat_id}, ${response.freelancer_id});">
									<textarea id="edit-message-${response.chat_id}" class="form-control">${response.message}</textarea>
									<button type="submit" class="btn btn-primary">Save</button>
									<button type="button" class="btn btn-secondary" onclick="closeEditPopup(${response.chat_id})">Cancel</button>
								</form>
							</div>
							  	
						</p>
						</div>
							`;
                    
                    $("#chatBox").append(newMessageHtml);
                    scrollDown();
                }};
			   });
      });

      /** 
      auto update last seen 
      for logged in user
      **/
      let lastSeenUpdate = function(){
      	$.get("app/ajax/update_last_seen.php");
      }
      lastSeenUpdate();
      /** 
      auto update last seen 
      every 10 sec
      **/
      setInterval(lastSeenUpdate, 10000);



      // auto refresh / reload
      let lastAppendedChatId = null;

	let fechData = function(){
		$.post("app/ajax/getMessage.php", 
			{
				id_2: <?=$chatWith['user_id']?>
			},
			function(data, status){
				if (data != "" && data.chat_id !== lastAppendedChatId) {
					$("#chatBox").append(data);
					lastAppendedChatId = data.chat_id;
					scrollDown();
				}
			},
			"json"
		);
	}


      fechData();
      /** 
      auto update last seen 
      every 0.5 sec
      **/
      setInterval(fechData, 500);
    
    });
	$(document).ready(function(){
      
      // Search
       $("#searchText").on("input", function(){
       	 var searchText = $(this).val();
         if(searchText == "") return;
         $.post('app/ajax/search.php', 
         	     {
         	     	key: searchText
         	     },
         	   function(data, status){
                  $("#chatList").html(data);
         	   });
       });

       // Search using the button
       $("#serachBtn").on("click", function(){
       	 var searchText = $("#searchText").val();
         if(searchText == "") return;
         $.post('app/ajax/search.php', 
         	     {
         	     	key: searchText
         	     },
         	   function(data, status){
                  $("#chatList").html(data);
         	   });
	
       });


      /** 
      auto update last seen 
      for logged in user
      **/
      let lastSeenUpdate = function(){
      	$.get("app/ajax/update_last_seen.php");
      }
      lastSeenUpdate();
      /** 
      auto update last seen 
      every 10 sec
      **/
      setInterval(lastSeenUpdate, 10000);

			});
			

		

    
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
  }else{
  	header("Location: index.php");
   	exit;
  }
 ?>