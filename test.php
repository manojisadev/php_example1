<?php
session_start();
if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
} 

?>

<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "marketplace";
$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);


//Testing connection
if(mysqli_connect_error()) {
	die("Database connection failed" . mysqli_connect_error() . "(" . mysqli_connect_errno().")"
		);
}

?>

<?php 
echo "hi";
$query = "Select * FROM product";
$result = mysqli_query($connection, $query);
if(!$result) {
	die("Database query failed.");
} else {
	$row = mysqli_fetch_assoc($result);
	echo "<br>";
	echo mysqli_num_rows($result); 
	echo $row["pname"] . "<br>";
}
?>