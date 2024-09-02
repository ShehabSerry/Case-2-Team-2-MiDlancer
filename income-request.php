<?php
include 'mail.php';
$error="";
$freelancer_id=$_SESSION['freelancer_id'];
$popup1 = false;

$select="SELECT distinct * FROM `request` 
JOIN `project` ON `request`.`project_id` = `project`.`project_id` 
JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`. `freelancer_id` 
 JOIN `user` ON `project`.`user_id` = `user`.`user_id` 
 WHERE `request`.`status` = 'pending' AND `freelancer`.`freelancer_id` = $freelancer_id ";
// AND `project`.`project_id` = '$project_id' ";
$runselect=mysqli_query($connect, $select);
if (mysqli_num_rows($runselect) > 0) {
    $fetch = mysqli_fetch_assoc($runselect);
    $image=$fetch['user_image'];
    $price_per_hr = $fetch['price/hr'];
    $total_hours = $fetch['total_hours'];
        $total_price = $price_per_hr * $total_hours;}
        else{
            $error = true;
        }
// }
if (isset($_GET['accept'])) {
 
            $request_id = mysqli_real_escape_string($connect,$_GET['accept']);
            $update = "UPDATE `request` SET `status` = 'accept' WHERE `request_id` = $request_id";
            $runupdate = mysqli_query($connect, $update);
            if ($runupdate) {
              $popup1= true;

                $select ="SELECT 
                            `freelancer`.`email` AS 'freelancer_email',
                            `user`.`email` AS 'user_email',
                            `freelancer`.`freelancer_name` AS 'freelancer_name',
                            `user`.`user_name` AS 'user_name',
                            `project`.`project_name` AS 'project_name',
                            `project`.`description` AS 'description',
                            `project`.`type_id` AS 'type',
                            `project`.`deadline_date` AS 'deadline_date',
                            `freelancer`.`price/hr` AS 'price_per_hr',
                            
                            `project`.`total_hours` AS 'total_hours'
                           FROM `request` 
                           JOIN `project` ON `request`.`project_id` = `project`.`project_id`
                           JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`.`freelancer_id`
                           JOIN `user` ON `project`.`user_id` = `user`.`user_id`
                           WHERE `request`.`request_id` = '$request_id'";
    
                $runq = mysqli_query($connect, $select);
     
                if (mysqli_num_rows($runq) > 0) {
                   
                    $fetch = mysqli_fetch_assoc($runq);
                    $freelancer_name = $fetch['freelancer_name'];
                    $user_name = $fetch['user_name'];
                    $user_email = $fetch['user_email'];
                    $freelancer_email = $fetch['freelancer_email'];
                    $project_name = $fetch['project_name'];
                    $project_description = $fetch['description'];
                    $project_type = $fetch['type'];
                    $project_deadline = $fetch['deadline_date'];
                    $price_per_hr = $fetch['price_per_hr'];
                    $total_hours = $fetch['total_hours'];
                    $date=date("d-m-Y");
                    
                    $total_price = $price_per_hr * $total_hours;
                    
                    $message = "
                    <body>
                        <div class='main'>
                            <div class='head'>
                                <h1>MiDlancer</h1>
                                <h3>Contract</h3>
                            </div>
                            
                            <div class='first'>
                            <p>I undersigned, hereby acknowledge my comprehension and acceptance of the terms and conditions delineated below.</p>
                            </div>
                            <div class='fees'>
                                <h2> Fees & Deadline</h2>
                                <p>Payment of fees <span>$total_price</span> for <span>$project_name</span></p>
                                <p>Payment is expected to be rendered prior to the commencement of the project on <span>$date</span>, and the stipulated deadline for this project is <span>$project_deadline</span>.</p>
                            </div>
                            <div class='requirements'>
                                <h2>Client’s Requirements</h2>
                                <ul>
                                    <li>$project_name</li>
                                    <li>$project_description</li>
                                    <li>$total_hours hours</li>
                                </ul>
                                </div>
                                <div class='cancelation'>
                                <h2>Cancellation & Return or Delay</h2>
                                <ul>
                                <li>Cancellations must be made by passing <span>25%</span> of the whole duration.</li>
                                <li>If the cancellation happens after that, all the amount of money is returned to the client directly.</li>
                                <li>If the client wants to cancel the project, he has only <span>20%</span> of the duration to get back all his money. If he passes this period, he will not be able to get his money back.</li>
                                    <li>If the freelancer delays deadlines, it will lead to a reduction in his rate on the website.</li>
                                    <li>Any party that cancels before the approved time will be charged a <span>7%</span> (Half the commission) as a cancellation fee.</li>
                                    <li>If a cancellation is made after the agreed-upon cancellation deadline, the hours worked by the freelancer will be calculated and the amount due will be paid. A commission fee of <span>15%</span> will be deducted, and the client will receive the remaining amount.</li>
                                    <li>In terms of the freelancer, their rating will decrease, and there will be a penalty resulting in a ban that will be <span>between 1 day to 3 days</span>. Additionally, they will be subject to a fee of <span>7%</span> of the commission.</li>
                                    <li>Any cancellation after the approved time to cancel from any party will result in payment of half of the commission, which amounts to <span>7%</span>.</li>
                                </ul>
                            </div>
                            <div class='names'>
                            <div class='name'>
                            <h2>Client Name:<span$user_name</span></h2>
                                </div>
                                <div class='name2'>
                                    <h2>Freelancer Name:<span$freelancer_name</span></h2>
                                    </div>
                                    </div>
                                    <div class='signature'>
                                    <div class='client'>
                                    <h2 >Client Signature</h2>
                                    <p >$user_name</p>
                                </div>
                                <div class='freelancer'>
                                <h2 >Freelancer Signature</h2>
                                    <p >$freelancer_name</p>
                                </div>
                            </div>
                        </div>
                      <style>
        :root {
            --primary-color: #080a74;
            --secondary-color: #f6d673;
            --Thirdly-color: #d6d9e0;
            --fourthly-color: #1d1d27;
        }


        .main {
            width: 100%;
            /* height:100vh; */
            background-color: var(--Thirdly-color);
            color: var(--fourthly-color);
        }

        .head {
            width: 100%;
            height: 30%;
            background-color: #06085e;
            text-align: center;
            color: var(--Thirdly-color);
        }

        .main .head h1 {
            font-size: 70px;
            padding-top: 3%;
        }

        .main .head h3 {
            font-size: 50px;
            font-weight: 300;
        }

        .first {
            width: 100%;
            height: 10%;
            margin-top: 2%;
            /* background-color: blueviolet; */
        }

        .first p {
            font-size: 30px;
            padding: 0 8%;
        }

        .fees {
            width: 100%;
            height: 19%;
            /* background-color: bisque; */
            margin-top: 2%;
        }

        .fees h2 {
            padding: 0 6%;
            color: #06085e;

        }

        .fees p {
            font-size: 25px;
            padding-top: 8px;
            padding: 8px 8%;


        }

        .fees p span {
            color: red;
        }

        .requirments {
            width: 100%;
            height: 20%;
            margin-top: 2%;

        }

        .requirments h2 {
            padding: 0 6%;
            color: #06085e;

        }

        .requirments ul {
            padding: 0 9%;
        }

        .requirments ul li {
            padding-top: 10px;
            font-size: 23px;
        }

        .cancelation {
            width: 100%;
            /* background-color: chocolate; */
            margin-top: 2%;
        }

        .cancelation h2 {
            padding: 0 6%;
            color: #06085e;

        }

        .cancelation ul {
            padding: 9px 9%;
        }

        .cancelation ul li {
            font-size: 23px;
            padding-top: 8px;
        }

        .cancelation span {
            color: red;
        }

        .names {
            width: 100%;
            /* background-color: bisque; */
            display: flex;
            margin-top: 4%;
        }

        .names h2 {
            font-size: 35px;
            padding: 0 17%;
            color: #06085e;


        }

        span {
            font-size: 25px;
            font-weight: 200;
            padding-left: 5px;
            /* background-color: aquamarine; */
            color: black;
        }

        .name {
            /* background-color: blue; */
            width: 50%;
        }

        .name2 {
            /* background-color: brown; */
            width: 50%;
        }


        .signature {
            width: 100%;
            /* background-color: blue; */
            display: flex;
            justify-content: space-between;
            margin-top: 4%;
        }

        .client {
            width: 50%;
        }

        .client h2 {
            font-size: 35px;
            padding: 0 22%;
            color: #06085e;

        }

        .client p {
            font-size: 28px;
            padding: 5% 25%;
        }

        .freelancer {
            /* background-color: blueviolet; */
            width: 50%;
        }

        .freelancer h2 {
            font-size: 35px;
            padding: 0 22%;
            color: #06085e;

        }

        .freelancer p {
            font-size: 28px;
            padding: 5% 28%;
        }

        @media(max-width :750px) {
            .main .head h1 {
                font-size: 45px;
                padding-top: 6%;
            }

            .main .head h3 {
                font-size: 38px;

            }

            .first p {
                font-size: 20px;
                padding: 7px 8%;
            }

            .fees p {
                font-size: 18px;
                padding-top: 8px;
                padding: 8px 8%;
            }

            span {
                font-size: 17px;

            }

            .cancelation ul li {
                font-size: 16px;
                padding-top: 10px;
            }

            .names h2 {
                font-size: 20px;

            }

            .client h2 {
                font-size: 12px;
            }

            .client p {
                font-size: 12px;
                padding: 5% 21%;
            }

            .freelancer h2 {
                font-size: 11.5px;

            }

            .freelancer p {
                font-size: 11px;
                padding: 5% 28%;
            }

            .requirments ul li {

                font-size: 16px;
            }

            /* .names{
                flex-direction: column;
            }
            .signature{
                flex-direction: column;
            } */
            .name h2 {
                font-size: 15px;
            }

            .name h2 span {
                font-size: 13px;
            }

            .name2 h2 {
                font-size: 15px;
            }

            .name2 h2 span {
                font-size: 13px;
            }



        }
    </style>
                    </body>";
                    $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');                 
                    $mail->addAddress($freelancer_email);
                    $mail->addAddress($user_email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Acceptance Mail';
                    $mail->Body = $message;
                    $mail->send();
                    // header("location:income-request.php");
                    
                    
                    
                }
                    
                }
            } 
            if (isset($_POST['decline'])) {
                $request_id = $_POST['request_id'];

                // Update the request status to 'decline'
                $update2 = "UPDATE `request` SET `status` = 'decline' WHERE `request_id` = $request_id";
                $runupdate2 = mysqli_query($connect, $update2);
                header("location:income-request.php");
        
                if ($runupdate2) {
               
                    $select = "SELECT 
                                `freelancer`.`email` AS 'freelancer_email',
                                `user`.`email` AS 'user_email',
                                `freelancer`.`freelancer_name` AS 'freelancer_name',
                                `user`.`user_name` AS 'user_name'
                               FROM `request` 
                               JOIN `project` ON `request`.`project_id` = `project`.`project_id`
                               JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`.`freelancer_id`
                               JOIN `user` ON `project`.`user_id` = `user`.`user_id`
                               WHERE `request`.`request_id` = '$request_id'";
        
                    $runq = mysqli_query($connect, $select);
        
                    if (mysqli_num_rows($runq) > 0) {
                      echo 9;
                        $fetch = mysqli_fetch_assoc($runq);
                        $freelancer_name = $fetch['freelancer_name'];
                        $user_name = $fetch['user_name'];
                        $user_email = $fetch['user_email'];
                        $freelancer_email = $fetch['freelancer_email'];

        
                        $message = "
                        <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
                            <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
                                <h1 style='color: #fffffa;'>Project Request Update</h1>
                            </div>
                            <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
                                <h4 style='color: #080a74;'>Greetings $user_name,</h4>
                                <p style='color: #00000a;'>Thank you for considering me for your project.</p>
                                <p style='color: #00000a;'>Unfortunately, I will not be able to move forward with your request. I wish you the best of luck with your project.</p>
                                <div class='signature' style='margin-top: 20px;'>
                                    <h2 style='color: #080a74;'>Freelancer Signature</h2>
                                    <p style='color: #00000a;'>$freelancer_name</p>
                                </div>
                            </div>
                            <div style='background-color: #f6d673; color: #080a74; padding: 20px; text-align: center; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;'>
                                <p style='color: #080a74;'>For support and updates, please visit our website or contact us via email.</p>
                                <p style='color: #080a74;'>Email: <a href='mailto:MiDlancerTeam@gmail.com' style='color: #080a74;'>MiDlancerTeam@gmail.com</a></p>
                            </div>
                        </body>
                        ";
        
                                    $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');                 
                                    $mail->addAddress($freelancer_email);
                        $mail->addAddress($user_email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Rejection Mail';
                        $mail->Body = $message;
                        $mail->send();

                    }
                }
            }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Income Rrequests</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="css/incomerequest.css">
  <style>
    :root{
    --white: #fcfcfc;
    --gray: #cbcdd3;
    --dark: #777777;
    --error: #ef8d9c;
    --orange: #ffc39e;
    --success: #b0db7d;
    --secondary: #99dbb4;
}


@import url("https://fonts.googleapis.com/css?family=Lato:400,700");

/* $font: "Lato", sans-serif; */





.container {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 700px;
  height: 250px;
}

#container {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 700px;
  height: 250px;
}

h1 {
  font-size: 0.9em;
  font-weight: 100;
  letter-spacing: 3px;
  padding-top: 5px;
  color: var(--white) ;
  padding-bottom: 5px;
  text-transform: uppercase;
}

.green {
  color:var(--secondary);
   /* darken($secondary, 20%); */
}

.red {
  color: var(--error);
  /* darken($error, 10%); */
}

.alert {
  font-weight: 700;
  letter-spacing: 5px;
}

p {
  margin-top: -5px;
  /* font-size: 0.5em; */
  /* font-weight: 100; */
  color: var(--white);
  /* darken($dark, 10%); */
  letter-spacing: 1px;
}

button,
.dot {
  cursor: pointer;
}

#success-box {
  position: absolute;
  width: 100%;
  height: 100%;
  right: 0;
  background: linear-gradient(to bottom right, var(--success) , var(--secondary) );
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
  perspective: 40px;
}

#error-box {
  position: absolute;
  width: 25%;
  height: 50%;
  right: 37%;
  background: linear-gradient(to bottom left, var(--error) 40%, var(--orange) 100%);
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
}

.dot {
  width: 8px;
  height: 8px;
  background: var(--white);
  border-radius: 50%;
  position: absolute;
  top: 4%;
  right: 6%;

}
.dot:hover {
    background: darken(var(--white), 20%);
  }

.two {
  right: 12%;
  opacity: 0.5;
}

.face {
  position: absolute;
  width: 22%;
  height: 22%;
  background: var(--white);
  border-radius: 50%;
  border: 1px solid var(--dark);
  top: 21%;
  left: 37.5%;
  z-index: 2;
  animation: bounce 1s ease-in infinite;
}

.face2 {
  position: absolute;
  width: 22%;
  height: 22%;
  background: var(--white);
  border-radius: 50%;
  border: 1px solid var(--dark);
  top: 21%;
  left: 37.5%;
  z-index: 2;
  animation: roll 3s ease-in-out infinite;
}

.eye {
  position: absolute;
  width: 5px;
  height: 5px;
  background: var(--dark);
  border-radius: 50%;
  top: 40%;
  left: 20%;
}

.right {
  left: 68%;
}

.mouth {
  position: absolute;
  top: 43%;
  left: 41%;
  width: 7px;
  height: 7px;
  border-radius: 50%;
}

.happy {
  border: 2px solid;
  border-color: transparent var(--dark) var(--dark) transparent;
  transform: rotate(45deg);
}

.sad {
  top: 49%;
  border: 2px solid;
  border-color: var(--dark) transparent transparent var(--dark);
  transform: rotate(45deg);
}

.shadow {
  position: absolute;
  width: 21%;
  height: 3%;
  opacity: 0.5;
  background: var(--dark);
  left: 40%;
  top: 43%;
  border-radius: 50%;
  z-index: 1;
}

.scale {
  animation: scale 1s ease-in infinite;
}
.move {
  animation: move 3s ease-in-out infinite;
}

.message {
  position: absolute;
  width: 100%;
  text-align: center;
  height: 30%;
  top: 60%;
}

.button-box {
  position: absolute;
  background: var(--white);
  width: 50%;
  height: 15%;
  border-radius: 20px;
  top: 73%;
  left: 25%;
  outline: 0;
  border: none;
  box-shadow: 2px 2px 10px rgba(var(--dark), 0.5);
  transition: all 0.5s ease-in-out;
}
.button-box:hover {
    /* background: darken(var(--white), 5%); */
    transform: scale(1.05);
    transition: all 0.3s ease-in-out;
  }

@keyframes bounce {
  50% {
    transform: translateY(-10px);
  }
}

@keyframes scale {
  50% {
    transform: scale(0.9);
  }
}

@keyframes roll {
  0% {
    transform: rotate(0deg);
    left: 25%;
  }
  50% {
    left: 60%;
    transform: rotate(168deg);
  }
  100% {
    transform: rotate(0deg);
    left: 25%;
  }
}

@keyframes move {
  0% {
    left: 25%;
  }
  50% {
    left: 60%;
  }
  100% {
    left: 25%;
  }
}

        /* Popup styling */
        .popup {
            display: none; /* Hide popups by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* padding: 20px; */
            background: white;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translate(-50%,-50%);
            text-align: center;
            border-radius: 20px;
            color:#58151c;
            width: 25%;
            height: 50%;
        }
        .popup.show {
            display: block; /* Show popup when class 'show' is added */
        }
        .overlay {
            display: none; /* Hide overlay by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .overlay.show {
            display: block; /* Show overlay when class 'show' is added */
        }
        .lol{
            color:#58151c;
        }
  
</style>

</head>

<body>
    <?php include "navbarr.php"; ?>
<div class="titleincom">
        <h2 class="inbold">Incoming Requests</h2>
    </div>
    <!-- <hr/> -->
    <?php 
    if($error==true){
            ?> 
            
        <div id="error-box">
            <div class="dot"></div>
            <div class="dot two"></div>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message">
                <h1 class="alert">Oh no!</h1>
                <p>You don't have any requests at the moment.</p>
            </div>
            <!-- <button type="submit" class="button-box">
                <h1 class="red">try again</h1>
            </button> -->
        </div>
    </div>

    <?php } ?>
  <div class="cards">
    <?php foreach ($runselect as $key){ ?>
    <div class="main-dashcard">
      <div class="txt">
        <div class="title-container">
         <a  style="color: white;" href="./clientview.php?cid=<?php echo $key['user_id']; ?>">
          <div class="profile-icons">
            <img src="img/profile/<?php echo htmlspecialchars($image,ENT_QUOTES,'UTF-8') ?>" alt="Profile 1">
          </div>
          <div class="client">
            <h3>client</h3>
            <h3><?php echo htmlspecialchars($key['user_name'],ENT_QUOTES,'UTF-8')?></h3>
          </div>
          <div class="maint">
            <h1><?php echo htmlspecialchars($key['project_name'],ENT_QUOTES,'UTF-8')?></h1>
          </div>
          <div class="maint">
            <h4><?php echo htmlspecialchars($key['description'],ENT_QUOTES,'UTF-8')?></h4>
          </div>
          <div class="price">
            <h2>$<?php echo htmlspecialchars($total_price,ENT_QUOTES,'UTF-8')?></h2>
            <h3 class="month">
                <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo htmlspecialchars ($key['deadline_date'],ENT_QUOTES,'UTF-8')?> 
            </h3>
          </div>
          </a>
        </div>

        <div class="btns">
          <div class="buttons">

            <button type="button" onclick="openPopup(<?php echo $key['request_id'] ?>)" ><a>Decline</a></button>
            <button class="cssbuttons-io-button">
              Accept
              <div class="icon">
                <a  href="income-request.php?accept=<?php echo htmlspecialchars ($key['request_id'],ENT_QUOTES,'UTF-8') ?>">
                  <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                    fill="currentColor"></path>
                  </svg>
                </a>
              </div>
            </button>

          </div>

        </div>
      </div>
    </div>

<!-- DECLINE POPUP -->
  <form method="post" id="deleteRequestForm-<?php echo $key['request_id']; ?>"  style="display:none;">
    <input type="hidden" name="request_id" value="<?php echo $key['request_id']; ?>">
    <input type="hidden" name="decline" >
  </form>

  <div class="popup alert alert-danger" style="width: 50%; height: 25%; padding: 20px;" id="popup-<?php echo $key['request_id']; ?>">
    <h2><i class="fa-solid fa-triangle-exclamation"></i> Are you sure you want to decline this project?</h2>
    <button type="button" class="lol btn btn-outline-dark" onclick="confirmDelete()">Yes</button>
    <button type="button" class="lol btn btn-outline-dark" onclick="closePopup()">No</button>
  </div>

  <div class="overlay" id="overlay-<?php echo $key['request_id']; ?>"></div>
  <?php } ?>
  </div>
<!-- REQUEST ACCEPTED successfully POPUP -->
<!-- Overlay and Popup HTML -->
<?php if($popup1 == true){?>

<div class="overlay" id="overlay" onclick="closePopup1()"></div>
  <div class="containerr popup" id="popup">
      <div id="success-box">
        <div class="dot"></div>
        <div class="dot two"></div>
        <div class="face">
          <div class="eye"></div>
          <div class="eye right"></div>
          <div class="mouth happy"></div>
        </div>
        <div class="shadow scale"></div>
        <div class="message">
          <h1 class="alert">Success!</h1>
          <p>Your acceptness has been sent successfully.</p>
        </div>
      </div>
  </div>
<?php } ?>

<script>

    let deleteRequestId;

    function openPopup(requestid) {
        deleteRequestId = requestid;
        document.getElementById('popup-' + deleteRequestId).classList.add('show');
        document.getElementById('overlay-' + deleteRequestId).classList.add('show');
    }

    function closePopup() {
        if (deleteRequestId) {
            document.getElementById('popup-' + deleteRequestId).classList.remove('show');
            document.getElementById('overlay-' + deleteRequestId).classList.remove('show');
        }
    }

    function confirmDelete() {
        if (deleteRequestId) {
            document.getElementById('deleteRequestForm-' + deleteRequestId).submit();
        }
    }
    function openPopup1() {
        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closePopup1() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }

    <?php if ($popup1){ ?>
    // Automatically open the popup if popup is true
    openPopup1();
    <?php header("Refresh: 2; url=income-request.php");?>
    <?php } ?>

</script>
</body>

</html>
