<?php

//check_advisor_login.php

include('admin/db_connection.php');

session_start();

$advisor_email = '';
$advisor_password = '';
$error_advisor_email = '';
$error_advisor_password = '';
$error = 0;

if(empty($_POST["advisor_email"]))
{
	$error_advisor_email = 'Email Address is required';
	$error++;
}
else
{
	$advisor_email = $_POST["advisor_email"];
}

if(empty($_POST["advisor_password"]))
{	
	$error_advisor_password = 'Password is required';
	$error++;
}
else
{
	$advisor_password = $_POST["advisor_password"];
}

if($error == 0)
{
	$query = "
	SELECT * FROM tbl_advisor 
	WHERE advisor_email = '".$advisor_email."'
	";

	$statement = $connect->prepare($query);
	if($statement->execute())
	{
		$total_row = $statement->rowCount();
		if($total_row > 0)
		{
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				if(password_verify($advisor_password, $row["advisor_password"]))
				{
					$_SESSION["dept_id"] = $row["advisor_dept_id"];
					$_SESSION["advisor_id"] = $row["advisor_id"];
					$_SESSION["advisor_image"] = $row["advisor_image"];
				}
				else
				{
					$error_advisor_password = "Wrong Password";
					$error++;
				}
			}
		}
		else
		{
			$error_advisor_email = "Wrong Email Address";
			$error++;
		}
	}
}

if($error > 0)
{
	$output = array(
		'error'			=>	true,
		'error_advisor_email'	=>	$error_advisor_email,
		'error_advisor_password'	=>	$error_advisor_password
	);
}
else
{
	$output = array(
		'success'		=>	true
	);
}

echo json_encode($output);

?>