<?php
include "mail.php";
$error="";
// $freelancer_id= 1;
// $total_price= 50;

if(isset($_GET['pid'])){
    $project_id=$_GET['pid'];
    $user_id=$_SESSION['user_id'];
    if(isset($_GET['fi'])){
        $freelancer_id=$_GET['fi'];
        $select = "SELECT * FROM `user` WHERE `user_id` = $user_id";
        $runselect = mysqli_query($connect, $select);
        $data = mysqli_fetch_assoc($runselect);
        
if(isset($_POST['pay'])) {
    $card_number = $_POST['card_number'];
    $request_id=$_GET['pay'];
    $total_price=$_SESSION['total_price'];


    if (strlen($card_number) != 16) {
        $error = TRUE;
        $error_message = "Invalid Card Number";
    }

    $insert = "INSERT INTO `team_member` VALUES (NULL, 'in progress', $freelancer_id, $project_id)";
    $runinsert = mysqli_query($connect, $insert);

    $insert2 = "INSERT INTO `payment` VALUES (NULL, $total_price, $user_id, $freelancer_id)";
    $runinsert2 = mysqli_query($connect, $insert2);

    if ($runinsert and $runinsert2) {
        $countT = "SELECT COUNT(*) as T_count FROM payment WHERE user_id = $user_id";
        $ExecCountT = mysqli_query($connect, $countT);
        $countRow = mysqli_fetch_assoc($ExecCountT);
        $T_count = $countRow['T_count'];
        if ($T_count % 5 == 0 && $T_count != 0) {
            $promo_code = rand(10000, 99999);
            $user_email = $data['email'];
            $user_name = $data['user_name'];
            $insert_promo = "INSERT INTO `promo`(`user_id`, `promo_code`, `used`) VALUES ($user_id, '$promo_code', 0)";
            $ExecInsertPromo = mysqli_query($connect, $insert_promo);
            if ($ExecInsertPromo) {
                $email_content =
                    "
                        <body>
                        <p>Dear $user_name,</p>
                        <p>Congratulations! You have received a promo code: $promo_code</p>
                        <p>Thank you for your continued support.</p>
                        </body>
                    ";
                global $mail; // addiction, force of habit
                $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
                $mail->addAddress($user_email);
                $mail->isHTML(true);
                $mail->Subject = 'You Received a Promo Code!';
                $mail->Body = $email_content;
                $mail->send();
            }
        }
        $select = "SELECT * FROM `team_member` WHERE `project_id` = '$project_id'";
        $runq = mysqli_query($connect, $select);
        if (mysqli_num_rows($runq) == 2) {
            $update = "UPDATE `project` SET `type_id` = 2 where `project_id` = '$project_id' ";
            $runupdate = mysqli_query($connect, $update);
            if ($runinsert and $runinsert2) {
                echo "done";
            }
        }
    }
}
    }}

if(isset($_GET['plan'])){
    if(isset($_POST['pay'])){
        $id_freelancer=$_SESSION['freelancer_id'];
        $plan_id=$_GET['plan'];
        $selectid = "SELECT `freelancer_id` FROM `subscription` WHERE `freelancer_id` ='$id_freelancer'";
        $runS = mysqli_query($connect, $selectid);
        $rows = mysqli_num_rows($runS);
        if ($rows > 0) {
           $errorid = "You are already on Premium";
           echo $errorid;
        } else{
        $select="SELECT * FROM `plan` WHERE `plan_id` = $plan_id";
        $runq=mysqli_query($connect, $select);
        $fetch=  mysqli_fetch_assoc($runq);
        $price= $fetch['price'];
        $start_date=date("Y-m-d");
        $enddate = date('Y-m-d', strtotime('+30 days'));
         $insertt3= "INSERT INTO `subscription` VALUES ('$plan_id', '$id_freelancer', 'active', '$start_date', '$enddate') ";
         $runinsertt3=mysqli_query($connect, $insertt3);
     
        }
    }}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css file link  -->
    <link rel="stylesheet" href="css/payment.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
<!-- start of visa card -->
    <div class="container">
        <div class="card-container">
           <div class="pic">
            <div class="front">
                <div class="image">
                    <img src="img/chip-card2 (1).png" alt="">
                    <img src="img/visa.png" alt="">
                </div>
                <div class="card-number-box" name="card_number" >################</div>
                <div class="flexbox">
                    <div class="box">
                        <span>Card Holder</span>
                        <div class="card-holder-name">Full Name</div>
                    </div>

                    <div class="box">
                        <span>expires</span>
                        <div class="expiration">
                            <span class="exp-month">mm</span>
                            <span class="exp-year">yy</span>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="back">
                <div class="stripe"></div>
                <div class="box">
                    <span>cvv</span>
                    <div class="cvv-box"></div>
                    <img src="image/visa.png" alt="">
                </div>
            </div>
        </div>
        
        <!-- <end part of visa card> -->
            
 
 <!-- start work space of inputs -->

        <form action="" method="post">
            <div class="inputBox">
                <span>card number</span>
                <input type="number"  name="card_number" class="card-number-input">
                <?php if ($error) { echo $error_message; } ?>
            </div>
            <div class="inputBox">
                <span>card holder</span>
                <input type="text" class="card-holder-input">
            </div>
            <div class="flexbox">
                <div class="inputBox">
                    <span>expiration mm</span>
                    <select name="" id="" class="month-input">
                        <option value="month" selected disabled>month</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>expiration yy</span>
                    <select name="" id="" class="year-input">
                        <option value="year" selected disabled>year</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>cvv</span>
                    <input type="text" maxlength="3" class="cvv-input">
                  
                </div>
                </div>
                
                <a class="promocode" id='showPromo'> Promo Code +</a>
                <div class="inputBox d-none" id="promoCode">
                    <input type="text" class="card-holder-input">
                </div>


                <div class="btns">
                    <button type="submit" class="cssbuttons-io-button addto" name="pay">
        Pay
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
    
<!-- <WORK space for js> -->


                        <script>

                            document.querySelector('.card-number-input').oninput = () => {
                                document.querySelector('.card-number-box').innerText = document.querySelector('.card-number-input').value;
                            }

                            document.querySelector('.card-holder-input').oninput = () => {
                                document.querySelector('.card-holder-name').innerText = document.querySelector('.card-holder-input').value;
                            }

                            document.querySelector('.month-input').oninput = () => {
                                document.querySelector('.exp-month').innerText = document.querySelector('.month-input').value;
                            }

                            document.querySelector('.year-input').oninput = () => {
                                document.querySelector('.exp-year').innerText = document.querySelector('.year-input').value;
                            }

                            document.querySelector('.cvv-input').onmouseenter = () => {
                                document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(-180deg)';
                                document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(0deg)';
                            }

                            document.querySelector('.cvv-input').onmouseleave = () => {
                                document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(0deg)';
                                document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(180deg)';
                            }

                            document.querySelector('.cvv-input').oninput = () => {
                                document.querySelector('.cvv-box').innerText = document.querySelector('.cvv-input').value;
                            }

                        </script>



<!-- <end of work space for js> -->



</body>

</html>