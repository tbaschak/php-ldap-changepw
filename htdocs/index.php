<?php

$ldap_host = "ldap://localhost:389/";
$ldap_user = "cn=ldapproxy, dc=gobcn, dc=ca";
$ldap_pass = "ldapbindpw";
$ldap_basedn = "ou=People,dc=gobcn,dc=ca";
$user = $_SERVER["REMOTE_USER"];
$filter="(&(objectClass=inetOrgPerson)(uid=$user))";
// $ldap_user = $_SERVER["REMOTE_USER"];
// $ldap_pass = $
$ldap=ldap_connect($ldap_host);
ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
$ds=ldap_bind($ldap, $ldap_user, $ldap_pass);
$sr=ldap_search($ldap, $ldap_basedn, $filter);
$info = ldap_get_entries($ldap, $sr);
$RDN = $info[0]["dn"];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>BCN Password Change</title>
<style type="text/css">
<!--
body,td,th {
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
-->
</style></head>

<body>
<h1>BCN Password Change</h1>
<form action=changepassword.php method=POST>
<table>
<tr><td>DN:</td><td><?php echo $RDN; ?><input type=hidden name=dn value="<?php echo $RDN; ?>"></td></tr>
<tr><td>Old:</td><td><input type=password name=old></td></tr>
<tr><td>New Password:</td><td><input type=password name=new1></td></tr>
<tr><td>New Password (confirm):</td><td><input type=password name=new2></td></tr>
<tr><td colspan=2><input value="Change Password" type=submit></td></tr>
</table>
</form>
  <p>
    <img src="/anim.written.in.vi.gif" alt="Written in the vi editor"
        height="31" width="88">
  </p>
</body>
</html>
