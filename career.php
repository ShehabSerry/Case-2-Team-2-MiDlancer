<?php
include 'connection.php';

$CareerStmt = "SELECT * FROM `career`";
$ExecCareer = mysqli_query($connect, $CareerStmt);
?>

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
            <img src="img/career/<?php echo $data['career_image']?>" class="card-img-top" alt="career Image"> <!-- ON HOLD NEEDs career_image column to be dynamic -->
            <div class="card-body">
                <div class="card-title">
                    <h5><?php echo $data['career_path']?></h5>
                </div>
                <p class="card-text"><?php echo $data['career_desc']?></p> <!-- ON HOLD NEEDs career_desc column to be dynamic -->
                <div class="buttons">
                    <button><a href="freelancers.php?cid=<?php echo $data['career_id']; if(isset($_GET['b'])) echo "&b=1"?><?php if(isset($_GET['details'])){ $det = $_GET['details']; echo "&details=$det";}?>">Details</a></button>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- career div end -->
    </div>
    <!-- main div end -->
</body>

</html>
