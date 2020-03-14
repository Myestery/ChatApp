<?php require($_SERVER['DOCUMENT_ROOT'] . '/chatapp/includes/functions.php') ?>
<!DOCTYPE html>

<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="http://johnpaul/chatapp/js/jquery-3.2.1.min.js"></script>
    <script src="http://johnpaul/chatapp/js/script.js"></script>
    <link rel="stylesheet" href="http://johnpaul/chatapp/libs/bootstrap-4.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="http://johnpaul/chatapp/libs/bootstrap-4.3.1-dist/css/bootstrap-grid.css">
    <link rel="stylesheet" href="http://johnpaul/chatapp/libs/bootstrap-4.3.1-dist/css/bootstrap-reboot.css">
    <link rel="stylesheet" href="http://johnpaul/chatapp/css/style.css">
    <link href="http://johnpaul/chatapp/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <div class="page-content">
        <header>
            <div class="logo">
                <i class="fa fa-gg-circle"></i><b>ChatApp</b></div>
            <div class="menu-toggle">&#9776;</div>
            <nav id="mobile">
                <?php navbar(); ?>
            </nav>
        </header>