<?php

class AdminController
{
    public function actionDashboard(){

        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        //Перевіряємо чи користувач є адміном
        User::isAdmin($userId);

        require_once (ROOT . "/views/admin/dashboard.php");
        return true;
    }

    public function actionAddUser(){

        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        //Перевіряємо чи користувач є адміном
        User::isAdmin($userId);

        $result = false;

        // Обробка форми
        if (isset($_POST['submit'])) {
            // Якщо форма відправлена
            // Отримуємо дані
            $id = $_POST['id'];
            $fname = $_POST['fname'];
            $sname = $_POST['sname'];
            $login = $_POST['login'];
            $password = $_POST['password'];
            $card = $_POST['card'];

            $photo = $_POST['photo'];
            $departament = $_POST['departament'];
            $position = $_POST['position'];
            $phone = $_POST['phone'];
            $inner_phone = $_POST['inner_phone'];
            $isAdmin = $_POST['switch'];

            // Флажок для помилок
            $errors = false;

            // Валідація полів
            if (!User::checkName($fname)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkName($sname)) {
                $errors[] = 'Фамилия не должна быть короче 2-х символов';
            }
            if (!User::checkEmail($login)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkLength($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (User::checkLoginExists($login)){
                $errors[] = 'Пользователь с таким логином уже зарегистрирован';
            }
            if (User::checkIdExists($id)){
                $errors[] = 'Пользователь с таким id уже зарегистрирован';
            }

            if ($errors == false) {
                // Якщо помилок немає
                // Реєструємо користувача
                $result = User::register($id, $fname, $sname, $login, $password, $card, $photo, $departament, $position, $phone, $inner_phone, $isAdmin);
            }
        }

        require_once(ROOT . "/views/admin/add_user.php");
        return true;
    }

    public function actionUserList()
    {

        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        //Перевіряємо чи користувач є адміном
        User::isAdmin($userId);

        $users = User::getListOfUsers();

        require_once(ROOT . "/views/admin/user_list.php");
        return true;
    }

    public function actionEditUser($id){
        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        //Перевіряємо чи користувач є адміном
        User::isAdmin($userId);

        $editedUser = User::getUserById($id);

        // Обробка форми
        if (isset($_POST['submit'])) {
            // Якщо форма відправлена
            // Отримуємо дані
            $editedUserId = $id;
            $fname = $_POST['fname'];
            $sname = $_POST['sname'];
            $login = $_POST['login'];
            $password = $_POST['password'];
            $card = $_POST['card'];

            $photo = $_POST['photo'];
            $departament = $_POST['departament'];
            $position = $_POST['position'];
            $phone = $_POST['phone'];
            $inner_phone = $_POST['inner_phone'];
            $isAdmin = $_POST['switch'];

            // Флажок для помилок
            $errors = false;

            // Валідація полів
            if (!User::checkName($fname)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkName($sname)) {
                $errors[] = 'Фамилия не должна быть короче 2-х символов';
            }
            if (!User::checkEmail($login)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkLength($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if ($errors == false) {
                // Якщо помилок немає
                // Реєструємо користувача
                $result = User::editUser($editedUserId, $fname, $sname, $login, $password, $card, $photo, $departament, $position, $phone, $inner_phone, $isAdmin);
                $editedUser = User::getUserById($editedUserId);
            }
        }

        require_once(ROOT . "/views/admin/edit_user.php");
        return true;
    }
}