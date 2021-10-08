<?php

class SiteController
{

    public static $lastUserId;
    /**
     * Action для сторінки Вхід на сайт
     */
    public function actionLogin()
    {
        // Поля форми
        $login = false;
        $password = false;

        // Обробка форми
        if (isset($_POST['submit'])) {
            // Якщо форма відправлена
            // Отримуємо дані із форми
            $login = $_POST['login'];
            $password = $_POST['password'];

            // Змінна для помилок
            $errors = false;

            // Провіряємо чи користувач існує
            $userId = User::checkUserData($login, $password);

            if ($userId == false) {
                // Якщо дані не вірні показуємо помилку
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                // Якщо дані вірні запам'ятовуємо користувача в сесію
                User::auth($userId);
                $user = User::getUserById($userId);

                if($user['u_role'] == 1){
                    //Якщо користувач адмін перенаправляємо його до адмін панелі
                    header("Location: /admin/dashboard");
                }else{
                    // Перенаправляємо користувача в закриту частину Кабінет
                    header("Location: /cabinet/machine-selection");
                }
            }
        }

        // Перевірка чи існує сесія з таким користувачем
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user'];
            $user = User::getUserById($userId);
        }

        // Підключаємо вид
        require_once(ROOT . '/views/site/login.php');
        return true;
    }

    /**
     * Видаляємо дані користувача із сесії
     */
    public function actionLogout()
    {
        // Стартуємо сесію
        session_start();

        // Видаляємо дані про користувача із сесії
        unset($_SESSION["user"]);

        // Перенаправляємо користувача на форму входу
        header("Location: /");
    }

    public function actionKitchen(){

        // Встановлюємо з'єднання
        $dsn = "mysql:host=localhost;dbname=raspberryDB";
        $db = new PDO($dsn, 'orka', '1Gfhjkm1');

//        $result = $db->query('SELECT * FROM req ORDER BY `id` DESC LIMIT 6');
        $result = $db->query('SELECT max(id) as id, idCard, fio, max(date) as date, pathPhoto FROM req GROUP BY idCard, substring(date, 1, 10), fio, pathPhoto ORDER BY id DESC LIMIT 6');
        $persons = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $persons[$i]['id'] = $row['id'];
            $persons[$i]['idCard'] = $row['idCard'];
            $persons[$i]['fio'] = $row['fio'];
            $persons[$i]['date'] = $row['date'];
            $persons[$i]['pathPhoto'] = $row['pathPhoto'];
            $i++;
        }

        SiteController::$lastUserId = $persons[0]['id'];

        $date = date('m-d');

        require_once(ROOT . '/views/site/kitchen.php');
        return true;
    }

    public function actionKitchenAjax(){

        // Встановлюємо з'єднання
        $dsn = "mysql:host=localhost;dbname=raspberryDB";
        $db = new PDO($dsn, 'orka', '1Gfhjkm1');

//        $result = $db->query('SELECT * FROM req ORDER BY `id` DESC LIMIT 6');
        $result = $db->query('SELECT max(id) as id, idCard, fio, max(date) as date, pathPhoto FROM req GROUP BY idCard, substring(date, 1, 10), fio, pathPhoto ORDER BY id DESC LIMIT 6');
        $persons = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $persons[$i]['id'] = $row['id'];
            $persons[$i]['idCard'] = $row['idCard'];
            $persons[$i]['fio'] = $row['fio'];
            $persons[$i]['date'] = $row['date'];
            $persons[$i]['pathPhoto'] = $row['pathPhoto'];
            $i++;
        }

        //Якщо добавився навий запис в базу даних оновлюємо дані користувачів щоб не перегружати що разу
        if(SiteController::$lastUserId != $persons[0]['id']){

            SiteController::$lastUserId = $persons[0]['id'];

            $date = date('m-d');?>

            <?php foreach ($persons as $person):?>

    <!--        Відображення дати для записів які були пізніше-->
            <?php $person_date = substr($person['date'], 5, 5);
            if($person_date != $date){
               echo "<h4 class='text-center mt-3'><b>" . $person_date . "</b></h4>";
               $date = $person_date;
            } ?>
            <div id="content" class="row mt-3 person-item">
                <div class="col-md-3">
                    <img class="photo-person" width="150px" height="150px"
                         src="<?php if($person['pathPhoto'] != ''){
//                             echo $person['pathPhoto'];
                             echo "/layout/image/ivan.jpg";
                         }else{ echo "/layout/image/user.jfif";} ?>" alt="Користувач">
                </div>
                <div class="col-md-9 text-start">
                    <h2><?php echo $person['fio']; ?></h2>
                    <div class="text-end mb-3 time"><b class="person-time"><?php  echo 'Time: '. substr($person['date'], 11, 5); ?></b></div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php
        }
        return true;
    }



}