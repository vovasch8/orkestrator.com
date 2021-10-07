<?php

/**
 * Клас Db
 * Компонент для роботи з базою даних
 */
class Db
{

    /**
     * Встановлює з'єднання з базою даних
     * @return \PDO <p>Об'єкт класу PDO для роботи з БД</p>
     */
    public static function getConnection()
    {
        // Отримуємо параметри підключення з файлу
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);

        // Встановлюємо з'єднання
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);

        // Задаємо кодировку
        $db->exec("set names utf8");

        return $db;
    }

}