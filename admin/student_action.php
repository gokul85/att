<?php

//student_action.php

include('db_connection.php');

session_start();

if(isset($_POST["action"]))
{
	if($_POST["action"] == "fetch")
	{
		$query = "
		SELECT * FROM tbl_student 
		INNER JOIN tbl_department 
		ON tbl_department.dept_id = tbl_student.student_dept_id 
		";

		if(isset($_POST["search"]["value"]))
		{
			$query .= '
			WHERE tbl_student.student_name LIKE "%'.$_POST["search"]["value"].'%" 
			OR tbl_student.student_id LIKE "%'.$_POST["search"]["value"].'%" 
			OR tbl_student.student_dob LIKE "%'.$_POST["search"]["value"].'%"
            OR tbl_student.student_email LIKE "%'.$_POST["search"]["value"].'%" 
			OR tbl_department.dept_name LIKE "%'.$_POST["search"]["value"].'%"
            OR tbl_department.dept_year LIKE "%'.$_POST["search"]["value"].'%" 
			';
		}

		if(isset($_POST["order"]))
		{
			$query .= '
			ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].'
			';
		}
		else
		{
			$query .= '
			ORDER BY tbl_student.student_id ASC 
			';
		}
		if($_POST["length"] != -1)
		{
			$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$statement = $connect->prepare($query);

		$statement->execute();
		$result = $statement->fetchAll();
		$data = array();
		$filtered_rows = $statement->rowCount();
		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = $row["student_name"];
			$sub_array[] = $row["student_id"];
			$sub_array[] = $row["student_dob"];
			$sub_array[] = $row["dept_name"];
            $sub_array[] = $row["dept_year"];
			$sub_array[] = '<button type="button" name="edit_student" class="btn btn-primary btn-sm edit_student" id="'.$row["student_id"].'">Edit</button>&nbsp;&nbsp;<button type="button" name="delete_student" class="btn btn-danger btn-sm delete_student" id="'.$row["student_id"].'">Delete</button>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	get_total_records($connect, 'tbl_student'),
			"data"				=>	$data
		);

		echo json_encode($output);
	}

	if($_POST["action"] == 'Add' || $_POST["action"] == "Edit")
	{
		$student_name = '';
		$student_id = '';
        $student_email = '';
		$student_dob = '';
		$student_dept_id = '';
		$error_student_name = '';
		$error_student_id = '';
        $error_student_email = '';
		$error_student_dob = '';
		$error_student_dept_id = '';
		$error = 0;
		if(empty($_POST["student_name"]))
		{
			$error_student_name = 'Student Name is required';
			$error++;
		}
		else
		{
			$student_name = $_POST["student_name"];
		}
		if(empty($_POST["student_id"]))
		{
			$error_student_id = 'Student ID is required';
			$error++;
		}
		else
		{
			$student_id = $_POST["student_id"];
		}
        if(empty($_POST["student_email"]))
			{
				$error_student_email = 'Email Address is required';
				$error++;
			}
			else
			{
				if(!filter_var($_POST["student_email"], FILTER_VALIDATE_EMAIL))
				{
					$error_student_email = 'Invalid email format';
					$error++;
				}
				else
				{
					$student_email = $_POST["student_email"];
				}
			}
		if(empty($_POST["student_dob"]))
		{
			$error_student_dob = 'Student Date of Birth is required';
			$error++;
		}
		else
		{
			$student_dob = $_POST["student_dob"];
		}
		if(empty($_POST["student_dept_id"]))
		{
			$error_student_dept_id = "Department and Year is required";
			$error++;
		}
		else
		{
			$student_dept_id = $_POST["student_dept_id"];
		}
		if($error > 0)
		{
			$output = array(
				'error'							=>	true,
				'error_student_name'			=>	$error_student_name,
				'error_student_id'		=>	$error_student_id,
                'error_student_email'		=>	$error_student_email,
				'error_student_dob'				=>	$error_student_dob,
				'error_student_dept_id'		=>	$error_student_dept_id
			);
		}
		else
		{
			if($_POST["action"] == 'Add')
			{
				$data = array(
					':student_name'		=>	$student_name,
					':student_id'	=>	$student_id,
                    ':student_email'	=>	$student_email,
					':student_dob'		=>	$student_dob,
					':student_dept_id'	=>	$student_dept_id
				);
				$query = "
				INSERT INTO tbl_student 
				(student_name, student_id, student_email, student_dob, student_dept_id) 
				VALUES (:student_name, :student_id, :student_email, :student_dob, :student_dept_id)
				";

				$statement = $connect->prepare($query);
				if($statement->execute($data))
				{
					$output = array(
						'success'		=>	'Data Added Successfully',
					);
				}
			}
			if($_POST["action"] == "Edit")
			{
				$data = array(
					':student_name'			=>	$student_name,	
					':student_id'	=>	$student_id,
                    ':student_email'	=>	$student_email,
					':student_dob'			=>	$student_dob,
					':student_dept_id'		=>	$student_dept_id
				);
				$query = "
				UPDATE tbl_student 
				SET student_name = :student_name, 
				student_dob = :student_dob,
                student_email = :student_email, 
				student_dept_id = :student_dept_id 
				WHERE student_id = :student_id
				";
				$statement = $connect->prepare($query);
				if($statement->execute($data))
				{
					$output = array(
						'success'		=>	'Data Edited Successfully',
					);
				}
			}
		}
		echo json_encode($output);
	}

	if($_POST["action"] == "edit_fetch")
	{
		$query = "
		SELECT * FROM tbl_student 
		WHERE student_id = '".$_POST["student_id"]."'
		";
		$statement = $connect->prepare($query);
		if($statement->execute())
		{
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				$output["student_name"] = $row["student_name"];
				$output["student_id"] = $row["student_id"];
                $output["student_email"] = $row["student_email"];
				$output["student_dob"] = $row["student_dob"];
				$output["student_dept_id"] = $row["student_dept_id"];
			}
			echo json_encode($output);
		}
	}
	if($_POST["action"] == "delete")
	{
		$query = "
		DELETE FROM tbl_student 
		WHERE student_id = '".$_POST["student_id"]."'
		";
		$statement = $connect->prepare($query);
		if($statement->execute())
		{
			echo 'Data Delete Successfully';
		}
	}
}

?>