<?php
include "connection.php";
$user_id=$_SESSION['user_id'];
$runselect2=[];
    $select2="SELECT * FROM `request` JOIN `project` ON `request`.`project_id` = `project`.`project_id` 
JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`. `freelancer_id` WHERE
 `request`. `status` = 'accept' ";
    $runselect2=mysqli_query($connect, $select2);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>accepted requests Page</title>
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
                <?php foreach ($runselect2 as $key){ ?>
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
                    <a id="accept" class="button" href="payment.php?payment=<?php echo $key['request_id'] ?>">payment</a>
                    <!-- popup feha details of the project -->

                    <?php } ?>
          
            </div>
            </body>

</html>
