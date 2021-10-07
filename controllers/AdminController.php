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

    public function actionUsers(){

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
            $fname = $_POST['fname'];
            $sname = $_POST['sname'];
            $login = $_POST['login'];
            $password = $_POST['password'];
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
            if (!User::checkLength($login)) {
                $errors[] = 'Логин не должен быть короче 6-ти символов';
            }
            if (!User::checkLength($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (User::checkLoginExists($login)){
                $errors[] = 'Пользователь с таким логином уже зарегистрирован';
            }

            if ($errors == false) {
                // Якщо помилок немає
                // Реєструємо користувача
                $result = User::register($fname, $sname, $login, $password, $isAdmin);
            }
        }

        require_once (ROOT . "/views/admin/users.php");
        return true;
    }
}