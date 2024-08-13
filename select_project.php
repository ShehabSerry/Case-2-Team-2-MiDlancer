<?php
include "connection.php";
$user_id=$_SESSION['user_id'];
$select="SELECT * FROM `project` WHERE `user_id`=$user_id;";
// $project_id=$_GET['projrct_id'];

$run_select = mysqli_query($connect, $select);
if(isset($_GET['vfid']))
{
    $freelancer_id = $_GET['vfid'];
    if(isset($_POST['submit']))
    {
        $project_id = $_POST['career'];
        $insert = "INSERT INTO `request` VALUES (NULL, 'pending', '$project_id', '$freelancer_id')";
        $run_insert = mysqli_query($connect, $insert);
    }
}
?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <!----link bootsrap-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- bs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <!-- link css -->
   <link rel='stylesheet' type='text/css'  media="screen" href="css/emailverify.css"/>
    <title>Select a project</title>
  </head>

  <body> 
    <a href="" class="close"><i class="fa-solid fa-x "></i></a>
<div class="background">
    <div class="container-main">
      <div class="wrapper">
          <div class="from-wraapper  Sign-in">
          <form method="post">
          <h2>Select a Project</h2>

          <div class="input-group">
            <select name="career" id="career">

            <?php foreach ($run_select as $data) { ?>
                <option value="<?php echo $data['project_id']; ?>"><?php echo $data['project_name']; ?></option>
            <?php } ?>
              
            </select>
        </div>
          
    </div>
   
    <div class="btns">
      <div class="buttons">
        <button class="cssbuttons-io-button addto" name="submit">
          <a href="#">Add To Team</a>
          <div class="icon">
            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                fill="currentColor"></path>
            </svg>
          </div>
        </button>
          <a href="add_project.php">Don't have Projects Already? Add a Project</a>
      </div>
    </div>
          <div class="signUp-link">
              <p> <a href="#" class="signUpBtn-link"></a> </p>
          </div>
          </form>
          </div>
          </div>
  </div>   
</div>
    <script src="main.js"></script>
  </body>

</html>