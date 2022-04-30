<?php

$connect = new PDO("mysql:host=localhost;dbname=attendance","root","");


date_default_timezone_set("Asia/Calcutta");

function get_total_records($connect, $table_name)
{
	$query = "SELECT * FROM $table_name";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function load_dept_list($connect)
{
	$query = "
	SELECT * FROM tbl_department ORDER BY dept_year ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["dept_id"].'">'.$row["dept_year"].' Year '.$row["dept_name"].'</option>';
	}
	return $output;
}

function load_advisor_dept($connect,$advisor_dept_val)
{
	$query = "
	SELECT * FROM tbl_department ORDER BY dept_year ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		if($row["dept_id"] == $advisor_dept_val){
		$output .= '<option value="'.$row["dept_id"].'">'.$row["dept_year"].' Year '.$row["dept_name"].'</option>';
		}
	}
	return $output;
}

function get_attendance_percentage($connect, $student_id)
{
	$query = "
	SELECT 
		ROUND((SELECT COUNT(*) FROM tbl_attendance 
		WHERE attendance_status = 1 
		AND student_id = '".$student_id."') 
	* 100 / COUNT(*)) AS percentage FROM tbl_attendance 
	WHERE student_id = '".$student_id."'
	";

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		if($row["percentage"] > 0)
		{
			return $row["percentage"] . '%';
		}
		else
		{
			return 'NA';
		}
	}
}

function Get_student_name($connect, $student_id)
{
	$query = "
	SELECT student_name FROM tbl_student 
	WHERE student_id = '".$student_id."'
	";

	$statement = $connect->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	foreach($result as $row)
	{
		return $row["student_name"];
	}
}

function Get_student_dept_name($connect, $student_id)
{
	$query = "
	SELECT tbl_grade.grade_name FROM tbl_student 
	INNER JOIN tbl_grade 
	ON tbl_grade.grade_id = tbl_student.student_grade_id 
	WHERE tbl_student.student_id = '".$student_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['dept_name'];
	}
}

function Get_student_advisor_name($connect, $student_id)
{
	$query = "
	SELECT tbl_advisor.advisor_name 
	FROM tbl_student 
	INNER JOIN tbl_department 
	ON tbl_department.dept_id = tbl_student.student_dept_id 
	INNER JOIN tbl_advisor 
	ON tbl_advisor.advisor_dept_id = tbl_department.dept_id 
	WHERE tbl_student.student_id = '".$student_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["advisor_name"];
	}
}

function Get_dept_name($connect, $dept_id)
{
	$query = "
	SELECT dept_name FROM tbl_department 
	WHERE dept_id = '".$dept_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["dept_name"];
	}
}

?>