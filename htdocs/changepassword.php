<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Refresh" CONTENT="900">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>tech.gobcn.ca</title>
<style type="text/css">
<!--
body,td,th {
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
-->
</style></head>

<body>
<h1>BCN Password Change</h1>
<ul>
<?php

// Form Variables
$old  = $_POST["old"];
$new1  = $_POST["new1"];
$new2  = $_POST["new2"];

// LDAP Vars
$ldap_host = "ldap://localhost:389/";
$ldap_user = $_POST["dn"];
$ldap_pass = $old;

function errorout($emsg)
	{
	echo "<font color=red>" . $emsg . "</font>";
	}

// Connect to the LDAP Server
$ldap=ldap_connect($ldap_host);
// Set LDAP version 3
ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);

// Bind to the LDAP Server
$ds=@ldap_bind($ldap, $ldap_user, $ldap_pass);
if($ds)
	{
	// LDAP Bind Successful, Continue on
	// echo "<li>Bind Successful, Old Password Matches";

	// check that new passwords match
	if($new1 == $new2)
		{
		// Passwords Match, Continue on
		// echo "<li>Passwords Match";
		
		if(ldap_mod_replace ($ldap, $ldap_user, array('userpassword' => $new1)))
			{
			if(ldap_bind($ldap, $ldap_user, $new1))
				{
				// password change succeeded
				echo "<li>Password Change Succeeded, certain parts of our website may keep using your old password for up to 12 hours.";
				}
			else
				{
				// Password Change Failed
				echo "<li>";
				errorout("Password Change Failed");
				exit();
				}
			}
		else
			{
			// Password Change Failed
			echo "<li>";
			errorout("Password Change Failed");
			exit();
			}
		}
	else
		{
		// Passwords Did Not Match
		echo "<li>";
		errorout("New Passwords Did NOT Match");
		exit();
		}
	}
else
	{
	// Bind Failed
	echo "<li>";
	errorout("Incorrect Old Password");
	exit();
	}
?>
</ul>
  <p>
    <img src="/anim.written.in.vi.gif" alt="Written in the vi editor"
        height="31" width="88">
  </p>
</body>
</html>

