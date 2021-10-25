
<?php include_once "template/header.php";?>

<div class="container">

    <h5 class="text-center">ДЛЯ ПРОДОЛЖЕНИЯ РАБОТЫ, НЕОБХОДИМА АВТОРИЗАЦИЯ</h5>
    <h6 class="text-center">Введите ваш логин и пароль или отсканируйте персональный штрих-код</h6>


    <?php if (isset($errors) && is_array($errors)): ?>
    <div class="container text-center justify-content-center">
        <h6>Ошибка</h6>
        <ul class="error">
            <?php foreach ($errors as $error): ?>
                <li> - <?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="container text-center">
        <form id="login-form" action="#" method="post" class="form-machine mt-5 login-form">
            <ul class="nav nav-tabs border">
                <li class="nav-item active-tab">
                    <a class="nav-link" aria-current="page" href="#" onclick="tab_login()">ЛОГИН</a>
                </li>
                <li  class="nav-item nav-grey">
                    <a class="nav-link" href="#" onclick="tab_scan()">ШТРИХКОД</a>
                </li>
            </ul>
            <div class="row justify-content-center">
                <div class="col-md-12 col-sm-12 pt-5 ps-5 pe-5 border-right">
                    <p class="text-center">ВХОД ЧЕРЕЗ ЛОГИН И ПАРОЛЬ</p>
                    <label for="email">ВВЕДИТЕ ЛОГИН</label>
                    <input type="email" id="email" name="email" class="form-control">
                    <label for="password">ВВЕДИТЕ ПАРОЛЬ</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <button type="submit" name="submit" class="btn btn-grey mt-5">ВОЙТИ</button>
            </div>

        </form>

        <form id="scan-form" action="#" method="post" class="form-machine mt-5 scan-form">
            <ul class="nav nav-tabs border">
                <li class="nav-item nav-grey">
                    <a class="nav-link" aria-current="page" href="#" onclick="tab_login()">ЛОГИН</a>
                </li>
                <li class="nav-item active-tab">
                    <a class="nav-link " href="#" onclick="tab_scan()">ШТРИХКОД</a>
                </li>
            </ul>
            <div class="row justify-content-center">
                <div class="col-md-12 col-sm-12 text-center pt-5 ps-5 pe-5">
                    <p for="btn-scan">ВХОД ЧЕРЕЗ ШТРИХКОД</p>
                    <button id="btn-scan" class="btn btn-grey">СКАНИРОВАТЬ</button>
                    <br>
                    <label class="mt-3 text-start" for="input-login">ВАШ ЛОГИН</label>
                    <br>
                    <input id="input-login" type="text" name="login"  class="form-control">
                </div>
                <button class="btn btn-grey mt-5">ВОЙТИ</button>
            </div>
        </form>
    </div>


</div>
<script src="/layout/js/tabs.js"></script>
<?php include_once "template/footer.php";?>
