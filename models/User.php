<?php
include_once ROOT . "/components/DB.php";

class User
{
    /**
     * Провіряє чи існує користувач із заданим $email и $password
     * @param string $email <p>login</p>
     * @param string $password <p>Пароль</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($email, $password)
    {
        // З'єднання з базою даних
        $db = Db::getConnection();

        // Текст запросу до БД
        $sql = 'SELECT * FROM users WHERE u_email = :u_email AND u_password = :u_password';

        // Отримання результату. Використовується підготовлений запрос
        $result = $db->prepare($sql);
        $result->bindParam(':u_email', $email, PDO::PARAM_STR);
        $result->bindParam(':u_password', $password, PDO::PARAM_STR);
        $result->execute();

        // Звернення до запису
        $user = $result->fetch();

        if ($user) {
            // Якщо запис існує повертається id користувача
            return $user['u_id'];
        }
        return false;
    }

    /**
     * Повертає користувача із заданим id
     * @param integer $id <p>id користувача</p>
     * @return array <p>Масив із інформацією про користувача</p>
     */
    public static function getUserById($id)
    {
        // З'єднання з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT * FROM users WHERE u_id = :u_id';

        // Отримання і повернення результату використовуючи підготовлений запрос
        $result = $db->prepare($sql);
        $result->bindParam(':u_id', $id, PDO::PARAM_INT);

        // Вказуємо що хочемо отримати результат у вигляді масиву
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    /**
     * Повертає список користувачів
     * @param integer $departament <p>Підрозділ компанії за замовчуванням IT подразделение</p>
     * @param integer $count <p>Кількість користувачів за замовчуванням 1000</p>
     * @return array <p>Масив із інформацією про користувачів</p>
     */
    public static function getListOfUsers($departament = 'IT подразделение', $count = 1000){
        // З'єднання з БД
        $db = Db::getConnection();

        if($departament != ''){
            $departament = ' WHERE u_departament = "' . $departament . '" ';
        }

        $sql = 'SELECT * FROM users ' . $departament . ' LIMIT ' . $count;

        $result = $db->query( $sql);
        $users = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $users[$i]['u_id'] = $row['u_id'];
            $users[$i]['u_fname'] = $row['u_fname'];
            $users[$i]['u_sname'] = $row['u_sname'];
            $users[$i]['u_email'] = $row['u_email'];
            $users[$i]['u_card'] = $row['u_card'];
            $i++;
        }

        return $users;
    }

    public static function getUsersFromProduction(){
        // З'єднання з БД
        $db = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE u_departament IN ("Производственное подразделение", "Подразделение склада", "Подразделение изготовления LED", "Админ производства")';

        $result = $db->query( $sql);
        $users = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $users[$i]['u_id'] = $row['u_id'];
            $users[$i]['u_fname'] = $row['u_fname'];
            $users[$i]['u_sname'] = $row['u_sname'];
            $users[$i]['u_email'] = $row['u_email'];
            $users[$i]['u_card'] = $row['u_card'];
            $i++;
        }

