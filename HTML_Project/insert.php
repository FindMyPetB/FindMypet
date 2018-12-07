<?php 
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];
$gender = $_POST['gender'];

if (!empty($username) || !empty($password) || !empty($email) || !empty($alamat) || !empty($gender)) 
{
	$host = "localhost";
	$dbUsername = "wisnuapp";
	$dbPassword = "081296W!s";
	$dbname = "lr";

	//connection
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

	if (mysql_connect_error()) 
	{
		die('Connect Error('. mysql_connect_errno).')'.mysql_connect_error());
	}
	else
	{
		$SELECT = "SELECT email From users Where email = ? LIMIT 1";
		$INSERT = "INSERT Into users (username, password, gender, email, alamat) values(?, ?, ?, ?, ?)";

		//prepare statement
		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		if ($rnum==0) {
			$stmt->close();

			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param("ssssii",$username, $password, $gender, $alamat, $email);
			$stmt->execute();
			echo "New Record Inserted";
		}
		else
		{
			echo "Someone already use this email";
		}
		$stmt->close();
		$conn->close();
	}
}
else
{
	echo "All Field are required";
	die();
}

 ?>