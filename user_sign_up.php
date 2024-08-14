<?php
include 'mail.php';
$error="";
if(isset($_POST['submit'])){
    $name=mysqli_real_escape_string($connect,$_POST['user_name']);
    $email=mysqli_real_escape_string($connect,$_POST['email']);
    $phone=mysqli_real_escape_string($connect,$_POST['phone_number']);
    $password=mysqli_real_escape_string($connect,$_POST['password']);
    $confirm_pass=mysqli_real_escape_string($connect,$_POST['confirm_pass']);
    $passwordhashing=password_hash($password , PASSWORD_DEFAULT);
    $nationality=mysqli_real_escape_string($connect,$_POST['nationality']);
    $lowercase=preg_match('@[a-z]@',$password);
    $uppercase=preg_match('@[A-Z]@',$password);
    $numbers=preg_match('@[0-9]@',$password);
    $select="SELECT * FROM `user` WHERE `email` ='$email' ";
    $run_select=mysqli_query($connect,$select);
    $rows=mysqli_num_rows($run_select);
    
    if($rows>0){
        $error= "this email is already taken";
    }elseif
    ($lowercase<1 || $uppercase <1 ||   $numbers<1){
       $error= "password must contain at least 1 uppercase , 1 lowercase and number";
    }elseif
    ($password !=$confirm_pass){
        $error= "password doesn't match confirmed password";
    }elseif (strlen($phone)!=11){ // >>> 11 DOESN'T COVER ALL Arab countries <<<
        $error= "please enter a valid phone number";
    }elseif (empty($_POST['CHK-TOS'])){
        $error= "You must read and accept TOS";
    }else{
        $rand=rand(10000,99999);
        $_SESSION['rand']=$rand;
        $_SESSION['user_name']=$name;
        $_SESSION['email']=$email;
        $_SESSION['phone_number']=$phone;
        $_SESSION['password'] = $passwordhashing;
        $_SESSION['nationality']=$nationality;
        $_SESSION['time'] = time(); // we start calc'ing from this point
        $massage=" your otp is $rand"; // FRONT NEEDED
        $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
        $mail->addAddress($email);      
        $mail->isHTML(true);                               
        $mail->Subject = 'Account Activation code';
        $mail->Body=($massage);                 
        $mail->send(); 
        header("Location: otpuser.php");
    }
}
$select_nationality = "SELECT * FROM `nationality`";
$run_select_nationality = mysqli_query($connect, $select_nationality);
?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!----link bootsrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- link css -->
  <link rel='stylesheet' type='text/css' media="screen" href="css/clSignup.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <title>client Sign-up</title>
</head>

<body>

  <div class="container-main">

    <div class="wrapper">    
      <a href="" class="close"><i class="fa-solid fa-x "></i></a>

      <div class="from-wraapper  Sign-in">
        <form method="post">
          <h2>Client Sign-Up</h2>


          <div class="input-group">
            <input type="text" required name="user_name">
            <label for="">Name</label>
          </div>


          <div class="input-group">
            <input type="email" required name="email">
            <label for="">Email</label>
          </div>

          <div class="input-group">
              <input type="number" required name="phone_number" >
              <label for="">Phone Number</label>
          </div>

          <div class="input-group">
            
          <select name="nationality" id="nationality">
                    <?php foreach ($run_select_nationality as $data) { ?>
                      <option value="" disabled selected hidden> Nationality </option>
                     <option value="<?php echo $data['nationality_id']; ?>"><?php echo $data['nationality']; ?></option>
                    <?php } ?>
                     </select>
                     <label for="" ></label>

                   
   
          
          </div>
          <div class="input-group">
            <input type="password" required name="password">
            <label for="">Password</label>
          </div>
          <div class="input-group">
            <input type="password" required name="confirm_pass">
            <label for="">Confirm Password</label>
          </div>
        </div>
        
        <div class="terms">
          <!-- <input type="checkbox" id="terms" name="termsandconditions" value="Terms" class="terms"> -->
          <input class="form-check-input" type="checkbox" value="1" name="CHK-TOS" id="flexCheckDefault" required>
          <label class="form-check-label ms-2" for="flexCheckDefault">
            Terms and Conditions
          </label>
    
        
          <!-- <p class="c">Terms and Conditions</p> -->
           
          
        </div>
        <br>
<?php if(!empty($error)) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo $error ?>
                </div>
            <?php } ?>
          
        <div class="buttons ">
   <button name="submit" class="cssbuttons-io-button">Get started
      <!-- <a href="#">Get started</a> -->
      <div class="icon">
          <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path
                  d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                  fill="currentColor"></path>
          </svg>
      </div>
  </button>
  </div>

      <!-- <div class="signUp-link">
        <a class="Already" href="login_client.php">Already have an account?</a>
        <p> <a href="user_sign_up.php" class="signUpBtn-link">signup</a> </p>

      </div> -->
      </form>
    </div>
  </div>


  <script src="main.js"></script>
</body>

</html>







