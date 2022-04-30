<?php

//header.php

include('admin/values.php');

session_start();

if(!isset($_SESSION["dept_id"]))
{
  header('location:login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Advisor Pannel</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
  <link rel="stylesheet" href="./css/login.css">
  <!-- Core theme CSS (includes Bootstrap) -->
  <link href="./css/styles.css" rel="stylesheet" />
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