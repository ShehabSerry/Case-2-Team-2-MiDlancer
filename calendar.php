<?php include "nav+bm.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar</title>
    <!-- CSS for full calendar -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <!-- JS for jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- JS for full calendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <!-- Bootstrap CSS and JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-3">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-warning">Projects And Subscription Calendar</h1>
            <div style="color:#080a74;" id="calendar"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    display_tasks();
});

function display_tasks() {
    var tasks = [];
    var dead = [];

    $.ajax({
        url: 'display_calendar.php',  
        dataType: 'json',
        success: function(response) {
            if(response.status) {
                var result = response.data;
                $.each(result, function(i, item) {
                    tasks.push({
                        title: item.task_name,
                        start: item.deadline_date,
                        end: item.deadline_date,
                        color: item.color,
                        url: item.project_url 
                    });
                    tasks.push({
                        
                        title: item.plan_name,
                        start: item.end_date,
                        end: item.end_date
                    });
                });

                $('#calendar').fullCalendar({
                    defaultView: 'month',
                    editable: true,
                    events: tasks,
                    eventRender: function(event, element) { 
                        element.bind('click', function() {
                            alert(event.title +  "\nEnd: " + event.end.format("YYYY-MM-DD"));
                        });
                    }
                });
            } else {
                alert(response.msg);
            }
        },
        error: function(xhr, status) {
            alert('Error fetching data.');
        }
    });
}






</script>
</body>
</html>
