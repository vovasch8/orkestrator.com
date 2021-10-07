<?php

class CabinetController
{
    public function actionMachineSelection(){

        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        require_once(ROOT . "/views/cabinet/machine_selection.php");
        return true;
    }

    public function actionOrder(){

        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        require_once (ROOT . "/views/cabinet/order.php");
        return true;
    }

    public function actionChoiceMaterial(){

        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        require_once (ROOT . "/views/cabinet/choice_material.php");
        return true;
    }

    public function actionAdjustment(){

        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        require_once (ROOT . "/views/cabinet/adjustment.php");
        return true;
    }

    public function actionAdjustmentTask(){

        // Перевіряємо чи користувач увійшов, отримуємо його id
        $userId = User::checkLogged();

        // Отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        require_once (ROOT . "/views/cabinet/adjustment_task.php");
        return true;
    }
}