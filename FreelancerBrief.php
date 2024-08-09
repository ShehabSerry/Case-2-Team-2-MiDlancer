<?php
include 'connection.php';

if(isset($_GET['cid']))
    $cid = mysqli_real_escape_string($connect, $_GET['cid']); // le funny sql injection, thx Tarek
//else
//    header("location: placeholderfornow.php"); // just not to repeat what happened in C1


if (isset($_GET['sort']))
    $sort = mysqli_real_escape_string($connect, $_GET['sort']);
else
    $sort = '';


if(isset($_POST['search-btn']))
    $search = mysqli_real_escape_string($connect, $_POST['search']);
else
    $search = '';


$displayFLs = "SELECT * FROM freelancer WHERE career_id = '$cid' AND (freelancer_name LIKE '%$search%' OR bio LIKE '%$search%')";


if ($sort == 'p_asc')
    $displayFLs .= " ORDER BY `price/hr`, `rank_id` DESC";
else if ($sort == 'p_dsc')
    $displayFLs .= " ORDER BY `price/hr` DESC, `rank_id` DESC";
elseif ($sort == 'rank')
    $displayFLs .= " ORDER BY `rank_id` DESC";

$ExecDisplayFLs = mysqli_query($connect, $displayFLs);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Freelancers</title>
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
    </style>
</head>
    <body>
    <h1>Freelancers</h1>
    <form method="POST" action="FreelancerBrief.php?cid=<?php echo $cid; ?>">
        <input type="text" name="search" placeholder="Search" value="<?php echo $search ?>">
        <button type="submit" name="search-btn">Search</button>
    </form>
    <br>
    <form method="GET" action="FreelancerBrief.php">
        <input type="hidden" name="cid" value="<?php echo $cid; ?>">
        <select name="sort">
            <option value="">Sort By</option>
            <option value="p_asc" <?php if ($sort == 'price') echo 'selected'; ?>>Lowest to Highest Price</option>
            <option value="p_dsc" <?php if ($sort == 'price') echo 'selected'; ?>>Highest to Lowest Price</option>
            <option value="rank" <?php if ($sort == 'rank') echo 'selected'; ?>>Rank</option>
        </select>
        <button type="submit">Sort</button>
    </form>

    <div class="cards">
        <?php if (mysqli_num_rows($ExecDisplayFLs)) {while ($data = mysqli_fetch_assoc($ExecDisplayFLs)){ ?>
        <div class="card">
            <h2><?php echo $data['freelancer_name'] ?></h2>
            <p><?php echo $data['bio'] ?></p>
            <p>Price: <?php echo $data['price/hr'] ?></p>
            <p>Rank: <?php echo $data['rank_id'] ?></p>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
    <div class="cards">
        <p> No Freelancers Matching your Criteria </p>
        <?php } ?>
    </body>
</html>

