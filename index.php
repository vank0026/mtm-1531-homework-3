<?php

error_reporting(-1);
ini_set('display_errors', 'on');

include "includes/filter-wrapper.php";

$possible_languages = array (
"en" => "English",
"fr" => "French",
"sp" => "Spanish"
);

$errors = array();
$display_thanks = false;


$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$notes = filter_input(INPUT_POST, "notes", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$preferedlang = filter_input(INPUT_POST, "preferedlang", FILTER_SANITIZE_STRING);
$acceptterms = filter_input(INPUT_POST, "acceptterms", FILTER_DEFAULT);

if($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($name)) {
		$errors["name"] = true;
	};
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors["email"] = true;
	};
	
	if (mb_strlen($username) > 25 || empty($username)) {
		$errors["username"] = true;
	};
	
	if (empty($password)) {
		$errors["password"] = true;
	};
	
	if (!array_key_exists($preferedlang, $possible_languages)) {
		$errors["preferedlang"] = true;
	}
	
	if (empty($acceptterms)){
		$errors["acceptterms"] = true;
	}

	if (empty($errors)) {
		$display_thanks = true;
		
			$email_message = 'Name: '.$name ."\r\n";		// the \r\n line means new line in email, MUST be in double quotes, .= appends the stuff to the line before
			$email_message .= 'Email: '.$email ."\r\n";
			$email_message .= "Message:\r\n" .$message;
			
			$headers = 'From: no-reply@algonquinlive.com' ."\r\n";// is the from adress, a MUST, very specific format!
			
			mail($email, "Thanks for Registering", $email_message, $headers);
	}

}
?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Registration Form</title>
<link href="css/general.css" rel="stylesheet">
</head>

<body>
		<h1>Registration Form</h1>

	<?php if ($display_thanks) : ?>
	
		<h1>You are now Registered</h1>
		
	<?php else : ?>

	<form method="post" action="index.php">
	
		
		<div class="name">
			<label for="name">Name: <?php if(isset($errors["name"])) : ?><strong>Is Required for Registration</strong><?php endif; ?> </label>
			<input type="text" id="name" name="name" value="<?php echo $name; ?>">
		</div>
		
		<div class="email">
			<label for="email">E-Mail Address: <?php if(isset($errors["email"])) : ?><strong>Not a Valid E-Mail</strong><?php endif; ?></label>
			<input type="email" id="email" name="email" value="<?php echo $email; ?>">
		</div>
		
		<div class="username">
			<label for="username">Username: <?php if(isset($errors["username"])) : ?><strong>Not a Valid Username</strong><?php endif; ?></label>
			<input type="username" id="username" name="username" value="<?php echo $username; ?>">
		</div>
		
		<div class="password">
			<label for="password">Password: <?php if(isset($errors["password"])) : ?><strong>Not a Valid Password</strong><?php endif; ?></label>
			<input type="password" id="password" name="password" value="<?php echo $password; ?>">
		</div>
		
		<div class="preferedlang">
			<fieldset>
				<legend>Language: </legend>
					<?php if(isset($errors["preferedlang"])) : ?><strong>Choose a Language Prefernece</strong><br><?php endif; ?>
					
					<?php foreach ($possible_languages as $key => $value) : ?>
					
				<input type="radio" id="<?php echo $key ?>" name="preferedlang" value="<?php echo $key ?>" <?php if ($key == $preferedlang) {echo "checked";} ?>>
				
				<label for= "<?php echo $key ?>"><?php echo $value?></label>
				
					<?php endforeach; ?>
					
			</fieldset>
		</div>
		
		<div class="notes">
			<label for="notes">Notes: </label>
			<textarea id="notes" name="notes" > <?php echo $notes; ?></textarea>
			</div>
	
		<div class="acceptterms">
			<label for="acceptterms">Accept the Terms by Checking the Box.<?php if(isset($errors["acceptterms"])) : ?><strong>You must Accept Terms to Register</strong><br><?php endif; ?> </label>
			<input type="checkbox" id="acceptterms" name="acceptterms" value="checked"><?php print $acceptterms ?>
        
		</div>
	
		<div class="button">
			<button type="submit">Confirm.</button>
		</div>
	
	</form>
	
	<?php endif; ?>	
	
</body>
</html>