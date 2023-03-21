<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
	header('Location: login.html');
	exit();
}

// Get the amount to deposit from the form
$amount = $_POST['amount'];

// Open the users.txt file
$file = fopen('users.txt', 'r+');

// Loop through the file and find the user's data
while (!feof($file)) {
	$line = fgets($file);
	$data = explode(':', $line);
	if ($_SESSION['username'] == $data[0]) {
		// Update the user's balance
		$data[4] += $amount;
		// Move the file pointer back to the start of the line
		fseek($file, -strlen($line), SEEK_CUR);
		// Write the updated data back to the file
		fwrite($file, implode(':', $data));
		break;
	}
}

// Close the file
fclose($file);

// Redirect to the Account Details page
header('Location: account.php');
exit();
?>
