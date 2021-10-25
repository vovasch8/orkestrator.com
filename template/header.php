<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orkestrator</title>
    <link rel="shortcut icon" href="/layout/image/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="/layout/css/main.css">
    <link rel="stylesheet" href="/layout/css/admin.css">
</head>
<body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<header class="container d-flex flex-wrap align-items-center justify-content-center justify-content-between mt-1">
    <a href="/" class="d-flex align-items-center col-md-6 text-dark text-decoration-none">
        <img src="/layout/image/logo.png" width="60px" height="60px" alt="Orkestrator">
    </a>

    <div class="col-md-6 text-end">
        <?php if(User::isUserInSystem()): ?>
            <span><?php echo $user['u_fname'] . ' ' . $user['u_sname'];?></span>
            <a href="/site/logout/"><button type="button" class="btn btn-style">ВЫХОД</button></a>
        <?php endif;?>
    </div>
</header>

<hr>

<div id="clock" class="text-end container"></div>

