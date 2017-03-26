<?php
session_start();
if(isset($_POST['username'])){
	$_SESSION['username'] = $_POST['username'];
} 
?>

<html>
<head>
<title>Index</title>
<body>
<form action="keyword.php" method="post">
Username : <input type="text" name="username" value=""> <br>
Keyword : <input type="text" name="keyword" value=""> <br>
<input type="submit" name="submit" value="submit">
</form>


</body>
</head>
</html>