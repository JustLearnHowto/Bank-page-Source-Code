<?php
session_start();

if (!isset($_SESSION['username'])) {
	header('Location: login.html');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$amount = $_POST['amount'];

	// Check if the amount is valid
	if ($amount <= 0) {
		$error_msg = 'Invalid amount.';
	} else {
		$username = $_SESSION['username'];
		$users_file = fopen('users.txt', 'r');
		$temp_file = fopen('temp.txt', 'w');

		// Loop through each line of the users file
		while (!feof($users_file)) {
			$line = fgets($users_file);
			if (strpos($line, $username . ':') === 0) {
				$user_data = explode(':', trim($line));
				$balance = $user_data[4];

				// Check if the balance is enough
				if ($balance < $amount) {
					$error_msg = 'Insufficient funds.';
					fwrite($temp_file, $line);
				} else {
					$user_data[4] -= $amount;
					$new_line = implode(':', $user_data) . "\n";
					fwrite($temp_file, $new_line);
					$success_msg = 'Withdrawal successful.';
				}
			} else {
				fwrite($temp_file, $line);
			}
		}

		fclose($users_file);
		fclose($temp_file);

		// Replace the users file with the updated data
		rename('temp.txt', 'users.txt');
	}

	if (isset($error_msg)) {
		echo '<script>alert("' . $error_msg . '");</script>';
	} elseif (isset($success_msg)) {
		echo '<script>alert("' . $success_msg . '");</script>';
	}
}
?>
