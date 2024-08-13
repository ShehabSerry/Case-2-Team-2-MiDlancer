<?php
include 'connection.php';

if(isset($_SESSION['freelancer_id']))
{
    $freelancer_id=$_SESSION['freelancer_id'] ;
    $freelancer_name=$_SESSION['freelancer_name'];
}
elseif(isset($_SESSION['user_id'])){
    $user_id=$_SESSION['user_id'];
}



// $select="SELECT `freelancer`.*,`like`.*, `experience`.`experience_id`,`experience_text`,`experience_file` FROM `experience`  
// JOIN `freelancer` ON `experience`.`freelancer_id` = `freelancer`.`freelancer_id`
// left JOIN  `like` ON `experience`.`experience_id` = `like`.`experience_id`";
$select="SELECT `freelancer`.*,`career`.*,`like`.*, `experience`.`experience_id`,`experience_text`,`experience_file` FROM `like`  
right JOIN  `experience` ON `experience`.`experience_id` = `like`.`experience_id`
JOIN `freelancer` ON `experience`.`freelancer_id` = `freelancer`.`freelancer_id` 
JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`";


$runselect=mysqli_query($connect,$select);
 
$fetch=mysqli_fetch_assoc($runselect);


if(mysqli_num_rows($runselect)>0){
// $fetch=mysqli_fetch_assoc($runselect);
// $experience_id=$fetch['experience_id'];
}
// $file=$fetch['file'];
// $experience_id=$fetch['experience_id'];
// if(isset($_POST['delete'])){
//     $experience_id=$_POST['idd'];
// echo "$experience_id";
//     $delete="DELETE FROM `experience`  WHERE `experience_id`='$experience_id'";
//     $run_select=mysqli_query($connect,$delete);
//     header("location:wall.php");
//  }
 

 if (isset($_POST['submit'])) {
    $experience_id=$_POST['idd'];
     if(isset($_SESSION['freelancer_id']))
     {    

        echo 1;
        $comment =mysqli_real_escape_string( $connect,$_POST['comment']);
        $insert = "INSERT INTO `comment` VALUES (NULL,  '$comment', '$freelancer_id', NULL,'$experience_id')";
        $run_insert = mysqli_query($connect, $insert);
    }
    elseif (isset($user_id))
    {
        $comment =mysqli_real_escape_string( $connect,$_POST['comment']);
        $insert = "INSERT INTO `comment` VALUES (NULL,  '$comment', NULL, '$user_id','$experience_id')";
        $run_insert = mysqli_query($connect, $insert);
    }
}


if (isset($_POST['like'])) {
    echo 9 ;
    $experience_id=$_POST['idd'];


    if(isset($_SESSION['freelancer_id']))
    {   
        echo 6;
         $selectlike = "SELECT * FROM `like`WHERE `experience_id`='$experience_id' AND `freelancer_id`='$freelancer_id'";
         $runselectlike = mysqli_query($connect, $selectlike);
    
        if (mysqli_num_rows($runselectlike) > 0){
            echo "2";
            $delete="DELETE FROM `like`  WHERE `experience_id`='$experience_id' AND `freelancer_id`='$freelancer_id'";
            $run_select=mysqli_query($connect,$delete);
            header("location:wall.php");
            
        }elseif (mysqli_num_rows($runselectlike) ==0) {
            echo "4";
            $insert = "INSERT INTO `like` VALUES (null,'$freelancer_id', NULL,'$experience_id')";
            $run_insert = mysqli_query($connect, $insert);        
        }
    }
    elseif (isset($_SESSION['user_id'])){
        echo 7 ;
        $selectlike = "SELECT * FROM `like` WHERE `experience_id`='$experience_id' AND `user_id`='$user_id'";
        $runselectlike = mysqli_query($connect, $selectlike);
    
        
        if (mysqli_num_rows($runselectlike) > 0){
            echo "2";
            $delete="DELETE FROM `like`  WHERE `experience_id`='$experience_id' AND `user_id`='$user_id'";
            $run_select=mysqli_query($connect,$delete);
            header("location:wall.php");
            
        }elseif (mysqli_num_rows($runselectlike) ==0) {
            echo "4";
            $insert = "INSERT INTO `like` VALUES ( null,NULL, '$user_id','$experience_id')";
            $run_insert = mysqli_query($connect, $insert);        
        }

    }

}













    ?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/wall.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <title>Wall</title>
</head>

<body>
  
  <!-- dtart dropdown filter
  <div class="menu">
    <div class="item">
      <a href="#" class="link">
        <span> Our Services </span>
        <svg viewBox="0 0 360 360" xml:space="preserve">
          <g id="SVGRepo_iconCarrier">
            <path id="XMLID_225_"
              d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z">
            </path>
          </g>
        </svg>
      </a>
      <div class="submenu">
        <div class="submenu-item">
          <a href="#" class="submenu-link"> All</a>
        </div>
        <div class="submenu-item">
          <a href="#" class="submenu-link">Web-Development </a>
        </div>
        <div class="submenu-item">
          <a href="#" class="submenu-link">Web-Design </a>
        </div>
        <div class="submenu-item">
          <a href="#" class="submenu-link"> Content-Creator </a>
        </div>
        <div class="submenu-item">
          <a href="#" class="submenu-link"> Marketing </a>
        </div>
        <div class="submenu-item">
          <a href="#" class="submenu-link"> Voice-Over </a>
        </div>
        <div class="submenu-item">
          <a href="#" class="submenu-link"> Data-Analyst </a> -->
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row d-flex justify-content-center">

      <div class="col-md-12 mt-4 ">
        <!-- start first post  -->
        <div class="mx-auto w-75 ">
          <div class="d-flex flex-column" id="comment-container">
            
            <div>
              <div class="flex-row d-flex">
                
                <?php
        foreach ($runselect as $data) { ?> 
          <form class="mt-2" method="post">

                <!-- image input -->
                <td><img src="./img/<?php echo $data['freelancer_image'] ?>" width="100px"></td>                  <!-- class="rounded-circle"> -->
                <div class="d-flex flex-column justify-content-start ml-2">
                  <!-- nameeee -->
                  <span class="d-block font-weight-bold name"></span>
                  <td><?php echo $data['freelancer_name']  ?></td>
                  <span class="date text-black-50"><?php echo $data['career_path']  ?></span>
                </div>
              </div>
              <div>
              </div>
              <div class="mt-3">
                <!-- discreption -->
                <td><img src="./img/<?php echo $data['experience_file'] ?>" width="100px"></td>                  <!-- class="rounded-circle"> -->

                <p> <td><?php echo $data ['experience_text'] ?></td></p>

              </div>
            </div>
            <div>
              <div class="d-flex flex-row fs-14">
                <!-- like icon -->
                <!-- <td><input type = "submit" value = "like" name="like"/></td> -->
                <div class="p-2 cursor p-2" >
                  <button class="likebtn" type = "submit" value = "like" name="like"
                  >
                    <i class="fa-regular fa-thumbs-up" >

                  </i><span
                      class="ml-1">Like</span></button></div>

              </div>


              <!-- <form class="mt-2" method="post"> -->
              <input type="hidden" name="idd" value="<?php echo $data['experience_id']?>">

                <div class="form-floating comm d-flex justify-content-start">
                  <!-- comment input -->
                  <td><input type="text" name="comment"  class="form-control  " id="floatingTextarea" placeholder="add your comment"></td>

                  <!-- <textarea class="form-control  " placeholder="add your comment" id="floatingTextarea"></textarea> -->
                  <!-- submit comment icon -->
                  <td><button type="submit" class="btn-outline-primary s" name="submit"><i class="fa-regular fa-comment"></i></button></td>


                </div>
                <!-- comments -->
                
                
                 <div class="second">
                <!-- <div class="comments">  -->
                
                   <!-- <p><strong>rawan</strong>design</p> -->
              </form> 
              <?php } ?>
              
              

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
      
      
      
    </div>
  </div>



</body>

</html>