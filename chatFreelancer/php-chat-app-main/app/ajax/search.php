<?php

session_start();
  	include '../db.conn.php';

  	include '../helpers/user.php';
    $user = getUser($_SESSION['username'], $conn);
    $user_id= $user['user_id'];

# check if the user is logged in
if (isset($_SESSION['username'])) {
	
    # check if the key is submitted
    if(isset($_POST['key'])){
       # database connection file
	   include '../db.conn.php';

	   # creating simple search algorithm :) 
	   $key = "%{$_POST['key']}%";
     
	   $sql = "SELECT * FROM payment join `freelancer` on freelancer.freelancer_id=payment.freelancer_id
	           WHERE user_id=? and freelancer_name like ?";
       $stmt = $conn->prepare($sql);
       $stmt->execute([$user_id,$key]);
echo $user_id;
echo $key;
       if($stmt->rowCount() > 0){ 
         $users = $stmt->fetchAll();

         foreach ($users as $user) {
         	if ($user['user_id'] != $_SESSION['user_id']) continue;
       ?>
       <li class="list-group-item">
		<a href="chat.php?freelancer=<?=$user['freelancer_id']?>"
		   class="d-flex
		          justify-content-between
		          align-items-center p-2">
			<div class="d-flex
			            align-items-center">

			    <img src="uploads/"
			         class="w-10 rounded-circle">

			    <h3 class="fs-xs m-2">
			    	<?=$user['freelancer_name']?>
			    </h3>            	
			</div>
		 </a>
	   </li>
       <?php } }else { ?>
         <div class="alert alert-info 
    				 text-center">
		   <i class="fa fa-user-times d-block fs-big"></i>
           The user "<?=htmlspecialchars($_POST['key'])?>"
           is  not found.
		</div>
    <?php }
    }

}else {
	header("Location: ../../index.php");
	exit;
}