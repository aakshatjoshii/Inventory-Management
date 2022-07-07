<?php

//book.php

include '../database_connection.php';

include '../function.php';


if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

$error = '';

if(isset($_POST["add_book"]))
{
	$formdata = array();

	if(empty($_POST["product_name"]))
	{
		$error .= '<li>Product Name is required</li>';
	}
	else
	{
		$formdata['product_name'] = trim($_POST["product_name"]);
	}

	if(empty($_POST["book_category"]))
	{
		$error .= '<li>Product Category is required</li>';
	}
	else
	{
		$formdata['book_category'] = trim($_POST["book_category"]);
	}

	if(empty($_POST["book_author"]))
	{
		$error .= '<li>Party is required</li>';
	}
	else
	{
		$formdata['book_author'] = trim($_POST["book_author"]);
	}

	if(empty($_POST["book_location"]))
	{
		$error .= '<li>Book Location Rack is required</li>';
	}
	else
	{
		$formdata['book_location'] = trim($_POST["book_location"]);
	}

	if(empty($_POST["product_id_number"]))
	{
		$error .= '<li>Product ID Number is required</li>';
	}
	else
	{
		$formdata['product_id_number'] = trim($_POST["product_id_number"]);
	}
	if(empty($_POST["product_no_of_item"]))
	{
		$error .= '<li>Book No. of Copy is required</li>';
	}
	else
	{
		$formdata['product_no_of_item'] = trim($_POST["product_no_of_item"]);
	}




if(empty($_POST["product_unit"]))
	{
		$error .= '<li>Unit is required</li>';
	}
	else
	{
		$formdata['product_unit'] = trim($_POST["product_unit"]);
	}
	
	if(empty($_POST["product_price"]))
	{
		$error .= '<li>Price is required</li>';
	}
	else
	{
		$formdata['product_price'] = trim($_POST["product_price"]);
	}if(empty($_POST["product_amount"]))
	{
		$error .= '<li>Total Amount  is required</li>';
	}
	else
	{
		$formdata['product_amount'] = trim($_POST["product_amount"]);
	}if(empty($_POST["product_invoice"]))
	{
		$error .= '<li>Invoice No is required</li>';
	}
	else
	{
		$formdata['product_invoice'] = trim($_POST["product_invoice"]);
	}





	if($error == '')
	{
		$data = array(
			':book_category'		=>	$formdata['book_category'],
			':book_author'			=>	$formdata['book_author'],
			':book_location'	=>	$formdata['book_location'],
			':product_name'			=>	$formdata['product_name'],
			':product_id_number'		=>	$formdata['product_id_number'],
			':product_no_of_item'		=>	$formdata['product_no_of_item'],

			':product_unit'		=>	$formdata['product_unit'],
			':product_price'		=>	$formdata['product_price'],
			':product_amount'		=>	$formdata['product_amount'],
			':product_invoice'		=>	$formdata['product_invoice'],

			':product_status'			=>	'Enable',
			':product_added_on'		=>	get_date_time($connect)
		);

		$query = "
		INSERT INTO lms_book 
        (book_category, book_author, book_location, product_name, product_id_number, product_no_of_item,product_unit, product_price, product_amount , product_invoice, product_status, product_added_on) 
        VALUES (:book_category, :book_author, :book_location, :product_name, :product_id_number, :product_no_of_item,:product_unit, :product_price, :product_amount, :product_invoice, :product_status, :product_added_on)
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		header('location:book.php?msg=add');
	}
}

