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
    WHERE (`freelancer_name` LIKE '%$text%' OR SOUNDEX(`freelancer`.`freelancer_name`) = SOUNDEX('$text')) OR (`email` LIKE '%$text%') OR (`job_title` LIKE '%$text%')";
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

    $email_content = "
    <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
        <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
            <h1 style='color: #fffffa;'>Account Hold Notification</h1>
        </div>
        <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
            <p style='color: #00000a;'>Dear $name,</p>
            <p style='color: #00000a;'>We regret to inform you that your account has been put on hold. This action has been taken by the Administration team.</p>
            <p style='color: #00000a;'>If you believe this is a mistake or if you have any questions, please contact our support team for further assistance.</p>
            <p style='color: #00000a;'>Thank you for your understanding.</p>
            <p style='color: #00000a;'>Best regards,<br>The MiDlancer Team</p>
        </div>
        <div style='background-color: #f6d673; color: #080a74; padding: 20px; text-align: center; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;'>
            <p style='color: #080a74;'>For support and updates, please visit our website or contact us via email.</p>
            <p style='color: #080a74;'>Email: <a href='mailto:MiDlancerTeam@gmail.com' style='color: #080a74;'>MiDlancerTeam@gmail.com</a></p>
        </div>
    </body>";
    $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Your Account's on Hold";
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

    $email_content = "
    <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
        <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
            <h1 style='color: #fffffa;'>Account Restored!</h1>
        </div>
        <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
            <p style='color: #00000a;'>Dear $name,</p>
            <p style='color: #00000a;'>We are pleased to inform you that your account has been restored. You can now resume using all the features and services of MiDlancer.</p>
            <p style='color: #00000a;'>Thank you for your patience and understanding. We're excited to have you back!</p>
            <p style='color: #00000a;'>Best regards,<br>The MiDlancer Team</p>
        </div>
        <div style='background-color: #f6d673; color: #080a74; padding: 20px; text-align: center; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;'>
            <p style='color: #080a74;'>For support and updates, please visit our website or contact us via email.</p>
            <p style='color: #080a74;'>Email: <a href='mailto:MiDlancerTeam@gmail.com' style='color: #080a74;'>MiDlancerTeam@gmail.com</a></p>
        </div>
    </body>
";
    $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Account Restored';
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
    <?php } else if (isset($_POST['search_btn']) && empty($search_results) && isset($text)) { ?>
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
                    <tr>
                        <td colspan="6"><p style="text-align: center">Nothing matches your search keyword</p></td>
                    </tr>
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
