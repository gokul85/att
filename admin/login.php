<?php

//login.php

include('values.php');

session_start();

if(isset($_SESSION["admin_id"]))
{
  header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>
  <div class="header container-fluid">
    <div class="container">
      <div class="l-t-l">
        <div class="snsinstitute-logo">
          <img src="https://cdn.bitrix24.com/b11752903/landing/693/693eeba4ff05f88e479443c1730f313b/1_1x.png" alt="">
        </div>
        <div class="dept-text">
          <span>SNS COLLEGE OF ENGINEERING</span><br>
          DEPARTMENT OF COMPUTER SCIENCE AND ENGINEERING <br>
          <span class="att">ATTENDANCE MANAGEMENT SYSTEM</span>
        </div>
        <div class="snsce-logo">
          <img src="https://snscourseware.org/images/logo%20copy.png" alt="">
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
      </div>
      <div class="col-md-4 mt-20px">
        <div class="card">
          <div class="card-header">Admin Login</div>
          <div class="card-body">
            <form method="post" id="admin_login_form">
              <div class="form-group">
                <label>Enter Username</label>
                <input type="text" name="admin_user_name" id="admin_user_name" class="form-control" />
                <span id="error_admin_user_name" class="text-danger"></span>
              </div>
              <div class="form-group">
                <label>Enter Password</label>
                <input type="password" name="admin_password" id="admin_password" class="form-control" />
                <span id="error_admin_password" class="text-danger"></span>
              </div>
              <div class="form-group">
                <input type="submit" name="admin_login" id="admin_login" class="btn btn-info" value="Login" />
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4">
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function () {
      $('#admin_login_form').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
          url: "check_admin_login.php",
          method: "POST",
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function () {
            $('#admin_login').val('Validate...');
            $('#admin_login').attr('disabled', 'disabled');
          },
          success: function (data) {
            if (data.success) {
              location.href = "<?php echo $base_url; ?>admin/index.php";
            }
            if (data.error) {
              $('#admin_login').val('Login');
              $('#admin_login').attr('disabled', false);
              if (data.error_admin_user_name != '') {
                $('#error_admin_user_name').text(data.error_admin_user_name);
              }
              else {
                $('#error_admin_user_name').text('');
              }
              if (data.error_admin_password != '') {
                $('#error_admin_password').text(data.error_admin_password);
              }
              else {
                $('#error_admin_password').text('');
              }
            }
          }
        });
      });
    });
  </script>
</body>

</html>