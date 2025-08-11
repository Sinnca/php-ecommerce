<?php
session_start();
session_reset();
session_destroy();
header("Location: /week8/users/login.html");
exit;
?>