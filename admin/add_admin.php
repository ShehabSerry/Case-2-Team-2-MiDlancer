<?php
include("connection.php");

if(isset($_POST['submit'])){
    $name=mysqli_real_escape_string($connect,$_POST['name']);
    $email=mysqli_real_escape_string($connect,$_POST['email']);
    $passwordhashing=password_hash("Aa.123" , PASSWORD_DEFAULT);
    $select="SELECT * FROM `admin` WHERE `email` ='$email' ";
    $run_select=mysqli_query($connect,$select);
    $rows=mysqli_num_rows($run_select);
    
    if($rows>0){
        $error= "this email is already taken";}
        else{
            $insert="INSERT INTO `admin` VALUES(NULL,'$name','$email','$passwordhashing')";
            $run_insert=mysqli_query($connect,$insert);
              header("Location: display_admins.php");
          }
      }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
    <div class="input-group">
            <input type="text" required name="name">
            <label for="">Name</label>
          </div>


          <div class="input-group">
            <input type="email" required name="email">
            <label for="">Email</label>
          </div>

<button type="submit" name="submit">Add </button>

    </form>
</body>
</html>
