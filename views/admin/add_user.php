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
            <hr>
            <label for="fname" >ID</label>
            <input type="text" name="id" class="form-control">
            <label for="fname" >Имя</label>
            <input type="text" name="fname" class="form-control">
            <label for="sname" >Фамилия</label>
            <input type="text" name="sname" class="form-control">
            <label for="login">Email</label>
            <input type="email" name="login" class="form-control">
            <label for="password" >Пароль</label>
            <input type="password" name="password" class="form-control">
            <label for="card">Номер карты</label>
            <input type="number" name="card" class="form-control">

            <h6 class="text-center mt-3">Общее</h6>
            <hr>
            <label for="photo">Путь к аватарке</label>
            <input type="text" name="photo" class="form-control">
            <label for="departament">Подразделение</label>
            <select class="form-select" aria-label="Default select example" name="departament">

                        <optgroup label="1. Главный офис:">
                <option value="Аутсорсинг">Аутсорсинг</option>
                <option value="Безопасность">Безопасность</option>
                <option value="Директорат">Директорат</option>
                <option value="І-Стейт">І-Стейт</option>
                <option value="Логистический центр">Логистический центр</option>
                <option value="Персонал">Персонал</option>
                <option value="Коммерческий отдел">Коммерческий отдел</option>
                <option value="Финансово-юридичний подразделение">Финансово-юридичний подразделение</option>
                <option value="Производственное подразделение">Производственное подразделение</option>
                <option value="ІТ">ІТ</option>
                <option value="Подразделение по питанию">Подразделение по питанию</option>
                        </optgroup>

                        <optgroup label="2. Коллекторная:">
                <option value="Производство профиля">Производство профиля</option>
                <option value="Производство светильников">Производство светильников</option>
                <option value="Склад ТД Крафт">Склад ТД Крафт</option>
                        </optgroup>

                        <optgroup label="3. Охрана:">
                <option value="Пуховская">Пуховская</option>
                <option value="Коллекторная">Коллекторная</option>
                <option value="Лес">Лес</option>
                        </optgroup>
            </select>

            <label for="position">Должность</label>
            <input type="text" name="position" class="form-control">
            <label for="phone">Мобильний телефон</label>
            <input type="text" name="phone" class="form-control">
            <label for="phone">Внутренний телефон</label>
            <input type="text" name="inner_phone" class="form-control">

            <div class="form-check form-check-inline">
                <input class="form-check-input" checked type="radio" name="switch" id="inlineRadio1" value="0">
                <label class="form-check-label" for="inlineRadio1">Пользователь</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="switch" id="inlineRadio2" value="1">
                <label class="form-check-label" for="inlineRadio2">Администратор</label>
            </div>
            <div class="row justify-content-center">
                <button type="submit" name="submit" class="btn btn-orange mt-3 mb-5 text-center">Создать</button>
            </div>
        </form>
    </div>
</div>

<?php include_once "template/footer.php";
