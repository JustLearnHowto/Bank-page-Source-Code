<?php
session_start();

if(!isset($_SESSION['username'])){
	header('Location: login.html');
	exit();
}

$username = $_SESSION['username'];

$users_file = 'users.txt';
$transactions_file = 'transactions.txt';

$users_data = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$user_info = [];
foreach($users_data as $user){
	$user_data = explode(':', $user);
	if($user_data[0] == $username){
		$user_info = [
			'full_name' => $user_data[2],
			'account_number' => $user_data[3],
			'balance' => $user_data[4]
		];
		break;
	}
}

$balance = $user_info['balance'];

$transactions_data = file($transactions_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$transactions = [];
foreach($transactions_data as $transaction){
	$transaction_data = explode(':', $transaction);
	if($transaction_data[0] == $username){
		$transactions[] = [
			'date' => $transaction_data[1],
			'description' => $transaction_data[2],
			'amount' => $transaction_data[3]
		];
	}
}

include('accounts.html');
?>
