<?php
session_start();
if(isset($_POST['username'])){
	$username = $_POST['username'];
	$_SESSION['username'] = $username;
}
$keyword = $_POST['keyword'];
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
$query2 = "Select * From customer Where cname = '$username'";
$result1 = mysqli_query($connection,$query2);
if(!$result1) {
	die("Database Query Failed.");
	echo "Error: " . $sql . "<br>" . mysqli_error($connection);
}
if(mysqli_num_rows($result1) == 0) {
	echo $username;
	echo " <br> Unauthorized user, please query again";
} else {



// Query to the database
if(empty($keyword)){
$query = "Select * FROM product";
} else {
$query = "Select * FROM product WHERE pdescription LIKE '%" . $keyword . "%'";
}

$result = mysqli_query($connection, $query);
if(!$result) {
	die("Database query failed.");
}
?>

<!-- Building the list-->

<form action="order.php" method="get">
<?php
while($row = mysqli_fetch_assoc($result)) {


	echo $row["pname"] . "<br>";
	echo $row["pdescription"] . "<br>";
	echo $row["pprice"] . "<br>";
	echo $row["pstatus"] . "<br>";?>
	
	quantity : <input type="text" name=<?php echo rawurlencode($row['pname']); ?> value=""> <br>
	<?php
	echo "<hr>"; 
	
	
}
?>
<input type="submit" >
</form>
<?php
}
?>

<?php 
//releasing the data
mysqli_free_result($result);
?>



<?php
//closing database
mysqli_close($connection);
?>
