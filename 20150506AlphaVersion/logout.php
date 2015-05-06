<?php
if (isset($_COOKIE['username'])) {
    unset($_COOKIE['username']);
	setcookie('username', ""); 
}

if (isset($_COOKIE['password'])) {
    unset($_COOKIE['password']);
	setcookie('password', ""); 
}

if (isset($_COOKIE['logininfo'])) {
    unset($_COOKIE['logininfo']);
	setcookie('logininfo', ""); 
}

	header( "Location: index.php");
?>