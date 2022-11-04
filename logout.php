<?php
session_start();
include("includes/config.php");
$_SESSION['login']=="";
date_default_timezone_set('America/New_York');

// Write code for log out from the session
$_SESSION['logoutTime'] = date('l jS \of F Y h:i:s A');

$userId = $_SESSION['userId'];
$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
$logIn = $_SESSION['loginTime'];
$logOut = $_SESSION['logoutTime'];
$sql = "INSERT INTO userlog (userEmail, userIP, loginTime, logout, status) VALUES ('$userId','$ip_address','$logIn','$logOut', 1)";
$result = $pdo->query($sql);
session_destroy();
header("Location: index.php");
exit;

?>
<script language="javascript">
document.location="index.php";
</script>
