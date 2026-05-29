<?php
require_once 'config/db.php';
unset($_SESSION['customer_id'], $_SESSION['customer_name']);
redirect('customer_login.php');
?>
