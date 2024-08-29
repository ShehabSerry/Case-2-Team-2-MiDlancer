<?php
include ("connection.php");
$error="";
$id = $_SESSION['freelancer_id'];


$select="SELECT * FROM `freelancer` WHERE `freelancer_id` = '$id'";
    $run_select=mysqli_query($connect,$select);
    $fetch=mysqli_fetch_assoc($run_select);
    $fetcholdpass=$fetch['password'];
  
    if(isset($_POST['edit'])){
        $old_password=htmlspecialchars(strip_tags($_POST['old_password']));
        $new_password=htmlspecialchars(strip_tags(mysqli_real_escape_string($_POST['new_password'])));
        $confirm_password=htmlspecialchars(strip_tags($_POST['confirm_password']));
        if(password_verify($old_password,$fetcholdpass)){
            //if(($old_password==$fetcholdpass)){
            if($new_password == $confirm_password){
                $new_hashed=password_hash($new_password,PASSWORD_DEFAULT);
                $update="UPDATE `freelancer` SET `password`='$new_hashed' WHERE `freelancer_id`=$id";
                $run_update=mysqli_query($connect,$update);

                header("location:login_freelancer.php ");
            }else {
                $error = "New password doesn't match confirm password";
            } 
        }else{
            $error= "Old password is wrong";
        }
    
    }





?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!----link bootsrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <!-- link css -->
  <link rel='stylesheet' type='text/css' media="screen" href="css/changepassword.css" />
  <title>Change Password</title>
  <style>
     body{
  background-image:url(img/bhimg.jpg);
  background-size: cover;
  background-repeat: no-repeat; 
}

    </style>
</head>

<body>

  <div class="background">
    <div class="container-main">
      <div class="wrapper">
        <a href="FREELANCERPROFILE.php" class="close"><i class="fa-solid fa-x "></i></a>
        <div class="from-wraapper  Sign-in">
          <form method="post">
            <h2>Change Password</h2>

            <div class="input-group">
              <input type="password" required name="old_password">
              <label for="">Old Password</label>
            </div>

            <div class="input-group">
              <input type="password" required name="new_password">
              <label for="">New Password</label>
            </div>


            <div class="input-group">
              <input type="password" required name="confirm_password">
              <label for="">Confirm New Password</label>
            </div>

            <?php   
          if($error){
            ?> <div class="alert alert-warning" role="alert"> 
              <?php
            echo $error;
            ?> </div>
          <?php } ?>
        </div>
        

        <div class="btns">
          <div class="buttons">
            <button class="cssbuttons-io-button addto" name="edit">
              <a href="#">Update Profile</a>
              <div class="icon">
                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                    fill="currentColor"></path>
                </svg>
              </div>
            </button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  <script src="main.js"></script>
  <script>
 document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const oldPasswordInput = document.querySelector('input[name="old_password"]');
    const newPasswordInput = document.querySelector('input[name="new_password"]');
    const confirmPasswordInput = document.querySelector('input[name="confirm_password"]');

    const oldPasswordError = document.createElement('div');
    const newPasswordError = document.createElement('div');
    const confirmPasswordError = document.createElement('div');

    oldPasswordError.className = 'error-message';
    newPasswordError.className = 'error-message';
    confirmPasswordError.className = 'error-message';

    oldPasswordInput.parentNode.insertBefore(oldPasswordError, oldPasswordInput.nextSibling);
    newPasswordInput.parentNode.insertBefore(newPasswordError, newPasswordInput.nextSibling);
    confirmPasswordInput.parentNode.insertBefore(confirmPasswordError, confirmPasswordInput.nextSibling);

    function validateField() {
        const oldPassword = oldPasswordInput.value.trim();
        const newPassword = newPasswordInput.value.trim();
        const confirmPassword = confirmPasswordInput.value.trim();
        let valid = true;

        oldPasswordError.textContent = '';
        newPasswordError.textContent = '';
        confirmPasswordError.textContent = '';

        const uppercase = /[A-Z]/.test(newPassword);
        const lowercase = /[a-z]/.test(newPassword);
        const number = /[0-9]/.test(newPassword);
        const specialCharacter = /[^a-zA-Z0-9]/.test(newPassword);

        if (!oldPassword) {
            oldPasswordError.textContent = 'Old password is required';
            valid = false;
        }
        if (!newPassword) {
            newPasswordError.textContent = 'New password is required';
            valid = false;
        } else if (!uppercase || !lowercase || !number || !specialCharacter) {
            newPasswordError.textContent = 'Password must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special character.';
            valid = false;
        }
        if (!confirmPassword) {
            confirmPasswordError.textContent = 'Confirm password is required';
            valid = false;
        } else if (newPassword !== confirmPassword) {
            confirmPasswordError.textContent = "New password doesn't match confirm password";
            valid = false;
        }

        return valid;
    }

    oldPasswordInput.addEventListener('blur', validateField);
    newPasswordInput.addEventListener('blur', validateField);
    confirmPasswordInput.addEventListener('blur', validateField);

    oldPasswordInput.addEventListener('input', validateField);
    newPasswordInput.addEventListener('input', validateField);
    confirmPasswordInput.addEventListener('input', validateField);

    form.addEventListener('submit', function (event) {
        if (!validateField()) {
            event.preventDefault();
        }
    });
});

</script>
</body>

</html>