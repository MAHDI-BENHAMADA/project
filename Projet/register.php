<?php 
  include "templates/head.php";
?>
<?php

	require_once('functions.php');
	if(loggedin())
		header("Location: index.php");
	else if(isset($_POST['action'])) {
		$name = mysql_real_escape_string($_POST['name']);
		if($_POST['action']=='register') {

			$email = mysql_real_escape_string($_POST['email']);
			$number = mysql_real_escape_string($_POST['contactno']);
			$gender = mysql_real_escape_string($_POST['sex']);
			$desc = mysql_real_escape_string($_POST['description']);
			$sex="M";

			if($gender=="female"){
				$sex="F";
			}
			else {
				connectdb();
				$query = "SELECT random,hash FROM users WHERE email='".$email."'";
				$result = mysql_query($query);
				if(mysql_num_rows($result)!=0)
					header("Location: register.php?exists=1");
				else {
					$random = randomNum(5);
					$hash = crypt($_POST['password'], $random);
					$sql="INSERT INTO `users` ( `name` , `random` , `hash` , `email` , `gender` , `contactno` , `description` ) VALUES ('".$name."', '$random', '$hash', '".$email."','".$sex."','".$number."','".$desc."')";
					mysql_query($sql);
					header("Location: login.php?registered=1");
				}
			}
		}
	}
?>


<?php
include("header.php");
?>

 <div class="container">
<?php
        if(isset($_GET['logout']))
          echo("<div class=\"alert alert-info\">\nYou have logged out successfully!\n</div>");
        else if(isset($_GET['error']))
          echo("<div class=\"alert alert-error\">\nIncorrect email or password!\n</div>");
      else if(isset($_GET['ldaperr']))
          echo("<div class=\"alert alert-error\">\nIncorrect LDAP username or LDAP password!\n</div>");
        else if(isset($_GET['registered']))
          echo("<div class=\"alert alert-success\">\nYou have been registered successfully! Login to continue.\n</div>");
        else if(isset($_GET['exists']))
          echo("<div class=\"alert alert-error\">\nEmail already exists! Please select a different username.\n</div>");
        else if(isset($_GET['nerror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
      ?>
      <div class="container-narrow">
      <form method="post" action="register.php" class="form-horizontal well">
        <input type="hidden" name="action" value="register"/>
        <h1><small>Register now</small></h1>
        <input type="text" name="name" placeholder="Name" required/><br/><br>
        <input type="password" name="password" placeholder="Password"  required/><br/><br>
        <input type="email" name="email" placeholder="Email Id" required/><br/><br>
        <div class="input-prepend">
		<span class="add-on">+91</span>
		Contact Number: <input class="span2" id="prependedInput" type="number" name="contactno" placeholder="Contact Number" required>
		</div><br/><br>
		Gender:
		<label class="radio">
		<input type="radio" name="sex" value="male">Male
		</label>
		<label class="radio">
		<input type="radio" name="sex" value="female">Female
		</label>
		<textarea width="500px" rows="3" name="description" placeholder="Your description might help people send you a pool request easily! "></textarea><br>

		<br/>
        <input class="btn btn-primary" type="submit" name="submit" value="Register"/>
    </div> 
</form>
</div>
<?php
	include('footer.php');
?>

