<?php
ob_start();

session_start();
session_destroy();
header('location:studente.php');

ob_end_flush();


?>