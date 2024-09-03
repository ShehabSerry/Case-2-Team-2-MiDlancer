<?php
// delete skill
if(isset($_GET['delete_skill'])){
    $skill_id=$_GET['delete_skill'];
    $delete_skill="DELETE FROM `skills` WHERE `skill_id`= '$skill_id' ";
    $run_delete_skill=mysqli_query($connect,$delete_skill);
    header("location:FREELANCERPROFILE.php");
}
?>
<html>
    <head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
</html>
    <style>
        /* Popup styling */
        .popup {
            display: none; /* Hide popups by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: white;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translate(-50%,-50%);
            text-align: center;
            border-radius: 7px;
            color:#58151c;
        }
        .popup.show {
            display: block; /* Show popup when class 'show' is added */
        }
        .overlay {
            display: none; /* Hide overlay by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .overlay.show {
            display: block; /* Show overlay when class 'show' is added */
        }
        .lol{
            color:#58151c;
        }
    </style>
<div class="btn btn-outline-secondary">
    <button class="btn-del" onclick="openSkillPopup()">open
        <i style="margin-left: -20px;" class="fa-solid fa-trash trash1"></i>
    </button>
</div>

<div class="popup alert alert-danger" id="popup-skill" role="alert"> 
<input type="hidden" name="chat_id">
<textarea name="edited" id=""></textarea>
<button type="submit" class="lol btn btn-outline-dark" onclick="confirmSkillDelete()">
    	   	   	  <i class="fa fa-paper-plane">
                    <button class="btn btn-primary" id="sendBtn">
    	   	   	  <i class="fa fa-paper-plane"></i>
    	   	   </button>
                  </i>
    	   	   </button>
    <!-- <button type="button" class="lol btn btn-outline-dark" onclick="closeSkillPopup()">no </button> -->
</div>

<script>
    function openSkillPopup() {
        document.getElementById('popup-skill').classList.add('show');
    }

    function closeSkillPopup() {
        document.getElementById('popup-skill').classList.remove('show');
    }

    function confirmSkillDelete() {
        // You'll need to update this function to submit the form without the skillId
        // For example, you could use a hidden input field to store the skillId
        document.getElementById('deleteSkillForm').submit();
    }
</script>