        return $users;
    }

    /**
     * Повертає список користувачів за сьогодні, які пікались на кухні
     * @return array <p>Масив із інформацією про користувачів</p>
     */
    public static function getKitchenUsers(){
        // З'єднання з БД
        $db = Db::getConnection();

//        $result = $db->query('SELECT * FROM piKitchen ORDER BY `id` DESC LIMIT 6');
        $result = $db->query('SELECT max(id) as id, value as card, max(created_at) as date, u.u_identificator, u.u_fname, u.u_sname, u.u_photo 
        FROM piKitchen as p INNER JOIN users as u ON u.u_card = p.value 
        WHERE substring(p.created_at, 1, 10) = CURRENT_DATE() GROUP BY u.u_card, substring(p.created_at, 1, 10), u.u_identificator, u.u_fname, u.u_sname, u.u_photo 
        ORDER BY id DESC LIMIT 6');

        $persons = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $persons[$i]['id'] = $row['id'];
            $persons[$i]['card'] = $row['card'];
            $persons[$i]['date'] = $row['date'];
            $persons[$i]['u_identificator'] = $row['u_identificator'];
            $persons[$i]['u_fname'] = $row['u_fname'];
            $persons[$i]['u_sname'] = $row['u_sname'];
            $persons[$i]['u_photo'] = $row['u_photo'];
            $i++;
        }

        return $persons;
    }

    /**
     * Повертає список користувачів з датою коли вони пікнулись на прохідній,
     * 2 значення відкриття та закриття робочого дня
     * @param string $departament <p>Підрозділ компанії</p>
     * @param string $flag <p>Вказує по якому критерію сортувати дані: день, тиждень, місяць</p>
     * @return array <p>Масив із інформацією про користувачів по 2 значення з відкриттям і закриттям робочого дня</p>
     */
    public static function getUsersRegisterTime($departament = 'IT подразделение', $flag = 'week'){
        // З'єднання з БД
        $db = Db::getConnection();
        $filter = '';
        $switch = '';

        if($departament != ''){
            $departament = ' WHERE u.u_departament = "' . $departament.'" AND t.t_is_work = "1"';
            switch ($flag){
                case 'day':{
                    $filter = ' AND SUBSTRING(t.t_date, 1, 10) = CURRENT_DATE()';
                    break;
                }case 'week':{
                    $filter = ' AND WEEK(t.t_date, 1) = WEEK(CURRENT_DATE(), 1)';
                    break;
                }case 'month':{
                    $filter = ' AND MONTH(t.t_date) = MONTH(CURRENT_DATE())';
                    break;
                }default:{
                    break;
                }

            }
        }

        $sql = 'SELECT u.u_id, u.u_fname, u.u_sname, u.u_departament, t.t_date FROM `time_register` as t INNER JOIN `users` as u ON t.t_card = u.u_card ' . $departament . $filter . ' ORDER BY u.u_id, t.t_date';

        $result = $db->query( $sql);
        $users = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $users[$i]['u_id'] = $row['u_id'];
            $users[$i]['u_fname'] = $row['u_fname'];
            $users[$i]['u_sname'] = $row['u_sname'];
            $users[$i]['t_date'] = $row['t_date'];
            $i++;
        }

        return $users;
    }

    /**
     * Повертає кількість користувачів, які сьогодні пікнулись на прохідній
     * @param string $variant <p>Має 2 значення або Производство або Офис</p>
     * @return integer <p>Кількість користувачів які пікнулись на Производстве або Офисе</p>
     */
    public static function getCountUsers($variant){
        $db = Db::getConnection();

        $sql = '';

        if($variant == 'Производство'){
            $sql = 'SELECT u.u_id, u.u_fname, u.u_sname FROM `users` as u INNER JOIN `time_register` as t ON u.u_card = t.t_card WHERE u.u_departament IN("Производственное подразделение", "Подразделение склада", "Подразделение изготовления LED", "Админ производства") AND  substring(t.t_date, 1, 10) = CURRENT_DATE() GROUP BY u.u_id';
        }elseif ($variant == 'Офис') {
            $sql = 'SELECT u.u_id, u.u_fname, u.u_sname FROM `users` as u INNER JOIN `time_register` as t ON u.u_card = t.t_card WHERE u.u_departament 
            IN("IT подразделение", "Директорат", "Подразделение продаж", "Логистическое подразделение", "Подразделение закупки", "Подразделение маркетинга", "ВЕД подразделение", "Подразделение бухгалтерии", "Юридическое подразделение", "Подразделение питания"
            "HR подразделение", "Сервисное подразделение", "Логистическое подразделение (лагерунг)")  AND  substring(t.t_date, 1, 10) = CURRENT_DATE()  GROUP BY u.u_id';
        }

        $result = $db->query( $sql);
        $users = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $users[$i]['u_id'] = $row['u_id'];
            $users[$i]['u_fname'] = $row['u_fname'];
            $users[$i]['u_sname'] = $row['u_sname'];
            $i++;
        }

        return count($users);
    }

    /**
     * Редактування даних користувач
     * @param integer $id <p>id користувача</p>
     * @param string $name <p>Імя</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function editUser($id, $fname, $sname, $login,  $password, $card, $photo, $departament, $position, $phone, $inner_phone, $isAdmin, $isDinner)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE users 
            SET u_fname = :u_fname, u_sname = :u_sname, u_email = :u_email, u_password = :u_password, u_card = :u_card,
            u_photo = :u_photo, u_departament = :u_departament, u_position = :u_position, 
            u_phone = :u_phone, u_inner_phone = :u_inner_phone, u_role = :u_role, u_dinner = :u_dinner
            WHERE u_id = :u_id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':u_id', $id, PDO::PARAM_INT);
        $result->bindParam(':u_fname', $fname, PDO::PARAM_STR);
        $result->bindParam(':u_sname', $sname, PDO::PARAM_STR);
        $result->bindParam(':u_email', $login, PDO::PARAM_STR);
        $result->bindParam(':u_password', $password, PDO::PARAM_STR);
        $result->bindParam(':u_card', $card, PDO::PARAM_STR);

        $result->bindParam(':u_photo', $photo, PDO::PARAM_STR);
        $result->bindParam(':u_departament', $departament, PDO::PARAM_STR);
        $result->bindParam(':u_position', $position, PDO::PARAM_STR);
        $result->bindParam(':u_phone', $phone, PDO::PARAM_STR);
        $result->bindParam(':u_inner_phone', $inner_phone, PDO::PARAM_STR);
        $result->bindParam(':u_role', $isAdmin, PDO::PARAM_INT);
        $result->bindParam(':u_dinner', $isDinner, PDO::PARAM_BOOL);

        return $result->execute();
    }

    /**
     * Зберігаємо користувача в сесії
     * @param integer $userId <p>id користувача</p>
     */
    public static function auth($userId)
    {
        // Записуємо id користувача в сесію
        $_SESSION['user'] = $userId;
    }

    /**
     * Повертає ідентифікатор користувача якщо він авторизований.<br/>
     * Якщо ні перенаправляє користувача на сторінку авторизації
     * @return string <p>Ідентифікатор користувача</p>
     */
    public static function checkLogged()
    {
        // Якщо сесія існує повертаємо id користувача
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        //Якщо сесії не існує перенапрявляємо користувача на сторінку авторизації
        header("Location: /site/login");
    }

    /**
     * Перевіряє чи користува увійшов у систему
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function isUserInSystem()
    {
        if (isset($_SESSION['user'])) {
            return true;
        }
        return false;
    }

    /**
     * Перевіряє чи користувач є адміном
     * @param integer $userId <p>Ідентифікатор</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function isAdmin($userId){

        $user = User::getUserById($userId);

        if($user['u_role'] == 1){
            return true;
        }

        //Якщо користувач не адмін перенаправляємо його до форми реєстрації
        header("Location: /site/login");
    }

    /**
     * Реєстрація користувача
     * @param string $fname <p>Ім'я</p>
     * @param string $sname <p>Прізвище</p>
     * @param string $email <p>Логін</p>
     * @param string $password <p>Пароль</p>
     * @param integer $isAdmin <p>Роль</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function register($id, $fname, $sname, $email,  $password, $card, $photo, $departament, $position, $phone, $inner_phone, $isAdmin, $isDinner)
    {
        // З'єднання з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'INSERT INTO users (u_identificator, u_fname, u_sname, u_email, u_password, u_card, u_photo, u_departament, u_position, u_phone, u_inner_phone, u_role, u_dinner) '
            . 'VALUES (:u_identificator, :u_fname, :u_sname, :u_email, :u_password, :u_card, :u_photo, :u_departament, :u_position, :u_phone, :u_inner_phone, :u_role, :u_dinner)';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':u_identificator', $id, PDO::PARAM_INT);
        $result->bindParam(':u_fname', $fname, PDO::PARAM_STR);
        $result->bindParam(':u_sname', $sname, PDO::PARAM_STR);
        $result->bindParam(':u_email', $email, PDO::PARAM_STR);
        $result->bindParam(':u_password', $password, PDO::PARAM_STR);
        $result->bindParam(':u_card', $card, PDO::PARAM_STR);

        $result->bindParam(':u_photo', $photo, PDO::PARAM_STR);
        $result->bindParam(':u_departament', $departament, PDO::PARAM_STR);
        $result->bindParam(':u_position', $position, PDO::PARAM_STR);
        $result->bindParam(':u_phone', $phone, PDO::PARAM_STR);
        $result->bindParam(':u_inner_phone', $inner_phone, PDO::PARAM_STR);
        $result->bindParam(':u_role', $isAdmin, PDO::PARAM_INT);
        $result->bindParam(':u_dinner', $isDinner, PDO::PARAM_BOOL);
        return $result->execute();
    }

    /**
     * Провіряє чи ім'я не меньше 2 символів
     * @param string $name <p>Ім'я</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    /**
     * Перевіряє чи стрічка не меньше 6 символів
     * @param string $str <p>Стрічка</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function checkLength($str)
    {
        if (strlen($str) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Перевіряє чи логін вже не зайнятий
     * @param string $email <p>Login</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function checkLoginExists($email)
    {
        // З'єднання з базою даних
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT * FROM users WHERE u_email = :u_email';

        // Отримання результатів використовуючи підготовлений запит
        $result = $db->prepare($sql);
        $result->bindParam(':u_email', $email, PDO::PARAM_STR);
        $result->execute();


        if ($result->fetchColumn()){
            return true;
        }
        return false;
    }

    /**
     * Перевіряє чи id вже не зайнятий
     * @param integer $id <p>Login</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function checkIdExists($id)
    {
        // З'єднання з базою даних
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT * FROM users WHERE u_identificator = :u_identificator';

        // Отримання результатів використовуючи підготовлений запит
        $result = $db->prepare($sql);
        $result->bindParam(':u_identificator', $id, PDO::PARAM_INT);
        $result->execute();


        if ($result->fetchColumn()){
            return true;
        }
        return false;
    }

}