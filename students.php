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
        <div class="container" id="page-content">
          <div class="container mt-2" id="page-content">
          <div class="card">
  	        <div class="card-header">
              <div class="row">
                <div class="col-md-9">Student List</div>
                <div class="col-md-3" align="right">
                  <button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
                </div>
              </div>
            </div>
  	        <div class="card-body">
              <span id="message_operation"></span>
              <div class="table-responsive">
              <table id="student_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Advisor Name</th>
                        <th>Roll Number</th>
                        <th>DOB</th>
                        <th>Department Name</th>
                        <th>Department Year</th>
                        <th>Options</th>
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
</div>

<div class="modal" id="formModal">
  <div class="modal-dialog">
  	<form method="post" id="student_form">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Student Name <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="student_name" id="student_name" class="form-control" />
                <span id="error_student_name" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Student ID<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="student_id" id="student_id" class="form-control" />
                <span id="error_student_id" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Email Address <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="student_email" id="student_email" class="form-control" />
                <span id="error_student_email" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Date of Birth <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="student_dob" id="student_dob" class="form-control" />
                <span id="error_student_dob" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Depatment and Year <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <select name="student_dept_id" id="student_dept_id" class="form-control">
                  <option value="">Select Dept</option>
                  <?php
                  echo load_advisor_dept($connect,$_SESSION["dept_id"]);
                  ?>
              </select>
              <span id="error_student_dept_id" class="text-danger"></span>
              </div>
            </div>
          </div>
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

<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Confirmation</h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h3 align="center">Are you sure you want to remove this?</h3>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
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

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="./js/script.js"></script>
<script>
    $(document).ready(function(){
	
	var dataTable = $('#student_table').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"student_action.php",
			method:"POST",
			data:{action:'fetch'},
		},
        "columnDefs":[
			{
				"targets":[0, 5],
				"orderable":false,
			},
		],
    "responsive":true
	});

	$('#student_dob').datepicker({
		format:"yyyy-mm-dd",
		autoclose: true,
        container: '#formModal modal-body'
	});

	function clear_field()
	{
		$('#student_form')[0].reset();
        $('#student_id').attr("readonly",false);
		$('#error_student_name').text('');
		$('#error_student_id').text('');
        $('#error_student_email').text('');
		$('#error_student_dob').text('');
		$('#error_student_dept_id').text('');
	}

	$('#add_button').click(function(){
		$('#modal_title').text('Add Student');
		$('#button_action').val('Add');
		$('#action').val('Add');
		$('#formModal').modal('show');
		clear_field();
	});

	$('#student_form').on('submit', function(event){
		event.preventDefault();
		$.ajax({
			url:"student_action.php",
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
					if(data.error_student_name != '')
					{
						$('#error_student_name').text(data.error_student_name);
					}
					else
					{
						$('#error_student_name').text('');
					}
					if(data.error_student_id != '')
					{
						$('#error_student_id').text(data.error_student_id);
					}
					else
					{
						$('#error_student_id').text('');
					}
                    if(data.error_student_email != '')
					{
						$('#error_student_email').text(data.error_student_email);
					}
					else
					{
						$('#error_student_email').text('');
					}
					if(data.error_student_dob != '')
					{
						$('#error_student_dob').text(data.error_student_dob);
					}
					else
					{
						$('#error_student_dob').text('');
					}
					if(data.error_student_dept_id != '')
					{
						$('#error_student_dept_id').text(data.error_student_dept_id);
					}
					else
					{
						$('#error_student_dept_id').text('');
					}
				}
			}
		})
	});

    var student_id = '';

  $(document).on('click', '.edit_student', function(){
    student_id = $(this).attr('id');
    clear_field();
    $.ajax({
      url:"student_action.php",
      method:"POST",
      data:{action:'edit_fetch', student_id:student_id},
      dataType:"json",
      success:function(data)
      {
        $('#student_name').val(data.student_name);
        $('#student_id').val(data.student_id);
        $('#student_id').attr("readonly",true);
        $('#student_email').val(data.student_email);
        $('#student_dob').val(data.student_dob);
        $('#student_dept_id').val(data.student_dept_id);
        $('#modal_title').text('Edit Student');
        $('#button_action').val('Edit');
        $('#action').val('Edit');
        $('#formModal').modal('show');
      }
    })
  });

  $(document).on('click', '.delete_student', function(){
    student_id = $(this).attr('id');
    $('#deleteModal').modal('show');
  });

  $('#ok_button').click(function(){
    $.ajax({
      url:"student_action.php",
      method:"POST",
      data:{student_id:student_id, action:"delete"},
      success:function(data)
      {
        $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
        $('#deleteModal').modal('hide');
        dataTable.ajax.reload();
      }
    })
  });

});
</script>
<script>
    var current = "students";
    const sbvalues = ["dashboard", "departments", "advisors", "students"];
    for (i = 0; i < 4; i++) {
            $("#" + sbvalues[i]).removeClass("active-sb");
        }
    $("#" + current).addClass("active-sb");
</script>
</body>

</html>