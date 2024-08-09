<?php
include 'connection.php';

$CareerStmt = "SELECT * FROM `career`";
$ExecCareer = mysqli_query($connect, $CareerStmt);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Categories</title>
        <style>
            .card
            {
                background-color: #123456;
                width 25%;
                display: inline-block;
                padding: 16px;
                margin: 16px;
                text-align: center;
                color: white;
            }
            button
            {
                background-color: palegoldenrod;
            }
        </style>
    </head>
    <body>
        <h1>Career Categories</h1>
        <div class="cards">
        <?php
            $counter = 0;
            while ($data = mysqli_fetch_assoc($ExecCareer)) { ?>
            <div class="card">
                <h2><?php echo $data['career_path']; ?></h2>
                <a href="FreelancerBrief.php?cid=<?php echo $data['career_id']; ?>"><button>View Freelancers</button></a>
            </div>
        <?php
            $counter++;
            if($counter % 4 == 0 & $counter != 0)
                echo " </div><div class='cards'>";
        } ?>
        </div>
    </body>
</html>
