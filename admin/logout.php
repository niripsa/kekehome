<?php
require_once '../include/conn.php';

session_start();
session_unset();
//session_destroy();

footer();

turnToPage("login.php");
?>