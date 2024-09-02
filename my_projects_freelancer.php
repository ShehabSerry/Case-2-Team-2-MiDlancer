<?php
include 'nav+bm.php';
$error = "";

if(isset($_SESSION['freelancer_id']))
    $freelancer_id = $_SESSION['freelancer_id'];
else
    header("location:home.php");

$limit = 3; // DISCUS - WE CAN CHANGE THIS - FRONT BACK
if (isset($_GET['page']))
    $pageNum = $_GET['page'];
else
    $pageNum = 1;

$offset = ($pageNum - 1) * $limit;

$sqlStmt =
    "SELECT project.*, SUM(payment.amount) AS sumamount, `project`.`project_id` AS `pid` 
     FROM `project`
     RIGHT JOIN `user` ON `user`.`user_id` = `project`.`user_id`
     LEFT JOIN `team_member` ON `project`.`project_id` = `team_member`.`project_id`
     LEFT JOIN `freelancer` ON `freelancer`.`freelancer_id` = `team_member`.`freelancer_id`
     JOIN `type` ON `type`.`type_id` = `project`.`type_id`
     LEFT JOIN `payment` ON `payment`.`project_id` = `project`.`project_id`
     WHERE `freelancer`.`freelancer_id` = '$freelancer_id'
    ";

if (isset($_GET['type_id']))
{
    $type_id = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_GET['type_id'])));
    $sqlStmt .= " AND `type`.`type_id` = $type_id";
}

$sqlStmt .= " GROUP BY `project`.`project_id` LIMIT $limit OFFSET $offset";

$run_query = mysqli_query($connect, $sqlStmt);
$num = mysqli_num_rows($run_query);

if ($num == 0)
{
    $error = true;
    if(isset($_GET['type_id']))
        $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects</title>
    <link rel="stylesheet" href="css/myprojectfreelancer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
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
  width: 35%;
  height: 100%;
  right: 0;
  background: linear-gradient(to bottom right, var(--success) , var(--secondary) );
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
  perspective: 40px;
}

#error-box {
  position: absolute;
  width: 35%;
  height: 100%;
  right: 30vh;
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
  height: 40%;
  top: 47%;
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
@media (max-width: 767px) {
    
    #error-box {
        position: absolute;
        width: 35%;
        height: 100%;
        right: 50%;
        background: linear-gradient(to bottom left, var(--error) 40%, var(--orange) 100%);
        border-radius: 20px;
        box-shadow: 5px 5px 20px rgba(#cbcdd3, 10%);
    }

}
</style>
</head>
<body>
<div class="main">
    <h1 class="title">MY PROJECTS</h1>
    <form method="GET">
        <button style="width: 12em;"><a style="padding: 10px;" href="my_projects_freelancer.php">All</a></button>
        <button style="width: 12em;" type="submit"><a style="padding: 10px;" href="my_projects_freelancer.php?type_id=1">Individual</a></button>
        <button style="width: 12em;" type="submit"><a style="padding: 10px;" href="my_projects_freelancer.php?type_id=2">Teams</a></button>
    </form>
</div>
<?php 
    if($num==0){
            ?> 
            
    <div class="container popup " style="margin-top:20vh" id="popup">
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
                <h1 class="alert">Error!</h1>
                <p>You don't have any current projects</p>
            </div>
            <!-- <button type="submit" class="button-box">
                <h1 class="red">try again</h1>
            </button> -->
        </div>
    </div>

    <?php } ?>
    <div class="ag-format-container">
        <div class="ag-courses_box">
            <?php foreach ($run_query as $data) { ?>
                <div class="ag-courses_item">
                    <a href="project_details_freelancer.php?details=<?php echo $data['pid']; ?>" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                            <h4 class="teams"><?php echo $data['project_name']; ?></h4>
                            <p class="para"><?php echo $data['description']; ?></p>
                        </div>
                        <div class="ag-courses-item_date-box">
                            <i class="fa-regular fa-clock"></i> Total Hours:
                            <span class="ag-courses-item_date"><?php echo $data['total_hours']; ?> Hour</span>
                        </div>
                        <div class="ag-courses-item_date-box">
                            <i class="fa-solid fa-money-bills"></i> Total Amount:
                            <span class="ag-courses-item_date"><?php echo $data['sumamount']; ?> USD</span>
                        </div>
                        <div class="ag-courses-item_date-box">
                            <i class="fa-regular fa-clock"></i> Deadline:
                            <span class="ag-courses-item_date"><?php echo $data['deadline_date']; ?></span>
                        </div>
                        <a href="project_details_freelancer.php?details=<?php echo $data['pid']; ?>" class="ag-courses-item_anchor">Project Details</a>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php ?>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php $spicySql = str_replace("LIMIT $limit OFFSET $offset", '', $sqlStmt);
        $execSpicy = mysqli_query($connect, $spicySql);
        $numPages = ceil(mysqli_num_rows($execSpicy) / $limit);
        if(isset($_GET['page']) && is_numeric($_GET['page']))
            $currentPage = $_GET['page'];
        else
            $currentPage = 1;
        if($numPages > 1)
        { ?>
            <?php if($currentPage > 1) { ?>
            <li class="page-item">
                <a class="page-link" href="my_projects_freelancer.php?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php } ?>
            <?php
            for($pn = 1; $pn <= $numPages; $pn++) {$max = $pn; ?>
                <li class="page-item"><a class="page-link" href="my_projects_freelancer.php?page=<?php echo $pn; ?>"><?php echo $pn; ?></a></li>
                <?php } if($currentPage != $max) { ?>
            <li class="page-item">
                <a class="page-link" href="my_projects_freelancer.php?page=<?php echo $currentPage + 1; ?><?php if(isset($_GET['b'])) echo '&b=1'; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php }} ?>
    </ul>
</nav>
<style>
    button
    {
        --color: #2124b1;
        font-family: inherit;
        display: inline-block;
        width: 11em;
        height: 2.6em;
        line-height: 2.5em;
        margin: 20px;
        position: relative;
        cursor: pointer;
        overflow: hidden;
        border: 2px solid var(--color);
        transition: color 0.5s;
        z-index: 1;
        font-size: 15px;
        border-radius: 6px;
        font-weight: 500;
        color: var(--color);
        background-color: transparent;
    }

    button:before
    {
        content: "";
        position: absolute;
        z-index: -1;
        background: var(--color);
        height: 150px;
        width: 200px;
        border-radius: 50%;
    }

    button:hover a
    {
        color: #fff;
    }

    .navbar-toggler
    {
        font-size: 1.25rem;
        line-height: 1;
        background-color: transparent;
        border: 1px solid transparent;
        border-radius: 10px;
        transition: box-shadow 0.15s ease-in-out;
        width: 43px;
        text-align: center;
    }

    h4 {color: white;}

    button:before
    {
        top: 100%;
        left: 100%;
        transition: all 0.7s;
    }

    button:hover:before
    {
        top: -30px;
        left: -30px;
    }

    button:active:before
    {
        background: #3a0ca3;
        transition: background 0s;
    }
</style>
</body>
</html>
