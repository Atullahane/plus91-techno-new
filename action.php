<?php
include("connect.php");

require_once 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);



if(isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$query = "
		INSERT INTO patients_list (Name, Age, City, State, Country, Date_of_birth, Blood_Group) VALUES ('".$_POST["Name"]."', '".$_POST["Age"]."', '".$_POST["City"]."', '".$_POST["State"]."', '".$_POST["Country"]."', '".$_POST["Date_of_birth"]."', '".$_POST["Blood_Group"]."')
		";
		$statement = $conn->prepare($query);
		$statement->execute();
		echo '<p>Data Inserted...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		// $query = "
		// SELECT * FROM patients_list WHERE id = '".$_POST["id"]."'
		// ";


		// $statement = $conn->prepare($query);
		// $statement->execute();
		// $result = $statement->fetchAll();

		$sql = "SELECT * FROM patients_list WHERE id = '".$_POST["id"]."'";
		$stmt = $conn->query($sql);

		while (($row = $stmt->fetchAssociative()) !== false)
		//foreach($result as $row)
		{
			$output['Name'] = $row['Name'];
			$output['Age'] = $row['Age'];
			$output['City'] = $row['City'];
			$output['State'] = $row['State'];
			$output['Country'] = $row['Country'];
			$output['Date_of_birth'] = $row['Date_of_birth'];
			$output['Blood_Group'] = $row['Blood_Group'];
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE patients_list 
		SET Name = '".$_POST["Name"]."', 
		Age = '".$_POST["Age"]."' ,
		City = '".$_POST["City"]."' ,
		State = '".$_POST["State"]."' ,
		Country = '".$_POST["Country"]."' ,
		Date_of_birth = '".$_POST["Date_of_birth"]."' ,
		Blood_Group = '".$_POST["Blood_Group"]."' 
		WHERE id = '".$_POST["hidden_id"]."'
		";
		$statement = $conn->prepare($query);
		$statement->execute();
		echo '<p>Data Updated</p>';
	}
	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM patients_list WHERE id = '".$_POST["id"]."'";
		$statement = $conn->prepare($query);
		$statement->execute();
		echo '<p>Data Deleted</p>';
	}
}

?>