if(isset($_POST["edit_book"]))
{
	$formdata = array();

	if(empty($_POST["product_name"]))
	{
		$error .= '<li>Product Name is required</li>';
	}
	else
	{
		$formdata['product_name'] = trim($_POST["product_name"]);
	}

	if(empty($_POST["book_category"]))
	{
		$error .= '<li>Category is required</li>';
	}
	else
	{
		$formdata['book_category'] = trim($_POST["book_category"]);
	}

	if(empty($_POST["book_author"]))
	{
		$error .= '<li>Party is required</li>';
	}
	else
	{
		$formdata['book_author'] = trim($_POST["book_author"]);
	}

	if(empty($_POST["book_location"]))
	{
		$error .= '<li>Location  is required</li>';
	}
	else
	{
		$formdata['book_location'] = trim($_POST["book_location"]);
	}

	if(empty($_POST["product_id_number"]))
	{
		$error .= '<li>Product ID Number is required</li>';
	}
	else
	{
		$formdata['product_id_number'] = trim($_POST["product_id_number"]);
	}
	if(empty($_POST["product_no_of_item"]))
	{
		$error .= '<li> No. of Item quantity is required</li>';
	}
	else
	{
		$formdata['product_no_of_item'] = trim($_POST["product_no_of_item"]);
	}
	if(empty($_POST["product_unit"]))
	{
		$error .= '<li>Unit is required</li>';
	}
	else
	{
		$formdata['product_unit'] = trim($_POST["product_unit"]);
	}
	
	if(empty($_POST["product_price"]))
	{
		$error .= '<li>Price is required</li>';
	}
	else
	{
		$formdata['product_price'] = trim($_POST["product_price"]);
	}if(empty($_POST["product_amount"]))
	{
		$error .= '<li>Total Amount  is required</li>';
	}
	else
	{
		$formdata['product_amount'] = trim($_POST["product_amount"]);
	}if(empty($_POST["product_invoice"]))
	{
		$error .= '<li>Invoice No is required</li>';
	}
	else
	{
		$formdata['product_invoice'] = trim($_POST["product_invoice"]);
	}

	if($error == '')
	{
		$data = array(
			':book_category'		=>	$formdata['book_category'],
			':book_author'			=>	$formdata['book_author'],
			':book_location'	=>	$formdata['book_location'],
			':product_name'			=>	$formdata['product_name'],
			':product_id_number'		=>	$formdata['product_id_number'],
			':product_no_of_item'		=>	$formdata['product_no_of_item'],
			':product_unit'		=>	$formdata['product_unit'],
			':product_price'		=>	$formdata['product_price'],
			':product_amount'		=>	$formdata['product_amount'],
			':product_invoice'		=>	$formdata['product_invoice'],

			':product_updated_on'		=>	get_date_time($connect),
			':product_id'				=>	$_POST["product_id"]
		);
		$query = "
		UPDATE lms_book 
        SET book_category = :book_category, 
        book_author = :book_author, 
        book_location = :book_location, 
        product_name = :product_name, 
        product_id_number = :product_id_number, 
        product_no_of_item = :product_no_of_item, 
		product_unit = :product_unit, 
        product_price = :product_price, 
        product_amount = :product_amount, 
        product_invoice = :product_invoice, 

        product_updated_on = :product_updated_on 
        WHERE product_id = :product_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		header('location:book.php?msg=edit');
	}
}

if(isset($_GET["action"], $_GET["code"], $_GET["status"]) && $_GET["action"] == 'delete')
{
	$product_id = $_GET["code"];
	$status = $_GET["status"];

	$data = array(
		':product_status'		=>	$status,
		':product_updated_on'	=>	get_date_time($connect),
		':product_id'			=>	$product_id
	);

	$query = "
	UPDATE lms_book 
    SET product_status = :product_status, 
    product_updated_on = :product_updated_on 
    WHERE product_id = :product_id
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	header('location:book.php?msg='.strtolower($status).'');
}


$query = "
	SELECT * FROM lms_book 
    ORDER BY product_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();


