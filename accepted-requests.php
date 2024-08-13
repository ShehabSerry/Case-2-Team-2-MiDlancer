<?php
include "connection.php";
//  $freelancer_id=$_SESSION['freelancer_id'];
$user_id=$_SESSION ['user_id'];
// if(isset($_GET['project_id'])) {
//     $project_id = $_GET['project_id'];
// $user_id=1;
// $freelancer_id=1;
// $project_id=1;
    $select2="SELECT * FROM `request` JOIN `project` ON `request`.`project_id` = `project`.`project_id` 
JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`. `freelancer_id`
 JOIN `user` ON `project`.`user_id` = `user`.`user_id` WHERE
 `request`. `status` = 'accept' ";
    $runselect2=mysqli_query($connect, $select2);
    if (mysqli_num_rows($runselect2) > 0) {
        $fetch = mysqli_fetch_assoc($runselect2);
        $image=$fetch['user_image'];
        $price_per_hr = $fetch['price/hr'];
        $total_hours = $fetch['total_hours'];
            $total_price = $price_per_hr * $total_hours;
            // echo $total_price;
            $_SESSION['total_price'] = $total_price;
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
        <h2 class="inbold">Accepted Requests</h2>
    </div>
    <hr/>
     

   <!-- beg of tasks requests -->
    <?php foreach ($runselect2 as $key){ ?>
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
                               <a id="accept" name="pay" href="payment.php?pay=<?php echo $key['request_id'] ?>
                               &  fi=<?php echo $key['freelancer_id']?> &  pid=<?php echo $key['project_id']?>"<button class="Btn">
                                  Payment
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
</div><?php } ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
  integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="sweetalert2.all.min.js"></script>
  <script src="js/popupdetails.js"></script>
</body>
</html>