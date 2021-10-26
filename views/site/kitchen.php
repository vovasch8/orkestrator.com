<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Кухня</title>
    <link rel="shortcut icon" href="/layout/image/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="/layout/css/kitchen.css">
</head>
<body>

<header class="container d-flex flex-wrap align-items-center justify-content-center justify-content-between mt-2">

    <a href="/" class="d-flex align-items-center col-md-6 text-dark text-decoration-none">
        <img src="/layout/image/logo.png" width="60px" height="60px" alt="Orkestrator">
    </a>

    <div class="col-md-6 text-end ">
        <a href="/" class=" text-dark text-decoration-none">
            <img class="ms-5 inline-block" height="60px" src="/layout/image/logo_kraft.png" alt="">
        </a>
    </div>
</header>

<div id="clock"></div>

<div class="container text-center">

    <h1 id="more" class="mt-4">Авторизовані користувачі</h1>

    <div id="content" class="mt-4">
        <?php if(empty($persons)){
        echo '<h5 class="mt-5">Працівників поки немає!</h5>';
        }?>
        <?php foreach ($persons as $person): ?>
            <div class="row mt-3 person-item">
                <div class="col-md-3">
                    <img class="photo-person" width="150px" height="150px"
                         src="<?php echo '/layout/image/persons/' . $person['u_identificator'] . '.jpg';?>" alt="Користувач">
                </div>
                <div class="col-md-9 text-start">
                    <h2><?php echo $person['u_fname'] . " " . $person['u_sname']; ?></h2>
                    <div class="text-end mb-3 time"><b class="person-time"><?php  echo 'Time: '. substr($person['date'], 11, 5); ?></b></div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="row text-center people-counter justify-content-center mt-3 mb-5">
            <h2>Количество сотрудников</h2>
            <p>
            Производство: <span id="proiz"><?php echo $proiz; ?></span>
            Офис: <span id="office"><?php echo $office?></span>
            </p>
        </div>
    </div>


</div>
<script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
<script src="/layout/js/kitchen_clock.js"></script>
<!--<script src="/layout/js/reload.js"></script>-->
<script src="/layout/js/kitchen.js"></script>
</body>
</html>

