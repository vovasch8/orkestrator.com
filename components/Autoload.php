<?php

/**
 * Функція __autoload для автоматичного підключення файлів
 */
function loadFiles($class_name)
{
    // Масив папок, в яких знаходяться необхідні файли
    $array_paths = array(
        '/models/',
        '/components/',
        '/controllers/',
    );

    // Проходимо по масиву папок
    foreach ($array_paths as $path) {

        // Формуємо ім'я та шлях до файлу з класом
        $path = ROOT . $path . $class_name . '.php';

        // Якщо файл існує підключаємо його до системи
        if (is_file($path)) {
            include_once $path;
        }
    }
}

spl_autoload_register("loadFiles");