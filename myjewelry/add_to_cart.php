<?php
require_once 'functions.php';

if (isset($_GET['id'])) {
    addToCart($_GET['id']);
}

header("Location: index.php"); 
exit;
?>