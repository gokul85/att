<?php

//index.php

include('header.php');
include("values.php");
include('db_connection.php');

?>
<style>
    .active-sb {
        background: #e5e5e5;
    }
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="d-flex" id="wrapper">
    <!-- Sidebar-->
    <div class="border-end bg-white" id="sidebar-wrapper">
        <div class="sidebar-heading border-bottom bg-light">Admin Panel</div>
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action list-group-item-light p-3 active-sb" id="dashboard"
                href="./index.php">Dashboard</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" id="departments"
                href="./departments.php">Departments</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" id="advisors"
                href="./advisors.php">Advisors</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" id="students"
                href="./students.php">Students</a>
            <!-- <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Profile</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Status</a> -->
        </div>
    </div>
    <!-- Page content wrapper-->
    <div id="page-content-wrapper">
        <!-- Top navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container-fluid">
                <button class="btn" id="sidebarToggle" style="padding:4px!important"><svg
                        xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 24 24"
                        style=" fill:#000000;">
                        <path
                            d="M 2 5 L 2 7 L 22 7 L 22 5 L 2 5 z M 2 11 L 2 13 L 22 13 L 22 11 L 2 11 z M 2 17 L 2 19 L 22 19 L 22 17 L 2 17 z">
                        </path>
                    </svg></button>
                <div class="header-right" style="width:40px;height:40px">
                    <img src="../image/5cda9655a2ac1.jpg" alt="" width="100%" height="100%" style="border-radius:50%">
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container" id="page-content">
                    <?php
                        $output = '';
                        $query = "SELECT * FROM tbl_department ";
                        $statement = $connect->prepare($query);
                        $statement->execute();
                        $result = $statement->fetchAll();
                        $rowcount = $statement->rowCount();
                        foreach($result as $row)
                        {
                            $sub_array = array();
                            $sub_array[] = $row["dept_id"];
                            $sub_array[] = $row["dept_name"];
                            $sub_array[] = $row["dept_year"];
                            $data[] = $sub_array;
                        }
                        if ($rowcount>0){
                        foreach($data as $rows){
                            $output2 = '';
                            $present_percentage = 0;
                            $absent_percentage = 0;
                            $total_present = 0;
                            $total_absent = 0;
                            $query2 = "
                            SELECT * FROM tbl_attendance 
                            INNER JOIN tbl_student  
                            ON tbl_student.student_id = tbl_attendance.student_id 
                            INNER JOIN tbl_department 
                            ON tbl_department.dept_id = tbl_student.student_dept_id 
                            WHERE tbl_student.student_dept_id = '".$rows[0]."'
                            ";
                            //echo $query;
                            $statement2 = $connect->prepare($query2);
                            $statement2->execute();

                            $result2 = $statement2->fetchAll();

                            $total_row2 = $statement2->rowCount();

                            foreach($result2 as $row2)
                            {
                                $status = '';
                                if($row2["attendance_status"] == "Present")
                                {
                                    $total_present++;
                                    $status = '<span class="badge badge-success">Present</span>';
                                }

                                if($row2["attendance_status"] == "Absent")
                                {
                                    $total_absent++;
                                    $status = '<span class="badge badge-danger">Absent</span>';
                                }
                                $output2 .= '
                                    <tr>
                                        <td>'.$row2["student_name"].'</td>
                                        <td>'.$status.'</td>
                                    </tr>
                                ';
                            }

                            if($total_row2 > 0)
                            {
                                $present_percentage = ($total_present / $total_row2) * 100;
                                $absent_percentage = ($total_absent / $total_row2) * 100;
                            }
                            echo '<div class="container" style="margin-top:30px">
                            <div class="card">
                                <div class="card-header"><b>Attendance Chart</b></div>
                                <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered table-striped">
                                    <tr>
                                      <th>Department Name</th>
                                      <td>'.$rows[2].' Year '.$rows[1].'</td>
                                    </tr>
                                  </table>
                                </div>
                                    <div id="attendance_pie_chart'.$rows[0].'" style="width: 100%; height: 400px;">
                          
                                    </div>
                                </div>
                            </div>
                          </div>';
                            echo '<script type="text/javascript">
                            google.charts.load("current", {"packages":["corechart"]});
                            google.charts.setOnLoadCallback(drawChart);
                          
                            function drawChart()
                            {
                              var data = google.visualization.arrayToDataTable([
                                ["Attendance Status", "Percentage"],
                                ["Present", '.$present_percentage.'],
                                ["Absent", '.$absent_percentage.']
                              ]);
                          
                              var options = {
                                title: "Overall Attendance Analytics",
                                hAxis: {
                                  title: "Percentage",
                                  minValue: 0,
                                  maxValue: 100
                                },
                                vAxis: {
                                  title: "Attendance Status"
                                }
                              };
                          
                              var chart = new google.visualization.PieChart(document.getElementById("attendance_pie_chart'.$rows[0].'"));
                              chart.draw(data, options);
                            }
                          </script>';

                            
                        }
                    }

                    ?>
        </div>
    </div>
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="../js/script.js"></script>




<!-- <script>
    var current = "dashboard";
    const sbvalues = ["dashboard", "departments", "advisors", "students"];
    function sidebarfunction(a) {
        for (i = 0; i < 4; i++) {
            $("#" + sbvalues[i]).removeClass("active-sb");
        }
        $("#" + sbvalues[a]).addClass("active-sb");
        current = sbvalues[a];
    }

</script> -->
</body>

</html>