<?php
session_start();
if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
}
?>

<html>
<head>
<title>Index</title>
<body>
<p><?php echo $username ?> </p>
</body>
</head>
</html>