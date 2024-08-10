<?php
include 'connection.php';

//$user_id = $_SESSION['user_id'];
$user_id = 1; // STATIC FOR NOW


if (isset($_GET['cid']))
    $cid = mysqli_real_escape_string($connect, $_GET['cid']); // le funny sql injection, thx Tarek
//else
//    header("location: placeholderfornow.php"); // just not to repeat what happened in C1

if (isset($_GET['sort']))
    $sort = mysqli_real_escape_string($connect, $_GET['sort']); // p_asc p_dsc rank
else
    $sort = '';

if (isset($_GET['search']))
    $search = mysqli_real_escape_string($connect, $_GET['search']);
else
    $search = '';


if (isset($_GET['b']) && $_GET['b'] == 1) // special BOOKMARK page route: nav bkmrk anchor > career.php (with b) >> freelancers.php (with b)
{
    $displayFLs = "SELECT *,`freelancer`.`freelancer_id` AS 'f_fid' FROM `bookmark`
                   JOIN `freelancer` ON `bookmark`.`freelancer_id` = `freelancer`.`freelancer_id`
                   JOIN `rank` ON `freelancer`.`rank_id` = `rank`.`rank_id`
                   WHERE `bookmark`.`user_id` = '$user_id' AND `freelancer`.`career_id` = '$cid'
                   AND (`freelancer`.`freelancer_name` LIKE '%$search%' OR `freelancer`.`bio` LIKE '%$search%') AND `freelancer`.`hidden` = '0'
                  ";
}
else
{
    $displayFLs = "SELECT *, `freelancer`.`freelancer_id` AS 'f_fid' FROM `rank` JOIN `freelancer` ON `rank`.`rank_id` = `freelancer`.`rank_id`
                   LEFT JOIN `bookmark` on `freelancer`.`freelancer_id` = `bookmark`.`freelancer_id`
                   WHERE `freelancer`.`career_id` = '$cid' AND (`freelancer_name` LIKE '%$search%' OR `bio` LIKE '%$search%') AND `hidden` = '0'
                  ";
}

if ($sort == 'p_asc')
    $displayFLs .= " ORDER BY `premium` DESC, `price/hr`, `freelancer`.`rank_id` DESC";
else if ($sort == 'p_dsc')
    $displayFLs .= " ORDER BY `premium` DESC, `price/hr` DESC, `freelancer`.`rank_id` DESC";
else if ($sort == 'rank')
    $displayFLs .= " ORDER BY `premium` DESC, `freelancer`.`rank_id` DESC";
else
    $displayFLs .= " ORDER BY `premium` DESC";


$ExecDisplayFLs = mysqli_query($connect, $displayFLs);


