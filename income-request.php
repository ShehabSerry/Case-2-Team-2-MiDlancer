<?php
include 'mail.php';
// $freelancer_id=$_SESSION['freelancer_id'];
// $user_id=$_SESSION ['user_id'];
// if(isset($_GET['project_id'])) {
//     $project_id = $_GET['project_id'];
$user_id=1;
$freelancer_id=1;
$project_id=1;

// if(isset($_GET['project_id'])){

$select="SELECT * FROM `request` JOIN `project` ON `request`.`project_id` = `project`.`project_id` 
JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`. `freelancer_id` WHERE
`request`.`status` = 'pending' AND `project`.`project_id` = '$project_id'";
$runselect=mysqli_query($connect, $select);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>income requests Page</title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/unhide.css">
</head>
<body>

<div class="card" method="post" >
                <?php foreach ($runselect as $key){ ?>
                    <div class="first">
                        <div class="profile " name="project_name">
                            <p text-muted> project Name:</p>
                            <h5><?php echo $key['project_name'];?> </h5>
                        </div>
                    </div>
                    <div class="profile">
                        <div class="asign ">
                            <p text-muted> Total hours</p>
                            <h5><?php echo $key['total_hours'];?></h5>
                        </div>
                        <div class="asign ">
                            <p text-muted> Deadline Date</p>
                            <h5><?php echo $key['deadline_date'];?> </h5>
                        </div>
                    </div>
                    <br>
                    <a id="accept" name="accept" class="button" href="accept and decline.php?accept=<?php echo $key['request_id'] ?>">Accept</a>
                    <a id="decline" class="button" href="accept and decline.php?decline=<?php echo $key['request_id'] ?>">Decline</a>
                    <!-- popup feha details of the project -->

                    <?php } ?>

          
            </div>
            </body>

</html>
