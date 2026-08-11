<?php
session_start();

session_unset();
session_destroy();

header("Location: /Croma/Presentacion/index.php");
exit;
?>