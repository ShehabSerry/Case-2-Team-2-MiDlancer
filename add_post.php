<?php 
include 'connection.php';
$freelancer_id=$_SESSION['freelancer_id'] ;
$freelancer_name=$_SESSION['freelancer_name'];

// $user_id=$_SESSION['user_id'];

 $selectimage = "SELECT * FROM `freelancer` WHERE `freelancer_id`='$freelancer_id'";
 $runselectimage = mysqli_query($connect, $selectimage);
 $fetch=mysqli_fetch_assoc($runselectimage);
 $freelancer_image=$fetch['freelancer_image'];



 echo $freelancer_name ;
//  echo $freelancer_image ;



 
if(isset($_POST['submit'])){
    $description=mysqli_real_escape_string($connect,$_POST['description']);
    $file=$_FILES['file']['name'];
    
    
    
    $insert="INSERT INTO `experience` VALUES (Null,'$description',NULL,'$file',NULL,'$freelancer_id')";
    $run_insert=mysqli_query($connect,$insert);
    move_uploaded_file($_FILES['file']['tmp_name'],"image/".$_FILES['image']['name']);



    header("location:wall.php");



}




?>



<html>
<head>
    <title>Add post</title>
</head>

<body>
    <img src="./image/<?php echo ['freelancer_image'] ?>" width="100px">
<form method="post" enctype="multipart/form-data" >

<label for="text"> add description</label>
<input type="text" name="description"  id="description" >
<label for="file"> upload file</label>
<input type="file" name="file" id="file">
<button type="submit" name="submit"> done</button>

</body>
</form>

</html>