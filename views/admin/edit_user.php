<?php include_once "template/header.php";?>

<?php include_once "template/admin-sidebar.php"?>


    <div id="admin-content" class="container">
        <h5 class="text-center mt-5">Управление пользователями</h5>

        <div class="justify-content-center row">
            <form action="#" method="post" class="users-form">
                <h6 class="text-center mt-3">Редактирование пользователя</h6>
                <hr>
                <label for="fname" >Имя</label>
                <input type="text" name="fname" value="<?php echo $editedUser['u_fname'];?>" class="form-control">
                <label for="sname" >Фамилия</label>
                <input type="text" name="sname" value="<?php echo $editedUser['u_sname'];?>" class="form-control">
                <label for="login">Email</label>
                <input type="email" name="login" value="<?php echo $editedUser['u_email'];?>" class="form-control">
                <label for="password" >Пароль</label>
                <input type="password" name="password" value="<?php echo $editedUser['u_password'];?>" class="form-control">
                <label for="card">Номер карты</label>
                <input type="number" name="card" value="<?php echo $editedUser['u_card'];?>" class="form-control">

                <h6 class="text-center mt-3">Общее</h6>
                <hr>
                <label for="photo">Путь к аватарке</label>
                <input type="text" name="photo" value="<?php echo $editedUser['u_photo'];?>" class="form-control">
                <label for="departament">Подразделение</label>
                <select class="form-select" aria-label="Default select example" name="departament">

                    <option selected value="<?php echo $editedUser['u_departament']; ?>"><?php echo $editedUser['u_departament']; ?></option>

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
                <input type="text" name="position" value="<?php echo $editedUser['u_position'];?>" class="form-control">
                <label for="phone">Мобильний телефон</label>
                <input type="text" name="phone" value="<?php echo $editedUser['u_phone'];?>" class="form-control">
                <label for="phone">Внутренний телефон</label>
                <input type="text" name="inner_phone" value="<?php echo $editedUser['u_inner_phone'];?>" class="form-control">

                <?php if($editedUser['u_role'] == 0): ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" <?php echo 'checked';?> type="radio" name="switch" id="inlineRadio1" value="0">
                        <label class="form-check-label" for="inlineRadio1">Пользователь</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="switch" id="inlineRadio2" value="1">
                        <label class="form-check-label" for="inlineRadio2">Администратор</label>
                    </div>
                <?php else:?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="switch" id="inlineRadio1" value="0">
                        <label class="form-check-label" for="inlineRadio1">Пользователь</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" <?php echo 'checked';?> type="radio" name="switch" id="inlineRadio2" value="1">
                        <label class="form-check-label" for="inlineRadio2">Администратор</label>
                    </div>
                <?php endif;?>
                <div class="row justify-content-center">
                    <button type="submit" name="submit" class="btn btn-orange mt-3 mb-5 text-center">Обновить</button>
                </div>
            </form>
        </div>
    </div>

<?php include_once "template/footer.php";
