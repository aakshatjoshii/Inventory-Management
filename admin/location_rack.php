<?php

//location.php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

$error = '';

if(isset($_POST["add_location"]) )
{
	$formdata = array();

	if(empty($_POST["location_name"]) || empty($_POST["floor_name"]) || empty($_POST["room_no"]))
	{
		$error .= '<li>All Fields are required</li>';
	}
	else
	{
		$formdata['location_name'] = trim($_POST["location_name"]);
		$formdata['floor_name'] = trim($_POST["floor_name"]);
		$formdata['room_no'] = trim($_POST["room_no"]);

	}

	if($error == '')
	{
		$query = "
		SELECT * FROM lms_location 
        WHERE location_name = '".$formdata['location_name']."' AND floor_name = '".$formdata['floor_name']."' AND room_no = '".$formdata['room_name']."'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		if($statement->rowCount() > 0)
		{
			$error = '<li>Field Already Exists</li>';
		}
		else
		{
			$data = array(
				':location_name'		=>	$formdata['location_name'],
				':floor_name'		=>	$formdata['floor_name'],
				':room_no'		=>	$formdata['room_no'],
				':location_status'		=>	'Enable',
				':location_created_on'	=>	get_date_time($connect)
			);

			$query = "
			INSERT INTO lms_location 
            (location_name,floor_name,room_no, location_status, location_created_on) 
            VALUES (:location_name, :floor_name, :room_no, :location_status, :location_created_on)
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:location_rack.php?msg=add');
		}
	}
}

if(isset($_POST["edit_location"]))
{
	$formdata = array();

	if(empty($_POST["location_name"]) || empty($_POST["floor_name"]) || empty($_POST["room_no"]))
	{
		$error .= '<li>All fields are required</li>';
	}
	else
	{
		$formdata['location_name'] = trim($_POST["location_name"]);
		$formdata['floor_name'] = trim($_POST["floor_name"]);
		$formdata['room_no'] = trim($_POST["room_no"]);

	}

	if($error == '')
	{
		$location_id = convert_data($_POST["location_id"], 'decrypt');

		$query = "
		SELECT * FROM lms_location 
	        WHERE location_name = '".$formdata['location_name']."' AND floor_name = '".$formdata['floor_name']."' AND room_no = '".$formdata['room_name']."'
	        AND location_id != '".$location_id."'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		if($statement->rowCount() > 0)
		{
			$error = '<li>Field Already Exists</li>';
		}
		else
		{
			$data = array(
				':location_name'		=>	$formdata['location_name'],
				':floor_name'		=>	$formdata['floor_name'],
				':room_no'		=>	$formdata['room_no'],
				':location_updated_on'	=>	get_date_time($connect),
				':location_id'			=>	$location_id
			);

			$query = "
			UPDATE lms_location 
	            SET location_name = :location_name, floor_name = :floor_name , room_no =:room_no ,
	            location_updated_on = :location_updated_on  
	            WHERE location_id = :location_id
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:location_rack.php?msg=edit');
		}
	}
}

if(isset($_GET["action"], $_GET["code"], $_GET["status"]) && $_GET["action"]=='delete')
{
	$location_id = $_GET["code"];

	$status = $_GET["status"];

	$data = array(
		':location_status'			=>	$status,
		':location_updated_on'		=>	get_date_time($connect),
		':location_id'				=>	$location_id
	);
	$query = "
	UPDATE lms_location 
    SET location_status = :location_status, 
    location_updated_on = :location_updated_on 
    WHERE location_id = :location_id
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	header('location:location_rack.php?msg='.strtolower($status).'');

}


$query = "
	SELECT * FROM lms_location 
    ORDER BY location_name ASC
";

$statement = $connect->prepare($query);

$statement->execute();

