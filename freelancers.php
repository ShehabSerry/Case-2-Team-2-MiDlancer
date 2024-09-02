<?php
include 'nav+bm.php';
// include("connection.php");
if(isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];
else if (isset($_SESSION['freelancer_id']))
    $logged_in_freelancer_id = $_SESSION['freelancer_id'];
// $error= '';

$popup1 = false; // Set to false by default
$popup2 = false;

$chkCarID = mysqli_query($connect, "SELECT career_id FROM career"); // there's room for more than 1 to 6 careers (admin interface can add more)
$careerIds = array();

while ($row = mysqli_fetch_assoc($chkCarID))
    $careerIds[] = $row['career_id'];

if(isset($_GET['cid']))
{
    $cid = mysqli_real_escape_string($connect, $_GET['cid']);
    if(!in_array($cid, $careerIds) || !$chkCarID)
        header("location: home.php");
}

if (isset($_GET['sort']))
    $sort = mysqli_real_escape_string($connect, $_GET['sort']); // p_asc p_dsc rank
else
    $sort = '';

if (isset($_GET['search']))
    $search = mysqli_real_escape_string($connect, $_GET['search']);
else
    $search = '';

$displayFLs = "SELECT *, `freelancer`.`freelancer_id` AS 'f_fid' FROM `rank`
               JOIN `freelancer` ON `rank`.`rank_id` = `freelancer`.`rank_id`
               LEFT JOIN `bookmark` on `freelancer`.`freelancer_id` = `bookmark`.`freelancer_id`
               LEFT JOIN `subscription` ON `freelancer`.`freelancer_id` = `subscription`.`freelancer_id`
               WHERE `freelancer`.`career_id` = '$cid' AND (`freelancer_name` LIKE '%$search%' OR `bio` LIKE '%$search%' OR SOUNDEX(`freelancer`.`freelancer_name`) = SOUNDEX('$search')) AND `hidden` = '0' AND `freelancer`.`admin_hidden`='0'
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
            $popup1=true;
        }
        else
        {
            // $error = "Request has already been sent";
            $popup2 = true;
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
        <title>Freelancers cards</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <link rel="stylesheet" href="css/freelancers.css">
        <style>
        /* Additional CSS for the overlay */
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



.containerr {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 700px;
  height: 250px;
} 

#containerr {
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
  width: 100%;
  height: 100%;
  right: 0;
  background: linear-gradient(to bottom right, var(--success) , var(--secondary) );
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
  perspective: 40px;
}

#error-box {
  position: absolute;
  width: 100%;
  height: 100%;
  right: 0;
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

        .overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            height: 50%;
        }
    </style>
    </head>

<body >
    <div class="upper">
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
                        <a href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?>" class="submenu-link">Unsorted</a>
                    </div>
                    <div class="submenu-item<?php if(isset($_GET['sort']) && $_GET['sort'] == 'p_asc') echo '-selected'; ?>">
                        <a href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?>&sort=p_asc" class="submenu-link">Lowest Price</a>
                    </div>
                    <div class="submenu-item<?php if(isset($_GET['sort']) && $_GET['sort'] == 'p_dsc') echo '-selected'; ?>">
                        <a href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?>&sort=p_dsc" class="submenu-link">Highest Price</a>
                    </div>
                    <div class="submenu-item<?php if(isset($_GET['sort']) && $_GET['sort'] == 'rank') echo '-selected'; ?>">
                        <a href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?>&sort=rank" class="submenu-link">Highest Rank</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end sort by -->
        <!-- search bar start -->
        <div class="search">
            <form method="GET" action="Freelancers.php">
                <input type="hidden" name="cid" value="<?php echo $cid; ?>">
                <input type="hidden" name="sort" value="<?php echo $sort; ?>">
                <input placeholder="Search..." type="text" name="search" value="<?php echo $search; ?>">
                <button type="submit">Go</button>
            </form>
        </div>
        <!-- search bar end -->

       
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
                    <a class="page-link" href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?>&sort=<?php echo $sort; ?>&page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
            <?php } ?>
                <?php
                for($pn = 1; $pn <= $numPages; $pn++) {$max = $pn; ?>
                    <li class="page-item"><a class="page-link" href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?>&sort=<?php echo $sort; ?>&page=<?php echo $pn; ?>"><?php echo $pn; ?></a></li>
                <?php } if($currentPage != $max) { ?>
                <li class="page-item">
                    <a class="page-link" href="Freelancers.php?cid=<?php echo $cid; ?>&search=<?php echo $search; ?>&sort=<?php echo $sort; ?>&page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            <?php }} ?>
        </ul>
    </nav>


        <!-- Overlay and Popup HTML -->


    <?php if($popup1){?>

        <div class="overlay" id="overlay" onclick="closePopup1()"></div>
  <div class="containerr popup" id="popup">
      <div id="success-box">
        <div class="dot"></div>
        <div class="dot two"></div>
        <div class="face">
          <div class="eye"></div>
          <div class="eye right"></div>
          <div class="mouth happy"></div>
        </div>
        <div class="shadow scale"></div>
        <div class="message">
          <h1 class="alert">Success!</h1>
          <p>Your request has been sent successfully.</p>
        </div>
        <!-- <button type="submit" class="button-box"><h1 class="green">continue</h1></button> -->
      </div>
  </div>
<?php } ?>
<div class="overlay" id="overlay" onclick="closePopup2()"></div>
<div class="container popup" id="popup">
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
            <!-- <h1 class="alert">Error!</h1> -->
             <br>
             <br>
            <p>Your request has been sent already</p>
        </div>
            <h1 class="red">try again</h1>
        </button>
    </div>
</div>

<script>
        function openPopup1() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closePopup1() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        <?php if ($popup1){ ?>
        // Automatically open the popup if $popup is true
        openPopup1();
        <?php } ?>


      
        function openPopup2() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

   
        function closePopup2() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        <?php if ($popup2){ ?>
        // Automatically open the popup if $popup is true
      
        openPopup2();
        <?php } ?>
     </script>
</body>
</html>
