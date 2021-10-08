<?php
include_once ROOT . "/components/DB.php";

class User
{
    /**
     * Провіряє чи існує користувач із заданим $email и $password
     * @param string $login <p>login</p>
     * @param string $password <p>Пароль</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($login, $password)
    {
        // З'єднання з базою даних
        $db = Db::getConnection();

        // Текст запросу до БД
        $sql = 'SELECT * FROM users WHERE u_email = :u_email AND u_password = :u_password';

        // Отримання результату. Використовується підготовлений запрос
        $result = $db->prepare($sql);
        $result->bindParam(':u_email', $login, PDO::PARAM_INT);
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
     * @param integer $count <p>кількість користувачів</p>
     * @return array <p>Масив із інформацією про користувачів</p>
     */
    public static function getListOfUsers($count = 25){
        // З'єднання з БД
        $db = Db::getConnection();

        $sql = 'SELECT * FROM users LIMIT ' . $count;

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
     * Редактування даних користувач
     * @param integer $id <p>id користувача</p>
     * @param string $name <p>Імя</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function editUser($id, $fname, $sname, $login,  $password, $card, $photo, $departament, $position, $phone, $inner_phone, $isAdmin)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE users 
            SET u_fname = :u_fname, u_sname = :u_sname, u_email = :u_email, u_password = :u_password, u_card = :u_card,
            u_photo = :u_photo, u_departament = :u_departament, u_position = :u_position, 
            u_phone = :u_phone, u_inner_phone = :u_inner_phone, u_role = :u_role 
            WHERE u_id = :u_id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':u_id', $id, PDO::PARAM_INT);
        $result->bindParam(':u_fname', $fname, PDO::PARAM_STR);
        $result->bindParam(':u_sname', $sname, PDO::PARAM_STR);
        $result->bindParam(':u_email', $login, PDO::PARAM_STR);
        $result->bindParam(':u_password', $password, PDO::PARAM_STR);
        $result->bindParam(':u_card', $card, PDO::PARAM_INT);

        $result->bindParam(':u_photo', $photo, PDO::PARAM_STR);
        $result->bindParam(':u_departament', $departament, PDO::PARAM_STR);
        $result->bindParam(':u_position', $position, PDO::PARAM_STR);
        $result->bindParam(':u_phone', $phone, PDO::PARAM_STR);
        $result->bindParam(':u_inner_phone', $inner_phone, PDO::PARAM_STR);
        $result->bindParam(':u_role', $isAdmin, PDO::PARAM_INT);

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
     * @param string $login <p>Логін</p>
     * @param string $password <p>Пароль</p>
     * @param integer $isAdmin <p>Роль</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function register($id, $fname, $sname, $login,  $password, $card, $photo, $departament, $position, $phone, $inner_phone, $isAdmin)
    {
        // З'єднання з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'INSERT INTO users (u_id, u_fname, u_sname, u_email, u_password, u_card, u_photo, u_departament, u_position, u_phone, u_inner_phone, u_role) '
            . 'VALUES (:u_id, :u_fname, :u_sname, :u_email, :u_password, :u_card, :u_photo, :u_departament, :u_position, :u_phone, :u_inner_phone, :u_role)';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':u_id', $id, PDO::PARAM_INT);
        $result->bindParam(':u_fname', $fname, PDO::PARAM_STR);
        $result->bindParam(':u_sname', $sname, PDO::PARAM_STR);
        $result->bindParam(':u_email', $login, PDO::PARAM_STR);
        $result->bindParam(':u_password', $password, PDO::PARAM_STR);
        $result->bindParam(':u_card', $card, PDO::PARAM_INT);

        $result->bindParam(':u_photo', $photo, PDO::PARAM_STR);
        $result->bindParam(':u_departament', $departament, PDO::PARAM_STR);
        $result->bindParam(':u_position', $position, PDO::PARAM_STR);
        $result->bindParam(':u_phone', $phone, PDO::PARAM_STR);
        $result->bindParam(':u_inner_phone', $inner_phone, PDO::PARAM_STR);
        $result->bindParam(':u_role', $isAdmin, PDO::PARAM_INT);
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
     * @param string $login <p>Login</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function checkLoginExists($login)
    {
        // З'єднання з базою даних
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT * FROM users WHERE u_email = :u_email';

        // Отримання результатів використовуючи підготовлений запит
        $result = $db->prepare($sql);
        $result->bindParam(':u_email', $login, PDO::PARAM_STR);
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
        $sql = 'SELECT * FROM users WHERE u_id = :u_id';

        // Отримання результатів використовуючи підготовлений запит
        $result = $db->prepare($sql);
        $result->bindParam(':u_id', $id, PDO::PARAM_INT);
        $result->execute();


        if ($result->fetchColumn()){
            return true;
        }
        return false;
    }

}