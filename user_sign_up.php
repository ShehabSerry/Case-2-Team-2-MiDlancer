<?php
include("connection.php");
if(isset($_POST['submit'])){
    $name=$_POST['user_name'];
    $email=$_POST['email'];
    $phone=$_POST['phone_number'];
    $password=$_POST['password'];
    $confirm_pass=$_POST['confirm_pass'];
    $passwordhashing=password_hash($password , PASSWORD_DEFAULT);
    $nationality=$_POST['nationality']; // any other than EG
    $lowercase=preg_match('@[a-z]@',$password);
    $uppercase=preg_match('@[A-Z]@',$password);
    $numbers=preg_match('@[0-9]@',$password);
    $select="SELECT * FROM `user` WHERE `email` ='$email' ";
    $run_select=mysqli_query($connect,$select);
    $rows=mysqli_num_rows($run_select);
    
    if($rows>0){
        echo"this email is already taken";
    }else if ($lowercase<1 || $uppercase <1 ||   $numbers<1){
        echo"password must contain at least 1 uppercase , 1 lowercase and number";
    }else if($password !=$confirm_pass){
        echo "password doesn't match confirmed password";
    }else if(strlen($phone)>15){ // ALGERIAN COULD BE 15 upper limit?
        echo"please enter a valid phone number";
    }else if (!isset($_POST['checkbox']))
    {
        echo"please confirm that you've read the TOS";
    }
    else
    {
        $insert="INSERT INTO `user` VALUES(NULL,'$name','$email','$phone','$passwordhashing','defaultprofile.png',NULL,'$nationality')";
        $run_insert=mysqli_query($connect,$insert);
        // echo "data added succesfully";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <title>Signup!</title>
</head>

<body>

                <h1 >Sign Up</h1>

                
                    <form method="POST" >
                    <input  type="text" placeholder="User Name"  name="user_name" required>
                    <br>
                    <input  type="text" placeholder="Email"name="email" required>
                    <br>
                    <input  type="number" placeholder="Phone" name="phone_number" required>

                    <br>
                    <label for="nationality">Nationality</label>
                    <select name="nationality" id="nationality">
                        <?php
                        $getNat = "SELECT * FROM `nationality`";
                        $ExecNat = mysqli_query($connect, $getNat);

                        foreach($ExecNat as $data){
                        ?>

                        <option value="<?php echo $data['nationality_id']?>"><?php echo $data['nationality']?></option>--> <!-- KEEP OR NOT TO KEEP-->
<!--                        <option value="2">Saudi</option>-->
<!--                        <option value="3">Emirati</option>-->
<!--                        <option value="4">Lebanese</option>-->
<!--                        <option value="5">Moroccan</option>--> <!--IMPORTED INTO DB-->
<!--                        <option value="6">Syrian</option>-->
<!--                        <option value="7">Iraqi</option>-->
<!--                        <option value="8">Tunisian</option>-->
<!--                        <option value="9">Qatari</option>-->
<!--                        <option value="10">Kuwaiti</option>-->
<!--                        <option value="11">Omani</option>-->
<!--                        <option value="12">Libyan</option>-->
<!--                        <option value="13">Sudanese</option>-->
<!--                        <option value="14">Yemeni</option>-->
<!--                        <option value="15">Palestinian</option>-->
<!--                        <option value="16">Somali</option>-->
<!--                        <option value="17">Mauritanian</option>-->
<!--                        <option value="18">Comorian</option>-->
<!--                        <option value="19">Bahraini</option>-->
<!--                        <option value="20">Jordanian</option>-->
<!--                        <option value="21">Algerian</option>-->
<!--                        <option value="22">Djiboutian</option>-->
                        <?php } ?>
                    </select>
                    <br>
                    
                    
                        <input id="password" type="password" placeholder="Password" name="password" required > <br>
                        <input id="password" type="password" placeholder="confirm Password" required name="confirm_pass" >

                    <br>
                    <input type="checkbox" id="checkbox" name="checkbox" value="terms" required>
<label for="checkbox"> I accept all terms and conditions</label><br>
                
                    <button  name="submit" type="submit">Sign Up</button>
                </form>
                <p>Already have account <a href="login_client.php">Log in?</a>
                </p>
</form>
</body>

</html>