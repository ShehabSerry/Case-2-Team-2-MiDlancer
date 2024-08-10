<?php
include 'connection.php';

$CareerStmt = "SELECT * FROM `career`";
$ExecCareer = mysqli_query($connect, $CareerStmt);
?>


<!--        <div class="card">-->
<!--            <h2>--><?php //echo $data['career_path']; ?><!--</h2>-->
<!--            <a href="FreelancerBrief.php?cid=--><?php //echo $data['career_id']; ?><!--"><button>View Freelancers</button></a>-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Cards</title>
    <!-- bootstrap link -->
    <link rel="stylesheet" href="bootstrab/css/bootstrap.min.css">
    <!-- css link -->
    <link rel="stylesheet" href="css/career.css">
</head>

<body>
    <!-- main div start -->
    <div class="main-category">
        <!-- career div start -->
        <?php while ($data = mysqli_fetch_assoc($ExecCareer)) { ?>
        <div class="card" style="width: 20rem;">
            <img src="img/Website designer-amico.png" class="card-img-top" alt="career Image"> <!-- ON HOLD NEEDs career_image column to be dynamic -->
            <div class="card-body">
                <div class="card-title">
                    <h5><?php echo $data['career_path']?></h5>
                </div>
                <p class="card-text">involves creating the visual layout and aesthetics of a website, focusing on user
                    experience, graphics, and overall look on websites and application designing.</p> <!-- ON HOLD NEEDs career_desc column to be dynamic -->
                <div class="buttons">
                    <button><a href="FreelancerBrief.php?cid=<?php echo $data['career_id']?>">Details</a></button>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- career div end -->
    </div>
    <!-- main div end -->
</body>

</html>