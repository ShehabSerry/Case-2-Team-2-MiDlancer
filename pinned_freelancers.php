<?php
include 'nav+bm.php';
// include("connection.php");
if(isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];
else if (isset($_SESSION['freelancer_id']))
    $logged_in_freelancer_id = $_SESSION['freelancer_id'];
$error= '';

if (isset($_GET['sort']))
    $sort = mysqli_real_escape_string($connect, $_GET['sort']); // p_asc p_dsc rank
else
    $sort = '';

if (isset($_GET['search']))
    $search = mysqli_real_escape_string($connect, $_GET['search']);
else
    $search = '';

$displayFLs = "SELECT *,`freelancer`.`freelancer_id` AS 'f_fid' FROM `bookmark`
               JOIN `freelancer` ON `bookmark`.`freelancer_id` = `freelancer`.`freelancer_id`
               JOIN `rank` ON `freelancer`.`rank_id` = `rank`.`rank_id`
               JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`
               LEFT JOIN `subscription` ON `freelancer`.`freelancer_id` = `subscription`.`freelancer_id`
               WHERE `bookmark`.`user_id` = '$user_id'
               AND (`freelancer`.`freelancer_name` LIKE '%$search%' OR `freelancer`.`bio` LIKE '%$search%' OR SOUNDEX(`freelancer`.`freelancer_name`) = SOUNDEX('$search')) AND `freelancer`.`hidden` = '0' AND `freelancer`.`admin_hidden`='0'
               GROUP BY `freelancer`.`freelancer_id`
              ";

$limit = 6; // WE CAN DISCUSS TO CHANGE THIS
if (isset($_GET['page']))
    $pageNum = $_GET['page'];
else
    $pageNum = 1;

$offset = ($pageNum - 1) * $limit; // thx tarek

if ($sort == 'p_asc')
    $displayFLs .= " ORDER BY `price/hr`, `freelancer`.`rank_id` DESC, `subscription`.`plan_id` DESC LIMIT $limit OFFSET $offset";
else if ($sort == 'p_dsc')
    $displayFLs .= " ORDER BY `price/hr` DESC, `freelancer`.`rank_id` DESC, `subscription`.`plan_id` DESC LIMIT $limit OFFSET $offset";
else if ($sort == 'rank')
    $displayFLs .= " ORDER BY `freelancer`.`rank_id` DESC, `subscription`.`plan_id` DESC LIMIT $limit OFFSET $offset";
else
    $displayFLs .= " ORDER BY `subscription`.`plan_id` DESC LIMIT $limit OFFSET $offset";

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
    $ExecDisplayFLs = mysqli_query($connect, $displayFLs);
    if (mysqli_num_rows($ExecDisplayFLs) == 0 && $pageNum > 1)
        header("Location: pinned_freelancers.php?page=" . ($pageNum - 1) . "&sort=$sort&search=$search");
    else
        header("Refresh:0;");
}



if(isset($_GET['details'])) // bushra
{
    if (isset($_POST['get_started']))
    {
        $project_id = $_GET['details'];
        $freelancer_id = $_POST['ADD_fid'];
        $join = "SELECT * FROM `request`
          JOIN `project` ON `project`.`project_id`=`request`.`project_id`
          WHERE `request`.`project_id`='$project_id' AND `request`.`freelancer_id` = '$freelancer_id'
         ";
        // -- WHERE `freelancer_id`='$freelancer_id'
        $run_join = mysqli_query($connect, $join);
        if(mysqli_num_rows($run_join) == 0)
        {
            $insert = "INSERT INTO `request` VALUES (NULL, 'pending', '$project_id', '$freelancer_id')";
            $run_insert = mysqli_query($connect, $insert);
        }
        else
        {
            $error = "Request has already been sent";
        }
    }
}
if (isset($_POST['get_drop_down']))
{
    $freelancer_id = $_POST['ADD_fid'];
    header("Location: select_project.php?vfid=$freelancer_id");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinned Freelancers</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/freelancers.css">
</head>

<body >
<div class="upper">
    <!-- search bar start -->
    <div class="search">
        <form method="GET" action="pinned_freelancers.php">
            <input type="hidden" name="sort" value="<?php echo $sort; ?>">
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
                <div class="submenu-item<?php if(empty($_GET['sort'])) echo '-selected'; ?>">
                    <a href="pinned_freelancers.php?search=<?php echo $search; ?>" class="submenu-link">Unsorted</a>
                </div>
                <div class="submenu-item<?php if(isset($_GET['sort']) && $_GET['sort'] == 'p_asc') echo '-selected'; ?>">
                    <a href="pinned_freelancers.php?search=<?php echo $search; ?>&sort=p_asc" class="submenu-link">Lowest Price</a>
                </div>
                <div class="submenu-item<?php if(isset($_GET['sort']) && $_GET['sort'] == 'p_dsc') echo '-selected'; ?>">
                    <a href="pinned_freelancers.php?search=<?php echo $search; ?>&sort=p_dsc" class="submenu-link">Highest Price</a>
                </div>
                <div class="submenu-item<?php if(isset($_GET['sort']) && $_GET['sort'] == 'rank') echo '-selected'; ?>">
                    <a href="pinned_freelancers.php?search=<?php echo $search; ?>&sort=rank" class="submenu-link">Highest Rank</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end sort by -->
</div>
<!-- --------start main card div----------- -->
<div class="cards pt-5">
    <?php if (mysqli_num_rows($ExecDisplayFLs) > 0) { while ($data = mysqli_fetch_assoc($ExecDisplayFLs)) { ?>
        <!-- start freelancer div -->
        <div class="main-dashcard" >
            <div class="image"><img src="img/profile/<?php echo $data['freelancer_image']?>" alt="Profile Pic"></div>
            <?php if(isset($user_id)) {?>
            <form method="POST">
                <input type="hidden" name="fid" value="<?php echo $data['f_fid'] ?>">
                <?php
                $fid = $data['f_fid'];
                $chk = "SELECT * FROM bookmark WHERE freelancer_id = '$fid' AND user_id = '$user_id'";
                $runChk = mysqli_query($connect, $chk);
                if (mysqli_num_rows($runChk)> 0) {?>
                <button name="bkmrk-btn" class="btn "><a class="color"><i class="fa-solid fa-bookmark white warning"></i></a></button>
                <?php } else { ?>
                <button name="bkmrk-btn" class="btn"><a class="color"><i class="fa-regular fa-bookmark white"></i></a></button>
                <?php }}?>
            </form>
            <div class="txt">
                <div class="title">
                    <h2><?php echo htmlspecialchars($data['freelancer_name']); ?></h2>
                </div>
                <div class="content">
                    <span><?php echo htmlspecialchars($data['career_path']); ?></span>
                    <h3>Job Description:-</h3>
                    <p><?php echo $data['bio']; ?></p>
                </div>
                <div class="ranks">
                    <h3>Rank:- <span><?php echo htmlspecialchars($data['rank']); ?></span></h3>
                    <br>
                    <h3>Price:- <span><?php echo htmlspecialchars($data['price/hr']); ?>$/h</span></h3>
                </div>
                <div class="btns">
                    <div class="buttons">
                        <a href="freelancerview.php?vfid=<?php echo $data['f_fid']?>"><button class="dtlsbtn">Details</button></a>
                        <?php if(isset($_SESSION['freelancer_id']) OR !(isset($_SESSION['user_id']))) { ?>
                        <button class="cssbuttons-io-button" type="submit" style="visibility: hidden">Get started
                            <div class="icon">
                                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                                </svg>
                            </div>
                        </button>
                        <?php } else {?>
                        <form method="POST">
                            <input type="hidden" value="<?php echo $data['f_fid']?>" name="ADD_fid">
                            <?php if(isset($_GET['details'])) {?>
                            <button class="cssbuttons-io-button" name="get_started" type="submit">Get started
                                <div class="icon">
                                    <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                                    </svg>
                                </div>
                            </button>
                            <?php } else { ?>
                            <button class="cssbuttons-io-button" name="get_drop_down">Get started
                                <a href="home.php?vfid=<?php echo $data['f_fid']?>"></a>
                                <div class="icon">
                                    <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                                    </svg>
                                </div>
                            </button>
                            <?php } } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End freelancer div -->
    <?php } } else { ?>
        <div class="cards">
            <p>No Freelancers Matching your Criteria</p>
        </div>
    <?php } ?>
</div>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
    <?php
    $spicySql = str_replace("LIMIT $limit OFFSET $offset", '', $displayFLs);
    $execSpicy = mysqli_query($connect, $spicySql);
    $numPages = ceil(mysqli_num_rows($execSpicy) / $limit);
    if(isset($_GET['page']))
        $currentPage = $_GET['page'];
    else
        $currentPage = 1;
    if($numPages > 1)
    { ?>
        <?php if($currentPage > 1) { ?>
        <li class="page-item">
            <a class="page-link" href="pinned_freelancers.php?search=<?php echo $search; ?>&sort=<?php echo $sort; ?>&page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                <span aria-hidden="true">«</span>
            </a>
        </li>
        <?php } ?>
        <?php
        for($pn = 1; $pn <= $numPages; $pn++) {$max = $pn; ?>
            <li class="page-item"><a class="page-link" href="pinned_freelancers.php?search=<?php echo $search; ?>&sort=<?php echo $sort; ?>&page=<?php echo $pn; ?>"><?php echo $pn; ?></a></li>
        <?php } if($currentPage != $max) { ?>
        <li class="page-item">
            <a class="page-link" href="pinned_freelancers.php?&search=<?php echo $search; ?>&sort=<?php echo $sort; ?>&page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                <span aria-hidden="true">»</span>
            </a>
        </li>
        <?php }} ?>
    </ul>
</nav>
</body>
</html>