include '../header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Location Management</h1>
	<?php 

	if(isset($_GET["action"]))
	{
		if($_GET["action"] == 'add')
		{
		?>
	
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="location_rack.php">Location Management</a></li>
		<li class="breadcrumb-item active">Add Location</li>
	</ol>

	<div class="row">
		<div class="col-md-6">
			<?php 

			if($error != '')
			{
				echo '
				<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
				';
			}

			?>
			<div class="card mb-4">
				<div class="card-header">
					<i class="fas fa-user-plus"></i> Add New Location
                </div>
                <div class="card-body">
                	<form method="post">
                		<div class="mb-3">
                			<label class="form-label">Location Name</label>
                			<input type="text" name="location_name" id="location_name" class="form-control" />
                		</div>

						<div class="mb-3">
                			<label class="form-label">Floor Name</label>
                			<input type="text" name="floor_name" id="floor_name" class="form-control" />
                		</div>

						<div class="mb-3">
                			<label class="form-label">Room No</label>
                			<input type="text" name="room_no" id="room_no" class="form-control" />
                		</div>


                		<div class="mt-4 mb-0">
                			<input type="submit" name="add_location" class="btn btn-success" value="Add" />
                		</div>
                	</form>
                </div>
            </div>
		</div>
	</div>	

		<?php
		}
		else if($_GET["action"] == 'edit')
		{
			$location_id = convert_data($_GET["code"], 'decrypt');

			if($location_id > 0)
			{
				$query = "
				SELECT * FROM lms_location 
                WHERE location_id = '$location_id'
				";

				$location_result = $connect->query($query);

				foreach($location_result as $location_row)
				{
	?>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="location_rack.php">Location Management</a></li>
        <li class="breadcrumb-item active">Edit Location</li>
    </ol>
    <div class="row">
    	<div class="col-md-6">
    		<div class="card mb-4">
    			<div class="card-header">
    				<i class="fas fa-user-edit"></i> Edit Location Details
                </div>
                <div class="card-body">
                	<form method="post">
                		<div class="mb-3">
                			<label class="form-label">Location Name</label>
                			<input type="text" name="location_name" id="location_name" class="form-control" value="<?php echo $location_row["location_name"]; ?>" />
                		</div>

						<div class="mb-3">
                			<label class="form-label">Floor Name</label>
                			<input type="text" name="floor_name" id="floor_name" class="form-control" value="<?php echo $location_row["floor_name"]; ?>" />
                		</div>

						<div class="mb-3">
                			<label class="form-label">Room No</label>
                			<input type="text" name="room_no" id="room_no" class="form-control" value="<?php echo $location_row["room_no"]; ?>" />
                		</div>


                		<div class="mt-4 mb-0">
                			<input type="hidden" name="location_id" value="<?php echo $_GET['code']; ?>" />
                			<input type="submit" name="edit_location" class="btn btn-primary" value="Edit" />
                		</div>
                	</form>
                </div>
            </div>

    	</div>
    </div>

	<?php 
				}
			}
		}
	}
	else
	{

	?>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Location Management</li>
	</ol>
		<?php 

		if(isset($_GET["msg"]))
		{
			if($_GET["msg"] == 'add')
			{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New Location Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			if($_GET["msg"] == 'edit')
			{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Location Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			if($_GET["msg"] == 'disable')
			{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Location Status Change to Disable <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			if($_GET["msg"] == 'enable')
			{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Location Status Change to Enable <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}
		}

		?>
	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Location Management
				</div>
				<div class="col col-md-6" align="right">
					<a href="location_rack.php?action=add" class="btn btn-success btn-sm">Add</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Location Name</th>
						<th>Floor Name</th>
						<th>Room No</th>
                        <th>Status</th>
                        <th>Created On</th>
                        <th>Updated On</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Location Name</th>
						<th>Floor Name</th>
						<th>Room No</th>
                        <th>Status</th>
                        <th>Created On</th>
                        <th>Updated On</th>
                        <th>Action</th>
					</tr>
				</tfoot>
				<tbody>
				<?php 
				if($statement->rowCount() > 0)
				{
					foreach($statement->fetchAll() as $row)
					{
						$location_status = '';
						if($row['location_status'] == 'Enable')
						{
							$location_status = '<div class="badge bg-success">Enable</div>';
						}
						else
						{
							$location_status = '<div class="badge bg-danger">Disable</div>';
						}

						echo '
						<tr>
							<td>'.$row["location_name"].'</td>
							<td>'.$row["floor_name"].'</td>
							<td>'.$row["room_no"].'</td>
							<td>'.$location_status.'</td>
							<td>'.$row["location_created_on"].'</td>
							<td>'.$row["location_updated_on"].'</td>
							<td>
								<a href="location.php?action=edit&code='.convert_data($row["location_id"]).'" class="btn btn-sm btn-primary">Edit</a>
								<button type="button" name="delete_button" class="btn btn-danger btn-sm" onclick="delete_data(`'.$row["location_id"].'`, `'.$row["location_status"].'`)">Delete</button>
							</td>
						</tr>
						';

					}
				}
				else
				{
					echo '
					<tr>
						<td colspan="5" class="text-center">No Data Found</td>
					</tr>
					';
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
	<script>

		function delete_data(code, status)
		{
			var new_status = 'Enable';

			if(status == 'Enable')
			{
				new_status = 'Disable';
			}

			if(confirm("Are you sure you want to "+new_status+" this Category?"))
			{
				window.location.href = "location_rack.php?action=delete&code="+code+"&status="+new_status+""
			}
		}

	</script>

	<?php 

	}

	?>

</div>



<?php 

include '../footer.php';

?>