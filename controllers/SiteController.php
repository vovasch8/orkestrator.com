<?php

class SiteController
{

    static $lastUserId;
    /**
     * Action для сторінки Вхід на сайт
     */
    public function actionLogin()
    {
        // Поля форми
        $email = false;
        $password = false;

        // Обробка форми
        if (isset($_POST['submit'])) {
            // Якщо форма відправлена
            // Отримуємо дані із форми
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Змінна для помилок
            $errors = false;

            // Провіряємо чи користувач існує
            $userId = User::checkUserData($email, $password);

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

        $persons = User::getKitchenUsers();

        require_once(ROOT . '/views/site/kitchen.php');
        return true;
    }

    public function actionKitchenAjax(){

        $persons = User::getKitchenUsers();

        if(empty($persons)){
            echo '<h5 class="mt-5">Працівників поки немає!</h5>';
        }
             foreach ($persons as $person):?>

            <div id="" class="row mt-3 person-item">
                <div class="col-md-3">
                    <img class="photo-person" width="150px" height="150px"
                         src="<?php echo '/layout/image/persons/' . $person['u_identificator'] . '.jpg';?>" alt="Користувач">
                </div>
                <div class="col-md-9 text-start">
                    <h2><?php echo $person['u_fname'] . " " . $person['u_sname']; ?></h2>
                    <div class="text-end mb-3 time"><b class="person-time"><?php  echo 'Time: '. substr($person['date'], 11, 5); ?></b></div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php
        return true;
    }



}