<?php include_once "template/header.php";?>

<?php include_once "template/admin-sidebar.php"?>


<div id="admin-content" class="container">
    <h5 class="text-center mt-5">Управление пользователями</h5>

    <?php if (isset($errors) && is_array($errors)): ?>
        <div class="container text-center justify-content-center">
            <h6>Ошибка</h6>
            <ul class="error">
                <?php foreach ($errors as $error): ?>
                    <li> - <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <br>
    <?php endif; ?>

    <?php if($result != false):?>
        <div class="container text-center justify-content-center">
            <h6 class="mb-3 mt-3">Уведомление</h6>
            <span class="text-success text-center message">Пользователь успешно добавлен!</span>
        </div>
    <?php endif; ?>

    <div class="justify-content-center row">
        <form action="#" method="post" class="users-form">
            <h6 class="text-center mt-3">Добавить пользователя</h6>
            <label for="fname" >Имя</label>
            <input type="text" name="fname" class="form-control">
            <label for="sname" >Фамилия</label>
            <input type="text" name="sname" class="form-control">
            <label for="login">Логин</label>
            <input type="number" name="login" class="form-control">
            <label for="password" >Пароль</label>
            <input type="password" name="password" class="form-control">
            <div class="form-check form-check-inline">
                <input class="form-check-input" checked type="radio" name="switch" id="inlineRadio1" value="0">
                <label class="form-check-label" for="inlineRadio1">Пользователь</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="switch" id="inlineRadio2" value="1">
                <label class="form-check-label" for="inlineRadio2">Администратор</label>
            </div>
            <div class="row justify-content-center">
                <button type="submit" name="submit" class="btn btn-style mt-3 text-center">Создать</button>
            </div>
        </form>
    </div>
</div>

<?php include_once "template/footer.php";
