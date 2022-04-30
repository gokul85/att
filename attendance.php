<?php

//index.php

include('header.php');
include("admin/values.php");
include("admin/db_connection.php");

?>
<style>
    .active-sb {
        background: #e5e5e5;
    }
</style>

<div class="d-flex" id="wrapper">
    <!-- Sidebar-->
    <div class="border-end bg-white" id="sidebar-wrapper">
        <div class="sidebar-heading border-bottom bg-light">Admin Panel</div>
        <div class="list-group list-group-flush">
          <a class="list-group-item list-group-item-action list-group-item-light p-3 active-sb" id="dashboard"
                href="./index.php">Dashboard</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" id="attendance"
                href="./attendance.php">Attendance</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" id="students"
                href="./students.php">Students List</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3"
                href="./logout.php">Logout</a>
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
                    <img src="admin/advisor_image/<?php echo $_SESSION["advisor_image"]; ?>" alt="" width="100%" height="100%" style="border-radius:50%">
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container" style="margin-top:30px">
  <div class="card">
  	<div class="card-header">
      <div class="row">
        <div class="col-md-4">Attendance List</div>
        <div class="col-md-4 d-flex"><input type="date" class="form-control mr-2"  id="attendance_date_picker" value="<?php echo date("Y-m-d"); ?>" /></div>
        <div class="col-md-4" align="right">
          <button type="button" id="report_button" class="btn btn-danger btn-sm">Report</button>
          <button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
        </div>
      </div>
    </div>
  	<div class="card-body">
  		<div class="table-responsive">
        <span id="message_operation"></span>
        <table class="table table-striped table-bordered" id="attendance_table">
          <thead>
            <tr>
              <th>Student Name</th>
              <th>Roll Number</th>
              <th>Year</th>
              <th>Department</th>
              <th>Attendance Status</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
  		</div>
  	</div>
  </div>
</div>
    </div>
</div>

<script type="text/javascript" src="./js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="./css/datepicker.css" />

<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>

<?php

$query = "
SELECT * FROM tbl_department WHERE dept_id = '".$_SESSION["dept_id"]."'
";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

?>

<div class="modal" id="formModal">
  <div class="modal-dialog">
    <form method="post" id="attendance_form">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <?php
          foreach($result as $row)
          {
          ?>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Department <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <?php
                echo '<label>'.$row["dept_name"].'</label>';
                ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Attendance Date <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="date" name="attendance_date" id="attendance_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
                <span id="error_attendance_date" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group" id="student_details">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Roll No.</th>
                    <th>Student Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                  </tr>
                </thead>
                <?php
                $sub_query = "
                  SELECT * FROM tbl_student 
                  WHERE student_dept_id = '".$row["dept_id"]."'
                ";
                $statement = $connect->prepare($sub_query);
                $statement->execute();
                $student_result = $statement->fetchAll();
                foreach($student_result as $student)
                {
                ?>
                  <tr>
                    <td><?php echo $student["student_id"]; ?></td>
                    <td>
                      <?php echo $student["student_name"]; ?>
                      <input type="hidden" name="student_id[]" value="<?php echo $student["student_id"]; ?>" />
                    </td>
                    <td>
                      <input type="radio" name="attendance_status<?php echo $student["student_id"]; ?>" checked value="Present" />
                    </td>
                    <td>
                      <input type="radio" name="attendance_status<?php echo $student["student_id"]; ?>" value="Absent" />
                    </td>
                  </tr>
                <?php
                }
                ?>
              </table>
            </div>
          </div>
          <?php
          }
          ?>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="action" id="action" value="Add" />
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<div class="modal" id="reportModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Make Report</h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <div class="input-daterange">
            <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
            <span id="error_from_date" class="text-danger"></span>
            <br />
            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
            <span id="error_to_date" class="text-danger"></span>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" name="create_report" id="create_report" class="btn btn-success btn-sm">Create Report</button>
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="./js/script.js"></script>
<script>
    $(document).ready(function(){

    var current_date = $("#attendance_date_picker").val();
	
	var dataTable = $('#attendance_table').DataTable({
        "responsive":true,
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"attendance_action_2.php",
			method:"POST",
			data:function(d){d.action='fetch',d.cur_date=$("#attendance_date_picker").val()},
		},
        "columnDefs":[
			{
				"targets":[0, 4],
				"orderable":false,
			},
		],
	});

    function clear_field()
  {
    $('#attendance_form')[0].reset();
    $('#error_attendance_date').text('');
  }

  $('#add_button').click(function(){
    $('#modal_title').text("Add Attendance");
    $('#formModal').modal('show');
    clear_field();
  });

  $('#attendance_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"attendance_action.php",
      method:"POST",
      data:$(this).serialize(),
      dataType:"json",
      beforeSend:function(){
        $('#button_action').val('Validate...');
        $('#button_action').attr('disabled', 'disabled');
      },
      success:function(data)
      {
        $('#button_action').attr('disabled', false);
        $('#button_action').val($('#action').val());
        if(data.success)
        {
          $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          clear_field();
          $('#formModal').modal('hide');
          dataTable.ajax.reload();
        }
        if(data.error)
        {
          if(data.error_attendance_date != '')
          {
            $('#error_attendance_date').text(data.error_attendance_date);
          }
          else
          {
            $('#error_attendance_date').text('');
          }
        }
      }
    })
  });


    $("body").on('change', '#attendance_date_picker', function(){
        var value_var = $("#attendance_date_picker").val();
        current_date = $("#attendance_date_picker").attr("value",value_var);
        console.log(current_date);
        dataTable.ajax.reload();

    });
$("#report_button").click(function(){
       $.ajax({
           url:'report.php',
           method:"GET",
           data:{action:"day_attendance",date:$("#attendance_date_picker").val()},
           success:function(){
            window.open("report.php?action=day_attendance&date="+$("#attendance_date_picker").val());
           }
       });
});
});

</script>
<script>
    var current = "attendance";
    const sbvalues = ["dashboard", "attendance", "students"];
    for (i = 0; i < 4; i++) {
            $("#" + sbvalues[i]).removeClass("active-sb");
        }
    $("#" + current).addClass("active-sb");
</script>
</body>

</html>