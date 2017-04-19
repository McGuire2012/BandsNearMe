<?php
session_start();
unset($_SESSION['email']);
 unset($_SESSION['passwords']);
 session_destroy();
		header("Location: ../index.php");
		die();

  ?>
