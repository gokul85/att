<?php

//index.php

include('header.php');

?>
<style>
    .active-sb {
        background: #e5e5e5;
    }
</style>

<div class="d-flex" id="wrapper">
    <!-- Sidebar-->
    <div class="border-end bg-white" id="sidebar-wrapper">
        <div class="sidebar-heading border-bottom bg-light">Advisor Panel</div>
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
        <div class="container" style="margin-top:30px" id="page-content">
            <div class="card">
  	<div class="card-header">
      <div class="row">
        <div class="col-md-9">Overall Student Attendance Status</div>
        <div class="col-md-3" align="right">
          
        </div>
      </div>
    </div>
  	<div class="card-body">
  		<div class="table-responsive">
        <table class="table table-striped table-bordered nowrap" id="student_table">
          <thead>
            <tr>
              <th>Student Name</th>
              <th>Roll Number</th>
              <th>Year</th>
              <th>Department</th>
              <th>Attendance Percentage</th>
              <th>Report</th>
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

<div class="modal" id="formModal">
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
        <input type="hidden" name="student_id" id="student_id" />
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
	 
     var dataTable = $('#student_table').DataTable({
       "processing":true,
       "serverSide":true,
       "order":[],
       "ajax":{
         url:"attendance_action.php",
         type:"POST",
         data:{action:'index_fetch'}
       },
       "responsive":true
     });
   
     $('.input-daterange').datepicker({
       todayBtn:"linked",
       format:"yyyy-mm-dd",
       autoclose:true,
       container: '#formModal modal-body'
     });

     $(document).on('click', '.report_button', function(){
    var student_id = $(this).attr('id');
    $('#student_id').val(student_id);
    $('#formModal').modal('show');
  });

  $('#create_report').click(function(){
    var student_id = $('#student_id').val();
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var error = 0;
    if(from_date == '')
    {
      $('#error_from_date').text('From Date is Required');
      error++;
    }
    else
    {
      $('#error_from_date').text('');
    }
    if(to_date == '')
    {
      $('#error_to_date').text('To Date is Required');
      error++;
    }
    else
    {
      $('#error_to_date').text('');
    }

    if(error == 0)
    {
      $('#from_date').val('');
      $('#to_date').val('');
      $('#formModal').modal('hide');
      window.open("report.php?action=student_report&student_id="+student_id+"&from_date="+from_date+"&to_date="+to_date);
    }
  });
    });


</script>
<!-- <script>
    var current = "dashboard";
    const sbvalues = ["dashboard", "attendance", "", "students"];
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