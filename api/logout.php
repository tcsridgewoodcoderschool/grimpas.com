<?php
session_start();
session_destroy();
header("Location: ../index.php");
exit(1);
?>

You've been logged out!