if (isset($_POST['bkmrk-btn']))
{
    $fid = $_POST['fid'];
    $checkBookmark = "SELECT * FROM bookmark WHERE freelancer_id = '$fid' AND user_id = '$user_id'";
    $ExecCheck = mysqli_query($connect, $checkBookmark);

    if (mysqli_num_rows($ExecCheck) > 0)
    {
        $delBookmark = "DELETE FROM bookmark WHERE freelancer_id = '$fid' AND user_id = '$user_id'";
        mysqli_query($connect, $delBookmark);
    }
    else
    {
        $insertBookmark = "INSERT INTO bookmark (freelancer_id, user_id) VALUES ('$fid', '$user_id')";
        mysqli_query($connect, $insertBookmark);
    }
    header("Refresh:0;");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancers cards</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/freelancers.css">
</head>

<body>
<div class="upper">
    <!-- search bar start -->
    <div class="search">
        <form method="GET" action="Freelancers.php">
            <input type="hidden" name="cid" value="<?php echo $cid; ?>">
            <input type="hidden" name="sort" value="<?php echo $sort; ?>">
            <?php if(isset($_GET['b']) && $_GET['b'] == 1) {?>
            <input type="hidden" name="b" value="<?php if(isset($_GET['b'])) echo 1; else echo ''; ?>">
            <?php } ?>
            <input placeholder="Search..." type="text" name="search" value="<?php echo $search; ?>">
            <button type="submit">Go</button>
        </form>
    </div>
    <!-- search bar end -->

    <!-- sort by start -->
    <div class="menu">
        <div class="item">
            <a href="#" class="link">
                <span> Sort</span>
                <svg viewBox="0 0 360 360" xml:space="preserve">
                        <g id="SVGRepo_iconCarrier">
                            <path id="XMLID_225_"
                                  d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z">
                            </path>
                        </g>
                    </svg>
            </a>
            <div class="submenu">
<!--                <div class="submenu-item-selected">-->
<!--                    <a href="" class="submenu-link">All</a>-->
<!--                </div>-->
                <div class="submenu-item<?php if(empty($_GET['sort'])) echo '-selected'; ?>">
                    <a href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?><?php if(isset($_GET['b'])) echo '&b=1'; else echo ''; ?>" class="submenu-link">Unsorted</a>
                </div>
                <div class="submenu-item<?php if(isset($_GET['sort']) && $_GET['sort'] == 'p_asc') echo '-selected'; ?>">
                    <a href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?>&sort=p_asc<?php if(isset($_GET['b'])) echo '&b=1'; else echo ''; ?>" class="submenu-link">Lowest Price</a>
                </div>
                <div class="submenu-item<?php if(isset($_GET['sort']) && $_GET['sort'] == 'p_dsc') echo '-selected'; ?>">
                    <a href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?>&sort=p_dsc<?php if(isset($_GET['b'])) echo '&b=1'; else echo ''; ?>" class="submenu-link">Highest Price</a>
                </div>
                <div class="submenu-item<?php if(isset($_GET['sort']) && $_GET['sort'] == 'rank') echo '-selected'; ?>">
                    <a href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?>&sort=rank<?php if(isset($_GET['b'])) echo '&b=1'; else echo ''; ?>" class="submenu-link">Highest Rank</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end sort by -->
</div>

<!-- --------start main card div----------- -->
<div class="cards">
    <?php if (mysqli_num_rows($ExecDisplayFLs) > 0) { while ($data = mysqli_fetch_assoc($ExecDisplayFLs)) { ?>
        <!-- start freelancer div -->
        <div class="main-dashcard" >
            <div class="image"><img src="img/profile/<?php echo $data['image']?>" alt="Profile Pic"></div>
            <form method="POST">
                <input type="hidden" name="fid" value="<?php echo $data['f_fid'] ?>">
                <?php
                $fid = $data['freelancer_id'];
                $chk = "SELECT * FROM bookmark WHERE freelancer_id = '$fid' AND user_id = '$user_id'";
                $runChk = mysqli_query($connect, $chk);
                if (mysqli_num_rows($runChk)> 0) {?>
                <button name="bkmrk-btn" class="btn"><a><i class="fa-solid fa-bookmark white"></i></a></button>
                <?php } else { ?>
                <button name="bkmrk-btn" class="btn"><a><i class="fa-regular fa-bookmark white"></i></a></button>
                <?php }?>
            </form>
            <div class="txt">
                <div class="title">
                    <h2><?php echo $data['freelancer_name']; ?></h2>
                </div>
                <div class="content">
                    <h3>Job Description:-</h3>
                    <p><?php echo $data['bio']; ?></p>
                    <h3>Rank:-</h3>
                    <p class="dis1"><?php echo $data['rank']; ?></p>
                    <h3>Price:-</h3>
                    <p class="dis2"><?php echo $data['price/hr']; ?>$/h</p>
                </div>
                <div class="btns">
                    <div class="buttons">
                        <button><a href="#">Details</a></button> <!-- # Alaa Profile page -->
                        <button class="cssbuttons-io-button">
                            <a href="#">Get started</a> <!-- # The whole contacting kind of deal -->
                            <div class="icon">
                                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End freelancer div -->
    <?php } } else { ?>
        <div class="cards">
            <p>No Freelancers Matching your Criteria</p> <!-- FRONT MAY CHOOSE TO CHANGE THIS STYLING -->
        </div>
    <?php } ?>
</div>
</body>

</html>

<!-- Perhaps the "b" route should have a header "Bookmarked freelancers" or something  -->