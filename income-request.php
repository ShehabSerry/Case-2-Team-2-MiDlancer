<?php
include 'mail.php';
$freelancer_id=$_SESSION['freelancer_id'];
// $user_id=$_SESSION ['user_id'];
// if(isset($_GET['project_id'])) {
//     $project_id = $_GET['project_id'];
// $user_id=1;
// $freelancer_id=1;
// $project_id=1;

// if(isset($_GET['project_id'])){

$select="SELECT * FROM `request` JOIN `project` ON `request`.`project_id` = `project`.`project_id` 
JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`. `freelancer_id` 
 JOIN `user` ON `project`.`user_id` = `user`.`user_id` WHERE
`request`.`status` = 'pending' ";
// AND `project`.`project_id` = '$project_id' ";
$runselect=mysqli_query($connect, $select);
if (mysqli_num_rows($runselect) > 0) {
    $fetch = mysqli_fetch_assoc($runselect);
    $image=$fetch['user_image'];
    $price_per_hr = $fetch['price/hr'];
    $total_hours = $fetch['total_hours'];
        $total_price = $price_per_hr * $total_hours;}
// }
if (isset($_GET['accept'])) {
            $request_id = $_GET['accept'];
            $update = "UPDATE `request` SET `status` = 'accept' WHERE `request_id` = $request_id";
            $runupdate = mysqli_query($connect, $update);
            header("location:income-request.php");
            if ($runupdate) {
               
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
                    <body style='padding: 0; margin: 0;'>
                        <div class='main' style='width: 100%; background-color: #d6d9e0; color: #1d1d27;'>
                            <div class='head' style='width: 100%; background-color: #06085e; text-align: center; color: #d6d9e0;'>
                                <h1 style='font-size: 70px; padding-top: 2%;'>MiDlancer</h1>
                                <h3 style='font-size: 50px; font-weight: 300;'>Contract</h3>
                            </div>
                            
                            <div class='first' style='width: 100%; margin-top: 2%;'>
                                <p style='font-size: 30px; padding: 0 8%;'>I undersigned, hereby acknowledge my comprehension and acceptance of the terms and conditions delineated below.</p>
                            </div>
                            <div class='fees' style='width: 100%; margin-top: 2%;'>
                                <h2 style='padding: 0 6%; color: #06085e;'> Fees & Deadline</h2>
                                <p style='font-size: 25px; padding: 8px 8%;'>Payment of fees <span style='color: red;'>$total_price</span> for <span style='color: red;'>$project_name</span></p>
                                <p style='font-size: 25px; padding: 8px 8%;'>Payment is expected to be rendered prior to the commencement of the project on <span style='color: red;'>$date</span>, and the stipulated deadline for this project is <span style='color: red;'>$project_deadline</span>.</p>
                            </div>
                            <div class='requirements' style='width: 100%; margin-top: 2%;'>
                                <h2 style='padding: 0 6%; color: #06085e;'>Client’s Requirements</h2>
                                <ul style='padding: 0 9%;'>
                                    <li style='font-size: 23px; padding-top: 8px;'>$project_name</li>
                                    <li style='font-size: 23px; padding-top: 8px;'>$project_description</li>
                                    <li style='font-size: 23px; padding-top: 8px;'>$total_hours hours</li>
                                </ul>
                            </div>
                            <div class='cancelation' style='width: 100%; margin-top: 2%;'>
                                <h2 style='padding: 0 6%; color: #06085e;'>Cancellation & Return or Delay</h2>
                                <ul style='padding: 9px 9%;'>
                                    <li style='font-size: 23px;padding-top: 8px;'>Cancellations must be made by passing <span style='color: red;'>25%</span> of the whole duration.</li>
                                    <li style='font-size: 23px;padding-top: 8px;'>If the cancellation happens after that, all the amount of money is returned to the client directly.</li>
                                    <li style='font-size: 23px;padding-top: 8px;'>If the client wants to cancel the project, he has only <span style='color: red;'>20%</span> of the duration to get back all his money. If he passes this period, he will not be able to get his money back.</li>
                                    <li style='font-size: 23px;padding-top: 8px;'>If the freelancer delays deadlines, it will lead to a reduction in his rate on the website.</li>
                                    <li style='font-size: 23px;padding-top: 8px;'>Any party that cancels before the approved time will be charged a <span style='color: red;'>7%</span> (Half the commission) as a cancellation fee.</li>
                                    <li style='font-size: 23px;padding-top: 8px;'>If a cancellation is made after the agreed-upon cancellation deadline, the hours worked by the freelancer will be calculated and the amount due will be paid. A commission fee of <span style='color: red;'>15%</span> will be deducted, and the client will receive the remaining amount.</li>
                                    <li style='font-size: 23px;padding-top: 8px;'>In terms of the freelancer, their rating will decrease, and there will be a penalty resulting in a ban that will be <span style='color: red;'>between 1 day to 3 days</span>. Additionally, they will be subject to a fee of <span style='color: red;'>7%</span> of the commission.</li>
                                    <li style='font-size: 23px;padding-top: 8px;'>Any cancellation after the approved time to cancel from any party will result in payment of half of the commission, which amounts to <span style='color: red;'>7%</span>.</li>
                                </ul>
                            </div>
                            <div class='names' style='width: 100%; display: flex; margin-top: 4%;'>
                                <div class='name' style='width: 50%;'>
                                    <h2 style='font-size: 35px; padding: 0 17%; color: #06085e;'>Client Name:<span style='font-size: 25px; font-weight: 200; padding-left: 5px; color: black;'>$user_name</span></h2>
                                </div>
                                <div class='name2' style='width: 50%;'>
                                    <h2 style='font-size: 35px; padding: 0 17%; color: #06085e;'>Freelancer Name:<span style='font-size: 25px; font-weight: 200; padding-left: 5px; color: black;'>$freelancer_name</span></h2>
                                </div>
                            </div>
                            <div class='signature' style='width: 100%; display: flex; justify-content: space-between; margin-top: 4%;'>
                                <div class='client' style='width: 50%;'>
                                <h2 style='font-size: 35px; padding: 0 22%; color: #06085e;'>Client Signature</h2>
                                    <p style='font-size: 28px; font-family: cursive; padding: 5% 25%;'>$user_name</p>
                                </div>
                                <div class='freelancer' style='width: 50%;'>
                                <h2 style='font-size: 35px; padding: 0 22%; color: #06085e;'>Freelancer Signature</h2>
                                    <p style='font-size: 28px; font-family: cursive; padding: 5% 28%;'>$freelancer_name</p>
                                </div>
                            </div>
                        </div>
                    </body>";
                    $mail->setFrom('taskify49@gmail.com', 'Taskify');
                    $mail->addAddress($freelancer_email);
                    $mail->addAddress($user_email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Acceptance Mail';
                    $mail->Body = $message;
                    $mail->send();
    
                   
                }
                    
                }
            } 
            if (isset($_GET['decline'])) {
                $request_id = $_GET['decline'];
        
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
                        $fetch = mysqli_fetch_assoc($runq);
                        $freelancer_name = $fetch['freelancer_name'];
                        $user_name = $fetch['user_name'];
                        $user_email = $fetch['user_email'];
                        $freelancer_email = $fetch['freelancer_email'];

        
                        $message = "<body>
                                    <h4>Hi $user_name</h4>
                                    <p>Thank you for taking the time to request me for this project </p>
                                <p>Unfortunely, we willnot be moving forward withyour request. I wish you the best of luck. </p>
 <div class='signature' style='width: 100%; display: flex; justify-content: space-between; margin-top: 4%;'>
                                
                                <h2 style='font-size: 35px; padding: 0 22%; color: #06085e;'>Client Signature</h2>
                                    <p style='font-size: 28px; font-family: cursive; padding: 5% 25%;'>$user_name</p>

                                <h2 style='font-size: 35px; padding: 0 22%; color: #06085e;'>Freelancer Signature</h2>
                                    <p style='font-size: 28px; font-family: cursive; padding: 5% 28%;'>$freelancer_name</p>
                               
                                    </body>";
        
                        $mail->setFrom('taskify49@gmail.com', 'Taskify');
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
    <!-- flaticon -->
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-rounded/css/uicons-bold-rounded.css'>
  <!-- link google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <!-- link fontawsome -->
  <script src="https://kit.fontawesome.com/4f17bdb3b3.js" crossorigin="anonymous"></script>
  <!-- link bootstrab -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
    integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- link css -->
  <link rel="stylesheet" href="css/incomingrequest.css">
  
  <!-- link google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Unna:ital,wght@0,400;0,700;1,400;1,700&display=swap"
    rel="stylesheet">
    <!-- link for google icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- icofont -->
    <link rel="stylesheet" href="myProjects/webProject/icofont/css/icofont.min.css">
    <title>Document</title>
</head>
<body>
    <!-- title -->
    <div class="titleincom">
        <h2 class="inbold">Incoming Requests</h2>
    </div>
    <hr/>
     

   <!-- beg of tasks requests -->
   <?php foreach ($runselect as $key){ ?>
<div class="sizeofcards">


    <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col" >
            <div class="box">
            <div class="card h-100">
              <div class="card-body" >

                <div class="cardtext" id="openPopupBtn">
                  <img src="./img/<?php echo $image ?>" alt="" class="img"> 
                  <div class="TXT">
                    <h6 class="card-subtitle mb-2  ">Client</h6>
                    <h5 class="card-title"><?php echo $key['user_name'];?> </h5>
                  </div>
                    
                    <h3><?php echo $key['project_name'];?> </h3>
                    <h4>  <?php echo $total_price;?> </h4>
                    <p class=" deadline card-subtitle mb-2 "><span class="material-icons">
                        calendar_month
                        </span> <?php echo $key['deadline_date'];?> </p>
                </div> <br>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                       
                         <a id="accept" name="decline" href="income-request.php?decline=<?php echo $key['request_id'] ?> "<button class="DecBtn">
                            Decline
                                </button></a>
                               <a id="accept" name="accept" href="income-request.php?accept=<?php echo $key['request_id'] ?>"<button class="Btn">
                                  Accept
                                      </button></a>
                                                              </div>
              </div>
            </div>
           </div>
          </div>
      </div>
     
 </div>
  <!-- popup card details -->
  <div id="popup" class="popup">
    <div class="popup-content">
        <span id="closePopupBtn" class="close">&times;</span>
        <!-- <div class="col"> -->
        <!-- <div class="card "> -->
          <div class="card-body">
            <img src="./img/<?php echo $image ?>" alt="" class="img">
                <h5 class="card-title"><?php echo $key['user_name'];?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Client</h6>
                
                <h3><?php echo $key['project_name'];?></h3>
                <h5>Description:</h5>
                <p class="card-text"> <?php echo $key['description'];?> </p>
                <h4> <?php echo $total_price;?> </h4>
                <p class=" deadline2 card-subtitle mb-2 text-muted"><span class="material-icons">
                    calendar_month
                    </span> <?php echo $key['deadline_date'];?></p>
          </div>
    </div>
</div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
  integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="sweetalert2.all.min.js"></script>
  <script src="js/popupdetails.js"></script>
  <?php } ?>
</body>
</html>