<?php

//author.php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

$error = '';

if(isset($_POST["add_party"]))
{
	$formdata = array();

	if(empty($_POST["party_name"]))
	{
		$error .= '<li>Author Name is required</li>';
	}
	else
	{
		$formdata['party_name'] = trim($_POST["party_name"]);
	}

	if($error == '')
	{
		$query = "
		SELECT * FROM lms_author 
        WHERE party_name = '".$formdata['party_name']."'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		if($statement->rowCount() > 0)
		{
			$error = '<li>Author Name Already Exists</li>';
		}
		else
		{
			$data = array(
				':party_name'			=>	$formdata['party_name'],
				':party_status'		=>	'Enable',
				':party_created_on'	=>	get_date_time($connect)
			);

			$query = "
			INSERT INTO lms_author 
            (party_name, party_status, party_created_on) 
            VALUES (:party_name, :party_status, :party_created_on)
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:author.php?msg=add');
		}
	}
}

if(isset($_POST["edit_author"]))
{
	$formdata = array();

	if(empty($_POST["party_name"]))
	{
		$error .= '<li>Author Name is required</li>';
	}
	else
	{
		$formdata['party_name'] = trim($_POST['party_name']);
	}

	if($error == '')
	{
		$party_id = convert_data($_POST['party_id'], 'decrypt');

		$query = "
		SELECT * FROM lms_author 
        WHERE party_name = '".$formdata['party_name']."' 
        AND party_id != '".$party_id."'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		if($statement->rowCount() > 0)
		{
			$error = '<li>Author Name Already Exists</li>';
		}
		else
		{
			$data = array(
				':party_name'		=>	$formdata['party_name'],
				':party_updated_on'=>	get_date_time($connect),
				':party_id'		=>	$party_id
			);	

			$query = "
			UPDATE lms_author 
            SET party_name = :party_name, 
            party_updated_on = :party_updated_on  
            WHERE party_id = :party_id
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:author.php?msg=edit');
		}
	}
}

if(isset($_GET["action"], $_GET["code"], $_GET["status"]) && $_GET["action"] == 'delete')
{
	$party_id = $_GET["code"];

	$status = $_GET["status"];

	$data = array(
		':party_status'			=>	$status,
		':party_updated_on'		=>	get_date_time($connect),
		':party_id'				=>	$party_id
	);

	$query = "
	 UPDATE lms_author 
    SET party_status = :party_status, 
    party_updated_on = :party_updated_on 
    WHERE party_id = :party_id
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	header('location:author.php?msg='.strtolower($status).'');
}


$query = "
	SELECT * FROM lms_author 
    ORDER BY party_name ASC
";

$statement = $connect->prepare($query);

$statement->execute();

include '../header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Party Management</h1>
	<?php 

	if(isset($_GET["action"]))
	{
		if($_GET["action"] == "add")
		{
	?>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="author.php">Party Management</a></li>
        <li class="breadcrumb-item active">Add Party</li>
    </ol>

    <div class="row">
    	<div class="col-md-6">
    		<?php 

    		if($error != '')
    		{
    			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    		}

    		?>
    		<div class="card mb-4">
    			<div class="card-header">
    				<i class="fas fa-user-plus"></i> Add New Party
                </div>
                <div class="card-body">
                	<form method="post">
                		<div class="mb-3">
                			<label class="form-label">Party Name</label>
                			<input type="text" name="party_name" id="party_name" class="form-control" />
                		</div>
                		<div class="mt-4 mb-0">
                			<input type="submit" name="add_party" class="btn btn-success" value="Add" />
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
			$party_id = convert_data($_GET["code"], 'decrypt');

			if($party_id > 0)
			{
				$query = "
				SELECT * FROM lms_author 
                WHERE party_id = '$party_id'
				";

				$party_result = $connect->query($query);

				foreach($party_result as $party_row)
				{
	?>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="author.php">Party Management</a></li>
        <li class="breadcrumb-item active">Edit Party</li>
    </ol>

    <div class="row">
    	<div class="col-md-6">
    		<div class="card mb-4">
    			<div class="card-header">
    				<i class="fas fa-user-edit"></i> Edit Party Details
    			</div>
    			<div class="card-body">
    				<form method="post">
    					<div class="mb-3">
    						<label class="form-label">Party Name</label>
    						<input type="text" name="party_name" id="party_name" class="form-control" value="<?php echo $party_row['party_name']; ?>" />
    					</div>
    					<div class="mt-4 mb-0">
    						<input type="hidden" name="party_id" value="<?php echo $_GET['code']; ?>" />
    						<input type="submit" name="edit_author" class="btn btn-primary" value="Edit" />
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
		<li class="breadcrumb-item active">Party Management</li>
	</ol>
	<?php 

	if(isset($_GET["msg"]))
	{
		if($_GET["msg"] == 'add')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New Author Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET['msg'] == 'edit')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Author Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET["msg"] == 'disable')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Author Status Change to Disable <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}

		if($_GET["msg"] == 'enable')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Author Status Change to Enable <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
	}

	?>
	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Party Management
				</div>
				<div class="col col-md-6" align="right">
					<a href="author.php?action=add" class="btn btn-success btn-sm">Add</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Party Name</th>
						<th>Status</th>
						<th>Created On</th>
						<th>Updated On</th>
						<th>Action</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Party Name</th>
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
						$party_status = '';
						if($row['party_status'] == 'Enable')
						{
							$party_status = '<div class="badge bg-success">Enable</div>';
						}
						else
						{
							$party_status = '<div class="badge bg-danger">Disable</div>';
						}
						
						echo '
						<tr>
							<td>'.$row["party_name"].'</td>
							<td>'.$party_status.'</td>
							<td>'.$row["party_created_on"].'</td>
							<td>'.$row["party_updated_on"].'</td>
							<td>
								<a href="author.php?action=edit&code='.convert_data($row["party_id"]).'" class="btn btn-sm btn-primary">Edit</a>
								<button type="button" name="delete_button" class="btn btn-danger btn-sm" onclick="delete_data(`'.$row["party_id"].'`, `'.$row["party_status"].'`)">Delete</button>
							</td>
						</tr>
						';
					}
				}
				else
				{
					echo '
					<tr>
						<td colspan="4" class="text-center">No Data Found</td>
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

			if(confirm("Are you sure you want to "+new_status+" this Author?"))
			{
				window.location.href = "author.php?action=delete&code="+code+"&status="+new_status+"";
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