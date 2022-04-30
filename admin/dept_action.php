<?php

//dept_action.php
include('db_connection.php');

session_start();

$output = '';

if(isset($_POST["action"]))
{
	if($_POST["action"] == "fetch")
	{
		$query = "SELECT * FROM tbl_department ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'WHERE tbl_department.dept_name LIKE "%'.$_POST["search"]["value"].'%" ';
		}
		if(isset($_POST["order"]))
		{
			$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= 'ORDER BY dept_id DESC ';
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
			$sub_array[] = $row["dept_name"];
			$sub_array[] = $row["dept_year"];
			$sub_array[] = '<button type="button" name="edit_dept" class="btn btn-primary btn-sm edit_dept" id="'.$row["dept_id"].'">Edit</button>&nbsp;&nbsp;<button type="button" name="delete_dept" class="btn btn-danger btn-sm delete_dept" id="'.$row["dept_id"].'">Delete</button>';
			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	get_total_records($connect, 'tbl_department'),
			"data"				=>	$data
		);

		
	}
	if($_POST["action"] == 'Add' || $_POST["action"] == "Edit")
	{
		$dept_name = '';
		$error_dept_name = '';
		$dept_year = 0;
		$error_dept_year = '';
		$dept_id = '';
		$error_dept_id = '';
		$error = 0;
		if(empty($_POST["dept_name"]))
		{
			$error_dept_name = 'Dept Name is required';
			$error++;
		}
		else
		{
			$dept_name = $_POST["dept_name"];
		}
		if(empty($_POST["dept_year"]))
		{
			$error_dept_year = 'Dept Year is required';
			$error++;
		}
		else
		{
			$dept_year = $_POST["dept_year"];
		}
		if(empty($_POST["dept_id"]))
		{
			$error_dept_id = 'Dept Id is required';
			$error++;
		}
		else
		{
			$dept_id = $_POST["dept_id"];
		}
		if($error > 0)
		{
			$output = array(
				'error'							=>	true,
				'error_dept_name'				=>	$error_dept_name,
				'error_dept_year'				=>	$error_dept_year,
				'error_dept_id'				=>	$error_dept_id

			);
		}
		else
		{
			if($_POST["action"] == "Add")
			{
				$data = array(
					':dept_name'				=>	$dept_name,
					':dept_year'				=>	$dept_year,
					':dept_id'				=>	$dept_id
				);
				$query = "
				INSERT INTO tbl_department (dept_id, dept_name, dept_year)
   				SELECT :dept_id, :dept_name, :dept_year
   				WHERE NOT EXISTS (SELECT * FROM tbl_department 
                   WHERE dept_id = :dept_id
                   AND dept_name = :dept_name
                   AND dept_year = :dept_year )
				";
				$statement = $connect->prepare($query);
				if($statement->execute($data))
				{
					if($statement->rowCount() > 0)
					{
						$output = array(
							'success'		=>	'Data Added Successfully',
						);
					}
					else
					{
						$output = array(
							'error'					=>	true,
							'error_dept_name'		=>	'Department Already Exists or Check Department Id'
						);
					}
				}
			}
			if($_POST["action"] == "Edit")
			{
				$data = array(
					':dept_name'			=>	$dept_name,
					':dept_id'				=>	$dept_id,
					':dept_year' => $dept_year
				);

				$query = "
				UPDATE tbl_department SET dept_name = :dept_name, dept_year = :dept_year WHERE dept_id = :dept_id
				";
				$statement = $connect->prepare($query);
				if($statement->execute($data))
				{
					$output = array(
						'success'		=>	'Data Updated Successfully',
					);
				}
			}
		}
	}

	if($_POST["action"] == "edit_fetch")
	{
		$query = '
		SELECT * FROM tbl_department WHERE dept_id = "'.$_POST["dept_id"].'"'
		;
		$statement = $connect->prepare($query);
		if($statement->execute())
		{
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				$output = array(
					"dept_name" => $row["dept_name"],
					"dept_id" => $row["dept_id"],
					"dept_year" => $row["dept_year"]
				);
			}
		}
	}

	if($_POST["action"] == "delete")
	{
		$query = "
		DELETE FROM tbl_department 
		WHERE dept_id = '".$_POST["dept_id"]."'
		";
		$statement = $connect->prepare($query);
		if($statement->execute())
		{
			echo 'Data Deleted Successfully';
		}
	}

	echo json_encode($output);
}

?>