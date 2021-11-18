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
            $isDinner = $_POST['dinner'];

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
                $result = User::register($id, $fname, $sname, $login, $password, $card, $photo, $departament, $position, $phone, $inner_phone, $isAdmin, $isDinner);
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

        $result = false;

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
            $isDinner = $_POST['dinner'];

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
                $result = User::editUser($editedUserId, $fname, $sname, $login, $password, $card, $photo, $departament, $position, $phone, $inner_phone, $isAdmin, $isDinner);
                $editedUser = User::getUserById($editedUserId);
            }
        }

        require_once(ROOT . "/views/admin/edit_user.php");
        return true;
    }

    public function actionWorkShift(){
        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        //Перевіряємо чи користувач є адміном
        User::isAdmin($userId);

        $usersFromProduction = User::getUsersFromProduction();

        $date = date("Y-m-d");

        $dayUsers = array();
        $nightUsers = array();

        //Відображення людей в денній зміні
        $dayShift = Shift::getUsersFromShift('day', $date);
        for($i = 0; $i < count($dayShift); $i++){
            $c_user = User::getUserById($dayShift[$i]["id_user"]);
            $dayUsers[] = $c_user;
            foreach ($usersFromProduction as $k => $u_p){
                if($c_user['u_id'] == $u_p['u_id']){
                    unset($usersFromProduction[$k]);
                }
            }
        }

        //Відображення людей в нічній зміні
        $nightShift = Shift::getUsersFromShift('night', $date);
        for($i = 0; $i < count($nightShift); $i++){
            $c_user = User::getUserById($nightShift[$i]["id_user"]);
            $nightUsers[] = $c_user;
            foreach ($usersFromProduction as $k => $u_p){
                if($c_user['u_id'] == $u_p['u_id']){
                    unset($usersFromProduction[$k]);
                }
            }
        }

        $_SESSION['pointer'] = 0;

        $month = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
        $days = array(1 => "пн" , "вт" , "ср" , "чт" , "пт" , "сб" , "вс" );
        $en_days = array(1 => "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");

        require_once (ROOT . "/views/admin/work_shift.php");
        return true;
    }

    public function actionWorkShiftAjax(){
        $month = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
        $days = array(1 => "пн" , "вт" , "ср" , "чт" , "пт" , "сб" , "вс" );
        $en_days = array(1 => "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");

        //Week block ajax

        if(isset($_POST['block']) && $_POST['block'] == "week-block"){
            if($_POST['arrow'] == 'left'){
                $_SESSION['pointer']--;
            }if($_POST['arrow'] == 'right'){
                $_SESSION['pointer']++;
            }

            for($i = $_SESSION['pointer']-1; $i < $_SESSION['pointer'] + 2; $i++):?>
                <?php $symbol = ''; if($i >= 0){ $symbol = '+';}?>
                <div class="week-block text-center <?php if($i == $_SESSION['pointer']){echo "active-week";} ?>">
                    <span><b><?php echo date('W',strtotime('sunday this week ' . $symbol . $i . ' week'));?></b></span><br>
                    <span class="text-center">
                        <?php echo date('d',strtotime('monday this week '. $symbol . $i . ' week'));?> -
                        <?php echo date('d',strtotime('sunday this week '. $symbol . $i . ' week')); ?>
                        <?php echo $month[date('m',strtotime('sunday this week '. $symbol . $i . ' week')) - 1].'<br>';?>
                        <?php echo date('Y',strtotime('monday this week ' . $symbol . $i . ' week'));?>
                    </span>
                </div>
            <?php endfor;?><?php
        }

        //Days block ajax
        if(isset($_POST['block']) && $_POST['block'] == "day-block") :?>
            <?php $symbol = ''; if($_SESSION['pointer'] >= 0){$symbol = "+";} $date = strtotime($_POST['day']." this week ". $symbol . $_SESSION['pointer'] . ' week');?>
           <?php echo "<span date='".date("Y-m-d", $date)."'>" . date("d-m", $date) . "</span>"; ?>
        <?php endif;

        //Day shift block
        if(isset($_POST['block']) && $_POST['block'] == "day-shift-block"){
            $dayShift = Shift::getUsersFromShift('day', $_POST['date']);
            for($i = 0; $i < count($dayShift); $i++){
                $cur_user = User::getUserById($dayShift[$i]["id_user"]);
                echo "<li id='li-ud-" . $cur_user['u_id'] . "'>
                        <input class='form-check-input ' type='checkbox' id='nс-ud-".$cur_user['u_id'] ."'>
                        <label class='form-check-label' id='l-ud-". $cur_user['u_id']."' for='nc-ud-".$cur_user['u_id']."'>".$cur_user['u_fname'] . " " . $cur_user['u_sname']."</label>
                    </li>";
            }
        }

        //Night shift block
        if(isset($_POST['block']) && $_POST['block'] == "night-shift-block"){
            $nightShift = Shift::getUsersFromShift('night', $_POST['date']);
            for($i = 0; $i < count($nightShift); $i++){
                $cur_user = User::getUserById($nightShift[$i]["id_user"]);
                echo "<li id='li-un-" . $cur_user['u_id'] . "'>
                        <input class='form-check-input ' type='checkbox' id='nс-un-".$cur_user['u_id'] ."'>
                        <label class='form-check-label' id='l-un-". $cur_user['u_id']."' for='nc-un-".$cur_user['u_id']."'>".$cur_user['u_fname'] . " " . $cur_user['u_sname']."</label>
                    </li>";
            }
        }

        // Add menu block
        if(isset($_POST['menu']) && $_POST['menu'] == 'menu'){
            $usersFromProduction = User::getUsersFromProduction();
            $date = $_POST['date'];

            //Список людей які є в денній зміні
            $dayShift = Shift::getUsersFromShift('day', $date);

            //Видалення з списку меню людей які є в денній зміні
            for($i = 0; $i < count($dayShift); $i++){
                $c_user = User::getUserById($dayShift[$i]["id_user"]);
                foreach ($usersFromProduction as $k => $u_p){
                    if($c_user['u_id'] == $u_p['u_id']){
                        unset($usersFromProduction[$k]);
                    }
                }
            }

            //Список людей які є в нічній змінні
            $nightShift = Shift::getUsersFromShift('night', $date);

            //Видалення з списку меню людей які є в нічній зміні
            for($i = 0; $i < count($nightShift); $i++){
                $c_user = User::getUserById($nightShift[$i]["id_user"]);
                foreach ($usersFromProduction as $k => $u_p){
                    if($c_user['u_id'] == $u_p['u_id']){
                        unset($usersFromProduction[$k]);
                    }
                }
            }

            //Запис в список меню денної зміни людей
            if(isset($_POST['block']) && $_POST['block'] == 'add-day-menu-block'){
                foreach ($usersFromProduction as $user):?>
                    <a onclick="addUserDay(this)" class="user-day" id="ud-<?php echo $user['u_id'];?>"><?php echo $user['u_fname'] . ' ' . $user['u_sname'];?></a>
                <?php endforeach;
            }
            //Запис в список меню нічної зміни людей
            if(isset($_POST['block']) && $_POST['block'] == 'add-night-menu-block'){

                foreach ($usersFromProduction as $user):?>
                    <a onclick="addUserNight(this)" class="user-night" id="un-<?php echo $user['u_id'];?>"><?php echo $user['u_fname'] . ' ' . $user['u_sname'];?></a>
                <?php endforeach;
            }
        }

        //Save block
        if(isset($_POST['block']) && $_POST['block'] == "save-block"){
            $dayShift = json_decode($_POST['day_shift']);
            $nightShift = json_decode($_POST['night_shift']);
            $date = $_POST['date'];
            $check = json_decode($_POST['check']);

            if($check){
                $week = date('W', strtotime($date));
                $day = strtotime($date);
                while($week == date('W', $day)){
                    Shift::saveShift($dayShift, date('Y-m-d', $day), 'day');
                    Shift::saveShift($nightShift, date('Y-m-d', $day), 'night');
                    $day =  strtotime('+1 day', $day);
                }
            }else{
                Shift::saveShift($dayShift, $date, "day");
                Shift::saveShift($nightShift, $date, "night");
            }

            echo "<span class='text-success message'>Успешно сохранено!</span>";
        }

        //Transfer block
        if(isset($_POST['block']) && $_POST['block'] == "transfer-block"){
            $dayShift = json_decode($_POST['day_shift']);
            $nightShift = json_decode($_POST['night_shift']);
            $date = $_POST['date'];

            $dateNextMonday = date('Y-m-d',strtotime($date . ' next monday'));
            $dateNextSunday = date('Y-m-d', strtotime( $dateNextMonday. ' next sunday'));
            $day = strtotime($dateNextMonday);
            while($day <= strtotime($dateNextSunday)){
                Shift::saveShift($dayShift, date('Y-m-d', $day), 'day');
                Shift::saveShift($nightShift, date('Y-m-d', $day), 'night');
                $day =  strtotime('+1 day', $day);
            }

            echo "<span class='text-success message'>Смены успешно перенесено!</span>";
        }
        return true;
    }
}