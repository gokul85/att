<?php

//index.php

include('header.php');
include("values.php");
include("db_connection.php");

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
        <div class="container mt-2" id="page-content">
          <div class="card">
  	        <div class="card-header">
              <div class="row">
                <div class="col-md-9">Advisors List</div>
                <div class="col-md-3" align="right">
                  <button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
                </div>
              </div>
            </div>
  	        <div class="card-body">
              <span id="message_operation"></span>
              <table id="advisor_table" class="display">
                <thead>
                    <tr>
                        <th>Advisor Image</th>
                        <th>Advisor Name</th>
                        <th>Advisor Email</th>
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


<div class="modal" id="formModal">
  <div class="modal-dialog">
    <form method="post" id="advisor_form" enctype="multipart/form-data">
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
              <label class="col-md-4 text-right">Advisor Name <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="advisor_name" id="advisor_name" class="form-control" />
                <span id="error_advisor_name" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Advisor Id <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="advisor_id" id="advisor_id" class="form-control" />
                <span id="error_advisor_id" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Email Address <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="advisor_email" id="advisor_email" class="form-control" />
                <span id="error_advisor_email" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Password <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="password" name="advisor_password" id="advisor_password" class="form-control" />
                <span id="error_advisor_password" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Department and Year <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <select name="advisor_dept_id" id="advisor_dept_id" class="form-control">
                  <option value="">Select Dept</option>
                  <?php
                  echo load_dept_list($connect);
                  ?>
                </select>
                <span id="error_advisor_dept_id" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Image <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="file" name="advisor_image" id="advisor_image" />
                <span class="text-muted">Only .jpg and .png allowed</span><br />
                <span id="error_advisor_image" class="text-danger"></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="hidden_advisor_image" id="hidden_advisor_image" value="" />
          <input type="hidden" name="action" id="action" value="Add" />
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<div class="modal" id="viewModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Advisor Details</h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="advisor_details">

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
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


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="../js/script.js"></script>
<script>
    $(document).ready(function(){
    var dataTable = $('#advisor_table').DataTable({
      "responsive":true,
        "processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"advisor_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[0, 1, 2, 3, 4, 5],
				"orderable":false,
			},
		],
	});

    function clear_field()
  {
    $('#advisor_form')[0].reset();
    $('#advisor_id').attr("readonly",false);
    $('#advisor_email').attr("readonly",false);
    $('#advisor_password').attr("readonly",false);
    $('#error_advisor_name').text('');
    $('#error_advisor_address').text('');
    $('#error_advisor_email').text('');
    $('#error_advisor_password').text('');
    $('#error_advisor_qualification').text('');
    $('#error_advisor_doj').text('');
    $('#error_advisor_image').text('');
    $('#error_advisor_dept_id').text('');
  }

  $('#add_button').click(function(){
    $('#modal_title').text("Add advisor");
    $('#button_action').val('Add');
    $('#action').val('Add');
    $('#formModal').modal('show');
    clear_field();
  });

  $('#advisor_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"advisor_action.php",
      method:"POST",
      data:new FormData(this),
      dataType:"json",
      contentType:false,
      processData:false,
      beforeSend:function()
      {        
        $('#button_action').val('Validate...');
        $('#button_action').attr('disabled', 'disabled');
      },
      success:function(data){
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
          if(data.error_advisor_name != '')
          {
            $('#error_advisor_name').text(data.error_advisor_name);
          }
          else
          {
            $('#error_advisor_name').text('');
          }
          if(data.error_advisor_id != '')
          {
            $('#error_advisor_id').text(data.error_advisor_id);
          }
          else
          {
            $('#error_advisor_id').text('');
          }
          if(data.error_advisor_email != '')
          {
            $('#error_advisor_email').text(data.error_advisor_email);
          }
          else
          {
            $('#error_advisor_email').text('');
          }
          if(data.error_advisor_password != '')
          {
            $('#error_advisor_password').text(data.error_advisor_password);
          }
          else
          {
            $('#error_advisor_password').text('');
          }
          if(data.error_advisor_dept_id != '')
          {
            $('#error_advisor_dept_id').text(data.error_advisor_dept_id);
          }
          else
          {
            $('#error_advisor_dept_id').text('');
          }
          if(data.error_advisor_image != '')
          {
            $('#error_advisor_image').text(data.error_advisor_image);
          }
          else
          {
            $('#error_advisor_image').text('');
          }
        }
      }
    });
  });

  $(document).on('click', '.view_advisor', function(){
    advisor_id = $(this).attr('id');
    $.ajax({
      url:"advisor_action.php",
      method:"POST",
      data:{action:'single_fetch', advisor_id:advisor_id},
      success:function(data)
      {
        $('#viewModal').modal('show');
        $('#advisor_details').html(data);
      }
    });
  });

  $(document).on('click', '.edit_advisor', function(){
  	advisor_id = $(this).attr('id');
  	clear_field();
  	$.ajax({
  		url:"advisor_action.php",
  		method:"POST",
  		data:{action:'edit_fetch', advisor_id:advisor_id},
  		dataType:"json",
  		success:function(data)
  		{
  			$('#advisor_name').val(data.advisor_name);
  			$('#advisor_id').val(data.advisor_id);
        $('#advisor_id').attr("readonly",true);
        $('#advisor_email').val(data.advisor_email);
        $('#advisor_email').attr("readonly",true);
        $('#advisor_password').attr("readonly",true);
  			$('#advisor_dept_id').val(data.advisor_dept_id);
  			$('#error_advisor_image').html('<img src="advisor_image/'+data.advisor_image+'" class="img-thumbnail" width="50" />');
  			$('#hidden_advisor_image').val(data.advisor_image);
  			$('#modal_title').text('Edit advisor');
  			$('#button_action').val('Edit');
  			$('#action').val('Edit');
  			$('#formModal').modal('show');
  		}
  	});
  });

  $(document).on('click', '.delete_advisor', function(){
  	advisor_id = $(this).attr('id');
  	$('#deleteModal').modal('show');
  });

  $('#ok_button').click(function(){
  	$.ajax({
  		url:"advisor_action.php",
  		method:"POST",
  		data:{advisor_id:advisor_id, action:'delete'},
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
    var current = "advisors";
    const sbvalues = ["dashboard", "departments", "advisors", "students"];
    for (i = 0; i < 4; i++) {
            $("#" + sbvalues[i]).removeClass("active-sb");
        }
        $("#" + current).addClass("active-sb");
</script>
</body>

</html>