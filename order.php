<?php
session_start();
if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
} 

?>

<?php 

foreach($_GET as $key=>$value){
	if(!empty($value) && isset($value)) {
    echo urldecode($key), ' => ', $value, "<br/>"; }
} 

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

foreach($_GET as $key=>$value){
	if(!empty($value) && isset($value)) {
		//Building query
		$test = urldecode($key);
		$query = "Select * FROM product AS p WHERE p.pstatus = 'available' AND  p.pname = '$test'" ;
		//////REMOVE CNAME
		$result = mysqli_query($connection, $query);
		
		if(!$result) {
		die("Database query failed.");
		} elseif(mysqli_num_rows($result) == 0) { echo "<br> Sorry the product $test is not available at this moment. ";}

		else {
		
		//echo mysqli_result($result,1);

		while($row = mysqli_fetch_assoc($result)) {

		
		
		if(mysqli_num_rows($result) > 0) {
			$query2 = "Select * FROM product As P INNER JOIN purchase AS PU ON P.pname = PU.pname INNER JOIN customer AS C ON C.cname = PU.cname where P.pname = '$test' AND PU.status = 'pending' AND C.cname = '$username' " ;
			$result1 = mysqli_query($connection,$query2);

			if(!$result1) {
				die("Database query2 failed.");
			} else {

				/*echo $row["pname"] . "<br>";	
				echo $row["pstatus"] . "<br>";			
				echo "<hr>"; */
				$row2 = mysqli_fetch_assoc($result1);
				$mysqltime = time();
				if(mysqli_num_rows($result1) == 0) {
					echo "<br> Creating a new order since no existing pending orders were found for the user $username.";
					$price = $row["pprice"] * $value;
					echo $mysqltime;
					$query3 = "INSERT INTO purchase (cname,pname,putime,quantity,puprice,status) VALUES ('$username','$test',now(),'$value','$price','pending');";
					if(mysqli_query($connection,$query3)) {
						echo " <br> The order has successfully been placed";
					} else {
						echo "Error: " . $sql . "<br>" . mysqli_error($connection);
					}

				} else {
					
						echo "<br> The $username has an exisiting record of $test order that is still pending. Thus the order will be updated to reflect the changes.";
						$price = $row["pprice"] * $value;
						$query3 = "UPDATE purchase SET quantity = quantity + '$value', puprice = puprice + '$price', putime = now() WHERE cname = '$username' AND pname = '$test' AND status = 'pending'";
						if(mysqli_query($connection,$query3)) {
						echo " <br> The order for $test has successfully been placed";
					} else {
						echo "Error: " . $sql . "<br>" . mysqli_error($connection);
					}



				}
			} 
		} else {
			echo "Is empty";
			}
	
		} 
		mysqli_free_result($result);		
	} 
}
} 
?>

<?php
//closing database
mysqli_close($connection);
?>
