<?php
ob_start();
session_start();

include_once("nomeSession.php");

$_SESSION[NOMESESSION] = '';

unset($_SESSION[NOMESESSION]);

header('Location: index.php');

ob_end_flush();

?>