<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	$email = $_POST['email'];
	$full_name = $_POST['full_name'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];

	if ($password != $confirm_password) {
		echo "Error: Passwords do not match!";
		exit();
	}
    else
    {
	$users_file = fopen("users.txt", "a");
	fwrite($users_file, "$username:$password\n");
	fclose($users_file);

	$user_info_file = fopen("user_info.txt", "a");
	fwrite($user_info_file, "$username:$email:$full_name:$address:$phone\n");
	fclose($user_info_file);

	echo "Account created successfully!";
	}
}
?>
