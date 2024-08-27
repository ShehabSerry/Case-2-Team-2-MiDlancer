<?php
include 'nav+bm.php';

// AUTH - disabled for now
//if(!isset($_SESSION['freelancer_id']))
//    header("home.php");

$freelancer_id = $_SESSION['freelancer_id'];
$error = "";

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

$sqlStmt .= " GROUP BY `project`.`project_id`";

$run_query = mysqli_query($connect, $sqlStmt);
$num = mysqli_num_rows($run_query);

if ($num == 0)
    $error = "You don't have any current projects";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/myprojectfreelancer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="main">
    <h1 class="title">MY PROJECTS</h1>
    <form method="GET">
        <button><a href="addproject.php">Add Project</a></button>
        <button><a href="my_projects_freelancer.php">All</a></button>
        <button type="submit"><a href="my_projects_freelancer.php?type_id=1">Individual</a></button>
        <button type="submit"><a href="my_projects_freelancer.php?type_id=2">Teams</a></button>
    </form>
</div>
<?php if ($num == 0) { ?>
    <div class="cards">
        <?php if(isset($error)) echo $error ?>
    </div>
<?php } else { ?>
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
                        <a href="project_details_freelancer.php?details=<?php echo $data['pid']; ?>" class="ag-courses-item_anchor">Project Details</a>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
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
