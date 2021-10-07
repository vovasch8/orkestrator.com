<?php
include_once ROOT . "/components/DB.php";

class User
{
    /**
     * Провіряє чи існує користувач із заданим $email и $password
     * @param integer $login <p>login</p>
     * @param string $password <p>Пароль</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($login, $password)
    {
        // З'єднання з базою даних
        $db = Db::getConnection();

        // Текст запросу до БД
        $sql = 'SELECT * FROM users WHERE u_card = :u_card AND u_password = :u_password';

        // Отримання результату. Використовується підготовлений запрос
        $result = $db->prepare($sql);
        $result->bindParam(':u_card', $login, PDO::PARAM_INT);
        $result->bindParam(':u_password', $password, PDO::PARAM_STR);
        $result->execute();

        // Звернення до запису
        $user = $result->fetch();

        if ($user) {
            // Якщо запис існує повертається id користувача
            return $user['id'];
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
        $sql = 'SELECT * FROM users WHERE id = :id';

        // Отримання і повернення результату використовуючи підготовлений запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Вказуємо що хочемо отримати результат у вигляді масиву
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
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

        if($user['u_roles'] == 1){
            return true;
        }

        //Якщо користувач не адмін перенаправляємо його до форми реєстрації
        header("Location: /site/login");
    }

    /**
     * Реєстрація користувача
     * @param string $fname <p>Ім'я</p>
     * @param string $sname <p>Прізвище</p>
     * @param integer $login <p>Логін</p>
     * @param string $password <p>Пароль</p>
     * @param integer $isAdmin <p>Роль</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function register($fname, $sname, $login, $password, $isAdmin)
    {
        // З'єднання з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'INSERT INTO users (u_fname, u_sname, u_card, u_password, u_roles) '
            . 'VALUES (:u_fname, :u_sname, :u_card, :u_password, :u_roles)';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':u_fname', $fname, PDO::PARAM_STR);
        $result->bindParam(':u_sname', $sname, PDO::PARAM_STR);
        $result->bindParam(':u_card', $login, PDO::PARAM_INT);
        $result->bindParam(':u_password', $password, PDO::PARAM_STR);
        $result->bindParam(':u_roles', $isAdmin, PDO::PARAM_INT);
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
     * Перевіряє чи логін вже не зайнятий
     * @param integer $login <p>Login</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function checkLoginExists($login)
    {
        // З'єднання з базою даних
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT * FROM users WHERE u_card = :u_card';

        // Отримання результатів використовуючи підготовлений запит
        $result = $db->prepare($sql);
        $result->bindParam(':u_card', $login, PDO::PARAM_STR);
        $result->execute();


        if ($result->fetchColumn()){
            return true;
        }
        return false;
    }

}