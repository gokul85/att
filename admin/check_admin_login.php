<?php

//check_admin_login.php

include('values.php');

session_start();

sleep(1);

$admin_user_name = '';
$admin_password = '';
$error_admin_user_name = '';
$error_admin_password = '';
$error = 0;

if(empty($_POST["admin_user_name"]))
{
	$error_admin_user_name = 'Username is required';
	$error++;
}
else
{
	$admin_user_name = $_POST["admin_user_name"];
}

if(empty($_POST["admin_password"]))
{
	$error_admin_password = 'Password is required';
	$error++;
}
else
{
	$admin_password = $_POST["admin_password"];
}

if($error == 0)
{
    if($admin_user_name==$adminusername){
        if(password_verify($admin_password, $adminpassword)){
            $_SESSION["admin_id"] = 1;
        }
        else{
            $error_admin_password = "Wrong Password";
			$error++;
        }
    }
    else{
        $error_admin_user_name="Wrong Username";
        $error++;
    }
}

if($error > 0)
{
	$output = array(
		'error'					=>	true,
		'error_admin_user_name'	=>	$error_admin_user_name,
		'error_admin_password'	=>	$error_admin_password
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