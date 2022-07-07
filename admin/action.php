<?php 

//action.php


//new comment
include '../database_connection.php';

if(isset($_POST["action"]))
{ 
	if($_POST["action"] == 'search_book_isbn')
	{
		$query = "
		SELECT product_id_number, product_name FROM lms_book 
		WHERE product_id_number LIKE '%".$_POST["request"]."%' 
		AND product_status = 'Enable'
		";

		$result = $connect->query($query);

		$data = array();

		foreach($result as $row)
		{
			$data[] = array(
				'isbn_no'		=>	str_replace($_POST["request"], '<b>'.$_POST["request"].'</b>', $row["product_id_number"]),
				'product_name'		=>	$row['product_name']
			);
		}
		echo json_encode($data);
	}

	if($_POST["action"] == 'search_user_id')
	{
		$query = "
		SELECT user_unique_id, user_name FROM lms_user 
		WHERE user_unique_id LIKE '%".$_POST["request"]."%' 
		AND user_status = 'Enable'
		";

		$result = $connect->query($query);

		$data = array();

		foreach($result as $row)
		{
			$data[] = array(
				'user_unique_id'	=>	str_replace($_POST["request"], '<b>'.$_POST["request"].'</b>', $row["user_unique_id"]),
				'user_name'			=>	$row["user_name"]
			);
		}

		echo json_encode($data);
	}
}

?>