include '../header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Book Management</h1>
	<?php 
	if(isset($_GET["action"]))
	{
		if($_GET["action"] == 'add')
		{
	?>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="book.php">Product Management</a></li>
        <li class="breadcrumb-item active">Add Product</li>
    </ol>

    <?php 

    if($error != '')
    {
    	echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    ?>

    <div class="card mb-4">
    	<div class="card-header">
    		<i class="fas fa-user-plus"></i> Add New Product
        </div>
        <div class="card-body">
        	<form method="post">
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Product Name</label>
        					<input type="text" name="product_name" id="product_name" class="form-control" />
        				</div>
        			</div>
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Select Party</label>
        					<select name="book_author" id="book_author" class="form-control">
        						<?php echo fill_author($connect); ?>
        					</select>
        				</div>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Select Category</label>
        					<select name="book_category" id="book_category" class="form-control">
        						<?php echo fill_category($connect); ?>
        					</select>
        				</div>
        			</div>
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Select Location</label>
        					<select name="book_location" id="book_location" class="form-control">
        						<?php echo fill_location_rack($connect); ?>
        					</select>
        				</div>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Book ID Number</label>
        					<input type="text" name="product_id_number" id="product_id_number" class="form-control" />
        				</div>
        			</div>
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">No. of Item</label>
        					<input type="number" name="product_no_of_item" id="product_no_of_item" step="1" class="form-control" />
        				</div>
        			</div>



					<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Unit</label>
        					<input type="text" name="product_unit" id="product_unit" class="form-control" />
        				</div>
        			</div>
        			<div class="col-md-6">
					<div class="mb-3">
        					<label class="form-label">Price</label>
        					<input type="text" name="product_price" id="product_price" class="form-control" />
        				</div>
        			</div>
        		</div>



				<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Amount</label>
        					<input type="text" name="product_amount" id="product_amount" class="form-control" />
        				</div>
        			</div>
        			<div class="col-md-6">
					<div class="mb-3">
        					<label class="form-label">Invoice No</label>
        					<input type="text" name="product_invoice" id="product_invoice" class="form-control" />
        				</div>
        			</div>
        		</div>





        		</div>

        		<div class="mt-4 mb-3 text-center">
        			<input type="submit" name="add_book" class="btn btn-success" value="Add" />
        		</div>
        	</form>
        </div>
    </div>

	<?php 
		}
		else if($_GET["action"] == 'edit')
		{
			$product_id = convert_data($_GET["code"], 'decrypt');

			if($product_id > 0)
			{
				$query = "
				SELECT * FROM lms_book 
                WHERE product_id = '$product_id'
				";

				$book_result = $connect->query($query);

				foreach($book_result as $book_row)
				{
	?>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="book.php">Product Management</a></li>
        <li class="breadcrumb-item active">Edit Product</li>
    </ol>
    <div class="card mb-4">
    	<div class="card-header">
    		<i class="fas fa-user-plus"></i> Edit Product Details
       	</div>
       	<div class="card-body">
       		<form method="post">
       			<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Product Name</label>
       						<input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo $book_row['product_name']; ?>" />
       					</div>
       				</div>
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Select Party</label>
       						<select name="book_author" id="book_author" class="form-control">
       							<?php echo fill_author($connect); ?>
       						</select>
       					</div>
       				</div>
       			</div>
       			<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Select Category</label>
       						<select name="book_category" id="book_category" class="form-control">
       							<?php echo fill_category($connect); ?>
       						</select>
       					</div>
       				</div>
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Select Location</label>
       						<select name="book_location" id="book_location" class="form-control">
       							<?php echo fill_location_rack($connect); ?>
       						</select>
       					</div>
       				</div>
       			</div>
       			<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Product ID Number</label>
       						<input type="text" name="product_id_number" id="product_id_number" class="form-control" value="<?php echo $book_row['product_id_number']; ?>" />
       					</div>
       				</div>
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">No. of item</label>
       						<input type="number" name="product_no_of_item" id="product_no_of_item" class="form-control" step="1" value="<?php echo $book_row['product_no_of_item']; ?>" />
       					</div>
       				</div>
       			</div>


				   <div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Unit</label>
       						<input type="text" name="product_unit" id="product_unit" class="form-control" value="<?php echo $book_row['product_unit']; ?>" />
       					</div>
       				</div>
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Price</label>
       						<input type="number" name="product_price" id="product_price" class="form-control" step="1" value="<?php echo $book_row['product_price']; ?>" />
       					</div>
       				</div>
       			</div>



				   <div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Amount</label>
       						<input type="text" name="product_amount" id="product_amount" class="form-control" value="<?php echo $book_row['product_amount']; ?>" />
       					</div>
       				</div>
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Invoice No</label>
       						<input type="text0
							
							" name="product_invoice" id="product_invoice" class="form-control" step="1" value="<?php echo $book_row['product_invoice']; ?>" />
       					</div>
       				</div>
       			</div>



       			<div class="mt-4 mb-3 text-center">
       				<input type="hidden" name="product_id" value="<?php echo $book_row['product_id']; ?>" />
       				<input type="submit" name="edit_book" class="btn btn-primary" value="Edit" />
       			</div>
       		</form>
       		<script>
       			document.getElementById('book_author').value = "<?php echo $book_row['book_author']; ?>";
       			document.getElementById('book_category').value = "<?php echo $book_row['book_category']; ?>";
       			document.getElementById('book_location').value = "<?php echo $book_row['book_location']; ?>";
       		</script>
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
		<li class="breadcrumb-item active">Product Management</li>
	</ol>
	<?php 

	if(isset($_GET["msg"]))
	{
		if($_GET["msg"] == 'add')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New Book Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET['msg'] == 'edit')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Book Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET["msg"] == 'disable')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Book Status Change to Disable <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET['msg'] == 'enable')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Book Status Change to Enable <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
	}

	?>
	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Product Management
                </div>
                <div class="col col-md-6" align="right">
                	<a href="book.php?action=add" class="btn btn-success btn-sm">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
        	<table id="datatablesSimple">
        		<thead> 
        			<tr> 
        				<th>Product Name</th>
        				<th>ID No.</th>
        				<th>Category</th>
        				<th>Party</th>
        				<th>Location</th>
        				<th>No. of Item</th>
						<th>Unit</th>
        				<th>Price</th>
        				<th>Amount</th>
        				<th>Invoice No</th>
        				<th>Status</th>
        				<th>Created On</th>
        				<th>Updated On</th>
        				<th>Action</th>
        			</tr>
        		</thead>
        		<tfoot>
        			<tr>
        				<th>Product Name</th>
        				<th>ID No.</th>
        				<th>Category</th>
        				<th>Party</th>
        				<th>Location</th>
        				<th>No. of Item</th>
						<th>Unit</th>
        				<th>Price</th>
        				<th>Amount</th>
        				<th>Invoice No</th>

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
        				$product_status = '';
        				if($row['product_status'] == 'Enable')
        				{
        					$product_status = '<div class="badge bg-success">Enable</div>';
        				}
        				else
        				{
        					$product_status = '<div class="badge bg-danger">Disable</div>';
        				}
        				echo '
        				<tr>
        					<td>'.$row["product_name"].'</td>
        					<td>'.$row["product_id_number"].'</td>
        					<td>'.$row["book_category"].'</td>
        					<td>'.$row["book_author"].'</td>
        					<td>'.$row["book_location"].'</td>
        					<td>'.$row["product_no_of_item"].'</td>
							<td>'.$row["product_unit"].'</td>
        					<td>'.$row["product_price"].'</td>
        					<td>'.$row["product_amount"].'</td>
        					<td>'.$row["product_invoice"].'</td>

        					<td>'.$product_status.'</td>
        					<td>'.$row["product_added_on"].'</td>
        					<td>'.$row["product_updated_on"].'</td>
        					<td>
        						<a href="book.php?action=edit&code='.convert_data($row["product_id"]).'" class="btn btn-sm btn-primary">Edit</a>
        						<button type="button" name="delete_button" class="btn btn-danger btn-sm" onclick="delete_data(`'.$row["product_id"].'`, `'.$row["product_status"].'`)">Delete</button>
        					</td>
        				</tr>
        				';
        			}
        		}
        		else
        		{
        			echo '
        			<tr>
        				<td colspan="10" class="text-center">No Data Found</td>
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
    			window.location.href = "book.php?action=delete&code="+code+"&status="+new_status+"";
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