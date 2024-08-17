<?php
// include 'connection.php';
 include 'nav+bm.php'; 





if(isset($_SESSION['freelancer_id']))
{
  $freelancer_id=$_SESSION['freelancer_id'] ;
  $freelancer_name=$_SESSION['freelancer_name'];
  
}
elseif(isset($_SESSION['user_id'])){
  $user_id=$_SESSION['user_id'];
  $user_name=$_SESSION['user_name'];
}



// $select="SELECT `freelancer`.*,`like`.*, `experience`.`experience_id`,`experience_text`,`experience_file` FROM `experience`  
// JOIN `freelancer` ON `experience`.`freelancer_id` = `freelancer`.`freelancer_id`
// left JOIN  `like` ON `experience`.`experience_id` = `like`.`experience_id`";
$select="SELECT `freelancer`.*,`career`.*,`like`.*, `experience`.`experience_id`,`experience_text`,`experience_file` FROM `like`  
right JOIN  `experience` ON `experience`.`experience_id` = `like`.`experience_id`
JOIN `freelancer` ON `experience`.`freelancer_id` = `freelancer`.`freelancer_id` 
JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`";
$runselect=mysqli_query($connect,$select);

// $selectcomment="SELECT * FROM `comment` WHERE `experience_id` = 'experience_id' ";
// $runcomment=mysqli_query($connect, $selectcomment);




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
  
  
  
  
  
  // $freelancer_id=$_SESSION['freelancer_id'] ;
  // $freelancer_name=$_SESSION['freelancer_name'];
  
  // $user_id=$_SESSION['user_id'];
  // $select="SELECT  * FROM `freelancer`
  // JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id` ";
  // $runselect=mysqli_query($connect,$select);
  // $fetch=mysqli_fetch_assoc($runselect);
  // $career_path=$fetch['career_path'];
  
  if(isset($_SESSION['freelancer_id'])){
    
    $selectimage = "SELECT * FROM `freelancer` WHERE `freelancer_id`='$freelancer_id'";
    $runselectimage = mysqli_query($connect, $selectimage);
    $fetch=mysqli_fetch_assoc($runselectimage);
    $freelancer_image=$fetch['freelancer_image'];
    
    
    
    //  echo $freelancer_name ;
    //  echo $freelancer_image ;
    
    
    
    
    if(isset($_POST['addpost'])){
      $description=mysqli_real_escape_string($connect,$_POST['experience_text']);
      $file=$_FILES['file']['name'];
      
      
      
      $insert="INSERT INTO `experience` VALUES (Null,'$description',NULL,'$file',NULL,'$freelancer_id')";
      $run_insert=mysqli_query($connect,$insert);
      move_uploaded_file($_FILES['file']['name'],"image/".$_FILES['file']['name']);
      
      
      
      // header("location:wall.php");
      
      
      
    }
  } else{}
  
  
  
  
  
  
  
  
  ?>




