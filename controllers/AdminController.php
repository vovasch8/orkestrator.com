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

    public function actionTimeRegister(){

        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        //Перевіряємо чи користувач є адміном
        User::isAdmin($userId);

        $sort_date = 'week';

        $reg_users = User::getUsersRegisterTime();
        $users = User::getListOfUsers();

        $user_work_time = $this->work_time($users, $reg_users);

        require_once (ROOT . "/views/admin/time_register.php");
        return true;
    }

    public function work_time($users, $reg_users){
        $counter = 0;
        $result = array();

        for($i = 0; $i < count($users); $i++){
            while($counter < count($reg_users) && $users[$i]['u_id'] == $reg_users[$counter]['u_id']) {
//                echo date('H:i', strtotime($users[$counter]['t_date'])) . ' - ';
                $result[$reg_users[$counter]['u_id']][date('Y-m-d', strtotime($reg_users[$counter]['t_date']))][] = date('H:i', strtotime($reg_users[$counter]['t_date']));
                if(isset($reg_users[$counter+1]) && date('Y-m-d', strtotime($reg_users[$counter]['t_date'])) == date('Y-m-d', strtotime($reg_users[$counter+1]['t_date'] ))){
//                    echo date('H:i', strtotime($users[$counter+1]['t_date'])) . '<br>';
                    $result[$reg_users[$counter+1]['u_id']][date('Y-m-d', strtotime($reg_users[$counter+1]['t_date']))][] = date('H:i', strtotime($reg_users[$counter+1]['t_date']));
                    $counter++;
                }
                else{
//                    echo '22:00' . '<br>';
                    $result[$reg_users[$counter]['u_id']][date('Y-m-d', strtotime($reg_users[$counter]['t_date']))][] = '22:00';
                }
                $counter++;
            }
        }
        return $result;
    }

    public function actionTimeRegisterAjax(){

        $departament = $_POST['dep'];
        $sort_date = $_POST['sdate'];

        $reg_users = User::getUsersRegisterTime($departament, $sort_date);
        $users = User::getListOfUsers($departament);

        $user_work_time = $this->work_time($users, $reg_users);

        include_once "template/ajax/time_register_table.php";
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

    public function actionUserListAjax()
    {

        $departament = $_POST['dep'];
        $users = User::getListOfUsers($departament);

        require_once(ROOT . "/template/ajax/user_list_table.php");
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