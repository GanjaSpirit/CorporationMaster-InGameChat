<?php
//get the current session
@session_start();

//connect to the db
require(__DIR__.'/db_connect.php');

$user = $_SESSION['user_name'];
		
		$recipient  = $_POST['recipient'];
		$message    = stripslashes(htmlspecialchars($_POST['message']));
		 
		$chkrecipient  = stripslashes(htmlspecialchars($recipient));
	


		//query the received messages
	$received_query = mysqli_query($link,"SELECT user_name FROM users WHERE user_name = '".$chkrecipient."' ") or die("failed m ". mysqli_error());
$row = mysqli_fetch_array($received_query);
$receiver =$row['user_name'];

	if ($receiver=="") { die ("Receiver failed,contact the admin! ");}
	if ($receiver=="pablo444") { die ("You are banned from inbox system for spamming! ");}
	
if (mysqli_num_rows($received_query) >0) {  
		
		if ($recipient != $chkrecipient)  { die ("Nice try little rascal!");}
		if ($user == $receiver) { die ("You can not send a message to yourself, would be cool dough :) ");}
	
	
		$currentserverdate = strtotime("now");
		$execsql = "INSERT INTO messages (`sender`, `receiver`,`message`, `seen_flag`, `time`) VALUES ('$user','$recipient', '$message' ,0, $currentserverdate )";
		$insert = mysqli_query($link,$execsql)or die('Message failed, contact the admin!' . mysqli_error());
		
		
		echo 'Message sent to '.$receiver ;
				} else { echo "No user found with the name ".$recipient ; die ();}	
		

?>