<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/wall.css">
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
        <?php 
      if(isset($_SESSION['freelancer_id'])){ ?>
        
        <form action="" method="post" enctype="multipart/form-data">
          <div class="main">
            <img src="./img/<?php echo $freelancer_image ?>"  id="img" >
            
            <!-- <img src="img/Avatars Circles Glyph Style.jpg" id="img"> -->
     
        <input type="text"  placeholder="What is in your mind?" class="txt" name="experience_text"> 
<label for="file" class="labelFile"
  ><span
    ><svg
      xml:space="preserve"
      viewBox="0 0 184.69 184.69"
      xmlns:xlink="http://www.w3.org/1999/xlink"
      xmlns="http://www.w3.org/2000/svg"
      id="Capa_1"
      version="1.1"
      width="60px"
      height="60px"
    >
      <g>
        <g>
          <g>
            <path
              d="M149.968,50.186c-8.017-14.308-23.796-22.515-40.717-19.813
				C102.609,16.43,88.713,7.576,73.087,7.576c-22.117,0-40.112,17.994-40.112,40.115c0,0.913,0.036,1.854,0.118,2.834
				C14.004,54.875,0,72.11,0,91.959c0,23.456,19.082,42.535,42.538,42.535h33.623v-7.025H42.538
				c-19.583,0-35.509-15.929-35.509-35.509c0-17.526,13.084-32.621,30.442-35.105c0.931-0.132,1.768-0.633,2.326-1.392
				c0.555-0.755,0.795-1.704,0.644-2.63c-0.297-1.904-0.447-3.582-0.447-5.139c0-18.249,14.852-33.094,33.094-33.094
				c13.703,0,25.789,8.26,30.803,21.04c0.63,1.621,2.351,2.534,4.058,2.14c15.425-3.568,29.919,3.883,36.604,17.168
				c0.508,1.027,1.503,1.736,2.641,1.897c17.368,2.473,30.481,17.569,30.481,35.112c0,19.58-15.937,35.509-35.52,35.509H97.391
				v7.025h44.761c23.459,0,42.538-19.079,42.538-42.535C184.69,71.545,169.884,53.901,149.968,50.186z"
              style="fill:#ccc;"
            ></path>
          </g>
          <g>
            <path
              d="M108.586,90.201c1.406-1.403,1.406-3.672,0-5.075L88.541,65.078
				c-0.701-0.698-1.614-1.045-2.534-1.045l-0.064,0.011c-0.018,0-0.036-0.011-0.054-0.011c-0.931,0-1.85,0.361-2.534,1.045
				L63.31,85.127c-1.403,1.403-1.403,3.672,0,5.075c1.403,1.406,3.672,1.406,5.075,0L82.296,76.29v97.227
				c0,1.99,1.603,3.597,3.593,3.597c1.979,0,3.59-1.607,3.59-3.597V76.165l14.033,14.036
				C104.91,91.608,107.183,91.608,108.586,90.201z"
              style="fill:#ccc;"
            ></path>
          </g>
        </g>
      </g></svg>
      </span>
      <button type="submit" id="sbmt" name="addpost">submit</button>

</label>
<input class="input" name="file" id="file" type="file" />

        </form> 
        <?php } else{} ?>
        <!-- start first post  -->
          
        <?php foreach ($runselect as $data1) { ?> 
          <?php

          $id2=$data1['experience_id'];
          $select="SELECT * FROM `comment` where `experience_id`=$id2";
          $run=mysqli_query($connect,$select);

          $select_like=("SELECT * FROM `like` WHERE `experience_id`='$id2'");
          $run_select_like=mysqli_query($connect,$select_like);
          $count=mysqli_num_rows($run_select_like);
          

          ?>

        <div class="mx-auto w-75 ">
          <div class="d-flex flex-column" id="comment-container">
            
            <div>
              <div class="flex-row d-flex">
               
            <form class="mt-2" method="POST">
            <input type="hidden" name="idd" value="<?php echo $data1['experience_id']?>">

                <!-- image input -->
                <td><img src="./img/<?php echo $data1['freelancer_image'] ?>" width="100px"  class="rounded-circle"></td>                 
                <div class="d-flex flex-column justify-content-start ml-2">
                  <!-- nameeee -->
                  <span class="d-block font-weight-bold name"></span>
                  <td><?php echo $data1['freelancer_name']  ?></td>
                  <span class="date text-black-50"><?php echo $data1['career_path']  ?></span>
                </div>
              </div>
              <div>
              </div>
              <div class="mt-3">
                <!-- discreption -->
                      <p> <td><?php echo $data1['experience_text'] ?></td></p>
                <td><img src="./img/<?php echo $data1['experience_file'] ?>" width="100px"></td>                  <!-- class="rounded-circle"> -->

           

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
                      <div class="count">  <?php echo $count;   ?>
                      </div>
                      <a href="./img/<?php echo $data1['experience_file'] ?>" download><i class="fa-solid fa-download" style="color:#080a74;"></i></a>
               
              </div>


              <!-- <form class="mt-2" method="post"> -->

                <div class="form-floating comm d-flex ">
                  <!-- comment input -->
                  <td><input type="text" name="comment"  class="form-control  " id="floatingTextarea" placeholder="add your comment"></td>

                  <!-- <textarea class="form-control  " placeholder="add your comment" id="floatingTextarea"></textarea> -->
                  <!-- submit comment icon -->
                  <td><button type="submit" class="btn-outline-primary s" name="submit"><i class="fa-regular fa-comment"></i></button></td>


                </div>
                <!-- comments -->
                

                <div class="second">
                  <div class="comments"> 
                  <?php foreach($run as $data){?>
                    <p><strong>
                      <?php if(isset($_SESSION['freelancer_id'])){
                        echo $freelancer_name;
                      }
                      elseif (isset($user_id)){
                        echo $user_name;
                      }
                      
                      
                      
                       ?>

                    </strong><?php echo $data['comment_text']  ?></p>
                    <?php } ?>
                  </div>
                </form> 
                    
                  
                  </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

      
      
      
      
      
    </div>
  </div>



</body>

</html>