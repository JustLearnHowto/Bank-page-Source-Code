<?php
	session_start();
	$user_file = fopen("users.txt", "r") or die("Unable to open file!");
	$found = false;

	while (!feof($user_file)) {
		$line = trim(fgets($user_file));
		if (!empty($line)) {
			$user_data = explode(":", $line);
			if ($_POST["username"] == $user_data[0] && $_POST["password"] == $user_data[1]) {
				$_SESSION["username"] = $user_data[0];
				$_SESSION["balance"] = $user_data[2];
				$found = true;
				header("Location: account.html");
			}
		}
	}

	fclose($user_file);

	if (!$found) {
		header("Location: login.html?error=1");
	}
?>
