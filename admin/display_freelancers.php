<?php
include 'mail.php';


$select = "SELECT * FROM `freelancer`
JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`";
$run_select = mysqli_query($connect, $select);


if(isset($_POST['search_btn'])){
    $text=mysqli_real_escape_string($connect,$_POST['text']);
    $select_search="SELECT * FROM `freelancer`
    JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`
    WHERE (`freelancer_name` LIKE '%$text%') OR (`email` LIKE '%$text%') OR (`job_title` LIKE '%$text%') ";
    $run_select_search=mysqli_query($connect,$select_search);
}




if (isset($_GET['hold'])) {
    $freelancer_id =$_GET['hold']; 

    $select1 = "SELECT * FROM `freelancer` WHERE `freelancer_id` = $freelancer_id"; 
    $runselect = mysqli_query($connect, $select1);

    $fetch = mysqli_fetch_assoc($runselect);
    $name=['freelancer_name'];
   $email = $fetch['email'];


    $update = "UPDATE `freelancer` SET `admin_hidden` = 1 WHERE `freelancer_id` = $freelancer_id";
   $runupdate = mysqli_query($connect, $update);

        // echo "this freelancer has been put on hold.";



        $email_content = "
        <body>
        <p>Dear $name, you are hold </p> <!-- FRONT NEEDED MAILER BODY -->
        </body>
        ";
    
    
            $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Account Activation Code';
            $mail->Body = ($email_content);
            $mail->send();
    

        header("Location: display_freelancers.php");

    } else 
    if (isset($_GET['unhold'])) {
        $freelancer_id=$_GET['unhold']; 
        $select1 = "SELECT * FROM `freelancer` WHERE `freelancer_id` = $freelancer_id"; 
        $runselect = mysqli_query($connect, $select1);
    
        $fetch = mysqli_fetch_assoc($runselect);
        $name=['freelancer_name'];
       $email = $fetch['email'];
    
    
        $update = "UPDATE `freelancer` SET `admin_hidden` = 0 WHERE `freelancer_id` = $freelancer_id";
       $runupdate = mysqli_query($connect, $update);
    
            // echo "this freelancer's account has been restored .";

            $email_content = "
            <body>
            <p>Dear $name, you are unhold </p> <!-- FRONT NEEDED MAILER BODY -->
            </body>
            ";
        
        
                $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Account Activation Code';
                $mail->Body = ($email_content);
                $mail->send();
    
    
            header("Location: display_freelancers.php");
    
        } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/displayfreelancers.css">
</head>
<body>
<div class="container">
    <h1 class="txt">freelancers</h1>
    <hr>
    <!-- <form method="POST" class="searchform">
        <input type="search" name="text">
        <button type="submit" name="search_btn">search</button>
    </form> -->
    <div class="search">
        <form method="POST" action="display_freelancers.php">
            <input placeholder="Search..." type="search" name="text" class="srchinput" >
            <button type="submit" name="search_btn">Go</button>
        </form>
    </div>
    <?php if(isset($_POST['search_btn'])) { ?>
        <table id="example" class="table table-striped" style="width:90%; margin:auto;">
    <thead>
        <tr class="head">
            <th>photo</th>
            <th>Freelancer Name</th>
            <th>Freelancer Email</th>
            <th>career</th>
            <th>job title</th>
            <th>Hold account</th>
        </tr>
    </thead>
    <tbody>
  
        <?php foreach($run_select_search as $roww){ ?>
            <tr>
                <td><img src="../img/profile/<?php echo $roww['freelancer_image']?>" alt="Profile Pic"></td>
                <td><?php echo htmlspecialchars($roww['freelancer_name']); ?></td>
                <td><?php echo htmlspecialchars($roww['email']); ?></td>
                <td><?php echo htmlspecialchars($roww['career_path']); ?></td>
                <td><?php echo htmlspecialchars($roww['job_title']); ?></td>
                <td>
                   
                <?php if ($roww['admin_hidden'] == 0) { ?>
                    <a href="display_freelancers.php?hold=<?php echo $roww['freelancer_id']; ?>;">
                        <button type="button" class="btn btn-danger" name="hold">hold</button>
                    </a>
                    <?php }else{ ?>
                        <a href="display_freelancers.php?unhold=<?php echo $roww['freelancer_id']; ?>;">
                        <button type="button" class="btn btn-danger"name="unhold">Unhold</button>
                    </a>
                </td>
            </tr>
        <?php } }?>
    </tbody>
</table>
<?php }else{ ?>

<table id="example" class="table table-striped" style="width:90%; margin:auto;">
    <thead>
        <tr class="head">
            <th>photo</th>
            <th>Freelancer Name</th>
            <th>Freelancer Email</th>
            <th>career</th>
            <th>job title</th>
            <th>Hold account</th>
        </tr>
    </thead>
    <tbody>
  
        <?php foreach($run_select as $row){ ?>
            <tr>
                <td><img src="../img/profile/<?php echo $row['freelancer_image']?>" alt="Profile Pic"></td>
                <td><?php echo htmlspecialchars($row['freelancer_name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['career_path']); ?></td>
                <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                <td>
                   
                <?php if ($row['admin_hidden'] == 0) { ?>
                    <a href="display_freelancers.php?hold=<?php echo $row['freelancer_id']; ?>;">
                        <button type="button" class="btn btn-danger" name="hold">hold</button>
                    </a>
                    <?php }else{ ?>
                        <a href="display_freelancers.php?unhold=<?php echo $row['freelancer_id']; ?>;">
                        <button type="button" class="btn btn-danger"name="unhold">Unhold</button>
                    </a>
                </td>
            </tr>
        <?php } }?>
    </tbody>
</table>
<?php } ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>
