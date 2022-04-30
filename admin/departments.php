<?php

//index.php

include('header.php');
include("values.php");

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
                <div class="col-md-9">Department List</div>
                <div class="col-md-3" align="right">
                  <button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
                </div>
              </div>
            </div>
  	        <div class="card-body">
              <span id="message_operation"></span>
              <table id="dept_table" class="display">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Year</th>
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
    <form method="post" id="dept_form">
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
              <label class="col-md-4 text-right">Department Name<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="dept_name" id="dept_name" class="form-control" />
                <span id="error_dept_name" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Department Year <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="dept_year" id="dept_year" class="form-control" />
                <span id="error_dept_year" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Department ID <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="dept_id" id="dept_id" class="form-control" />
                <span id="error_dept_id" class="text-danger"></span>
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




<script>
    $(document).ready(function(){
    var dataTable = $('#dept_table').DataTable({
        "responsive": true,
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"dept_action.php",
        type:"POST",
        data:{action:'fetch'}
      },
      "columnDefs":[
        {
          "targets":[0, 1, 2],
          "orderable":false,
        },
      ],
    });
    $('#add_button').click(function(){
    $('#modal_title').text('Add Department');
    $('#button_action').val('Add');
    $('#dept_id').attr('readonly',false);
    $('#action').val('Add');
    $('#formModal').modal('show');
    clear_field();
  });

  function clear_field()
  {
    $('#dept_form')[0].reset();
    $('#error_dept_name').text('');
  }

  $('#dept_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"dept_action.php",
      method:"POST",
      data:$(this).serialize(),
      dataType:"json",
      beforeSend:function()
      {
        $('#button_action').attr('disabled', 'disabled');
        $('#button_action').val('Validate...');
      },
      success:function(data)
      {
        $('#button_action').attr('disabled', false);
        $('#button_action').val($('#action').val());
        if(data.success)
        {
          $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          clear_field();
          dataTable.ajax.reload();
          $('#formModal').modal('hide');
        }
        if(data.error)
        {
          if(data.error_dept_name != '')
          {
            $('#error_dept_name').text(data.error_dept_name);
          }
          else
          {
            $('#error_dept_name').text('');
          }
          if(data.error_dept_year != '')
          {
            $('#error_dept_year').text(data.error_dept_year);
          }
          else
          {
            $('#error_dept_year').text('');
          }
          if(data.error_dept_id != '')
          {
            $('#error_dept_id').text(data.error_dept_id);
          }
          else
          {
            $('#error_dept_id').text('');
          }
        }
      }
    })
  });

  var dept_id = '';

  $(document).on('click', '.edit_dept', function(){
    dept_id = $(this).attr('id');
    clear_field();
    $.ajax({
      url:"dept_action.php",
      method:"POST",
      data:{action:'edit_fetch', dept_id:dept_id},
      dataType:"json",
      success:function(data)
      {
        $('#dept_name').val(data.dept_name);
        $('#dept_id').val(data.dept_id);
        $('#dept_id').attr('readonly',true);
        $('#dept_year').val(data.dept_year);
        $('#modal_title').text('Edit dept');
        $('#button_action').val('Edit');
        $('#action').val('Edit');
        $('#formModal').modal('show');
      }
    })
  });

  $(document).on('click', '.delete_dept', function(){
    dept_id = $(this).attr('id');
    $('#deleteModal').modal('show');
  });

  $('#ok_button').click(function(){
    $.ajax({
      url:"dept_action.php",
      method:"POST",
      data:{dept_id:dept_id, action:'delete'},
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="../js/script.js"></script>
<script>
    var current = "departments";
    const sbvalues = ["dashboard", "departments", "advisors", "students"];
    for (i = 0; i < 4; i++) {
            $("#" + sbvalues[i]).removeClass("active-sb");
        }
        $("#" + current).addClass("active-sb");
</script>
</body>

</html>