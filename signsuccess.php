<?php
session_start();
require('includes/connection.php');
if(!isset($_COOKIE['newuser'])){
    header('location: index.php');}
    require('includes/header.php');?>
<body id="main"><h1>hello welcome</h1></body>
<?php require('includes/footer.php');
?>