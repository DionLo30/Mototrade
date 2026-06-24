<?php
require_once 'config.php';

// Destroy session
session_unset();
session_destroy();

header('Location: ../index.html');
exit;
?>