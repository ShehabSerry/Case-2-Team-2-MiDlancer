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
        <link rel="stylesheet" href="css/addadmin.css">

</head>
<body>
<div class="background">
    <div class="container-main">
      <div class="wrapper">
          <div class="from-wraapper  Sign-in">
          <form action="">
          <h2>Add Admin</h2>
      <a href="" class="close"><i class="fa-solid fa-x "></i></a>

          
          <div class="input-group">
              <input type="text" required>
              <label for="">Name</label>
          </div>
          
          
          <div class="input-group">
              <input type="email" required>
              <label for="">E-mail</label>
          </div> 

    </div>
   
  <div class="buttons">
    <button class="Btn">
Add
    </button>
  </div>
          <div class="signUp-link">
              <p> <a href="#" class="signUpBtn-link"></a> </p>
          </div>
          </form>
          </div>
          </div>
  </div>   
</div>
</body>
</html>
