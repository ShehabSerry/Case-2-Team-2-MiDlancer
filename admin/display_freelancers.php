<?php
include 'mail.php';


$select = "SELECT * FROM `freelancer`
JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`";
$run_select = mysqli_query($connect, $select);

$search_results = [];
if (isset($_POST['search_btn'])) {
    $text = mysqli_real_escape_string($connect, $_POST['text']);
    $sql = "SELECT * FROM `freelancer`
    JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`
    WHERE (`freelancer_name` LIKE '%$text%') OR (`email` LIKE '%$text%') OR (`job_title` LIKE '%$text%')";
    $run_select_search = mysqli_query($connect, $sql);
    if (mysqli_num_rows($run_select_search) > 0) {
        $search_results = mysqli_fetch_all($run_select_search, MYSQLI_ASSOC);
    }
}

if (isset($_GET['hold'])) {
    $freelancer_id = $_GET['hold'];
    $select1 = "SELECT * FROM `freelancer` WHERE `freelancer_id` = $freelancer_id";
    $runselect = mysqli_query($connect, $select1);
    $fetch = mysqli_fetch_assoc($runselect);
    $email = $fetch['email'];
    $name = $fetch['freelancer_name'];

    $update = "UPDATE `freelancer` SET `admin_hidden` = 1 WHERE `freelancer_id` = $freelancer_id";
    mysqli_query($connect, $update);

    $email_content = "<body><p>Dear $name, your account has been put on hold.</p></body>";
    $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Account Hold Notification';
    $mail->Body = $email_content;
    $mail->send();

    header("Location: display_freelancers.php");
    exit();
}

if (isset($_GET['unhold'])) {
    $freelancer_id = $_GET['unhold'];
    $select1 = "SELECT * FROM `freelancer` WHERE `freelancer_id` = $freelancer_id";
    $runselect = mysqli_query($connect, $select1);
    $fetch = mysqli_fetch_assoc($runselect);
    $email = $fetch['email'];
    $name = $fetch['freelancer_name'];

    $update = "UPDATE `freelancer` SET `admin_hidden` = 0 WHERE `freelancer_id` = $freelancer_id";
    mysqli_query($connect, $update);

    $email_content = "<body><p>Dear $name, your account has been restored.</p></body>";
    $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Account Restoration Notification';
    $mail->Body = $email_content;
    $mail->send();

    header("Location: display_freelancers.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/displayfreelancers.css">
</head>
<body>
<div class="container">
    <h1 class="txt">Freelancers</h1>
    <hr>
    <div class="search">
        <form method="POST" action="display_freelancers.php">
            <input placeholder="Search..." type="search" name="text" class="srchinput" id="searchText">
            <button type="submit" name="search_btn">Go</button>
        </form>
    </div>

    <?php if (isset($_POST['search_btn']) && !empty($search_results)) { ?>
        <table id="example" class="table table-striped" style="width:90%; margin:auto;">
            <thead>
                <tr class="head">
                    <th>Photo</th>
                    <th>Freelancer Name</th>
                    <th>Freelancer Email</th>
                    <th>Career</th>
                    <th>Job Title</th>
                    <th>Hold Account</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($search_results as $roww) { ?>
                    <tr>
                        <td><img src="../img/profile/<?php echo htmlspecialchars($roww['freelancer_image']); ?>" alt="Profile Pic"></td>
                        <td><?php echo htmlspecialchars($roww['freelancer_name']); ?></td>
                        <td><?php echo htmlspecialchars($roww['email']); ?></td>
                        <td><?php echo htmlspecialchars($roww['career_path']); ?></td>
                        <td><?php echo htmlspecialchars($roww['job_title']); ?></td>
                        <td>
                            <?php if ($roww['admin_hidden'] == 0) { ?>
                                <a href="display_freelancers.php?hold=<?php echo $roww['freelancer_id']; ?>">
                                    <button type="button" class="btn btn-danger" name="hold">Hold</button>
                                </a>
                            <?php } else { ?>
                                <a href="display_freelancers.php?unhold=<?php echo $roww['freelancer_id']; ?>">
                                    <button type="button" class="btn btn-danger" name="unhold">Unhold</button>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <table id="example" class="table table-striped" style="width:90%; margin:auto;">
            <thead>
                <tr class="head">
                    <th>Photo</th>
                    <th>Freelancer Name</th>
                    <th>Freelancer Email</th>
                    <th>Career</th>
                    <th>Job Title</th>
                    <th>Hold Account</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($run_select)) { ?>
                    <tr>
                        <td><img src="../img/profile/<?php echo htmlspecialchars($row['freelancer_image']); ?>" alt="Profile Pic"></td>
                        <td><?php echo htmlspecialchars($row['freelancer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['career_path']); ?></td>
                        <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                        <td>
                            <?php if ($row['admin_hidden'] == 0) { ?>
                                <a href="display_freelancers.php?hold=<?php echo $row['freelancer_id']; ?>">
                                    <button type="button" class="btn btn-danger" name="hold">Hold</button>
                                </a>
                            <?php } else { ?>
                                <a href="display_freelancers.php?unhold=<?php echo $row['freelancer_id']; ?>">
                                    <button type="button" class="btn btn-danger" name="unhold">Unhold</button>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#searchText").on("input", function(){
            var searchText = $(this).val();
            if(searchText === "") {
                location.reload(); 
                return;
            }
            $.post('', { text: searchText, search_btn: 'Go' }, function(data){
                var rows = $(data).find('table tbody tr'); 
                $('#example tbody').html(rows); 
            });
        });
    });
</script>
</div>
</body>
</html>
