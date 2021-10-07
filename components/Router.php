<?php

/**
 * Клас Router
 * Компонент для роботи з маршрутами сайту
 */
class Router
{

    /**
     * Властивість для зберігання масиву маршрутів
     * @var array
     */
    private $routes;

    /**
     * Конструктор
     */
    public function __construct()
    {
        // Шлях до файлу з роутами
        $routesPath = ROOT . '/config/routes.php';

        // Отримуємо роути з файлу
        $this->routes = include($routesPath);
    }

    /**
     * Повертає стрічку запросу
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     * Метод для обробки запиту
     */
    public function run()
    {
        // Отримуємо стрічку запросу
        $uri = $this->getURI();

        // Перевіряємо на наявність такого запросу в масиві маршрутів (routes.php)
        foreach ($this->routes as $uriPattern => $path) {

            // Порівнюємо $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {

                // Отримуємо внутрішній шлях із зовнішнього по правилу
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // Визначаємо контролер, екшн та параметри для виклику

                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;

                // Підключення файлу класу контроллера
                $controllerFile = ROOT . '/controllers/' .
                    $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                // Створюємо об'єкт викликаємо метод ( action)
                $controllerObject = new $controllerName;

                /* Викликаємо необхідний метод ($actionName) у визначеного
                 * класу ($controllerObject) із заданими ($parameters) параметрами
                 */
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                // Якщо метод контролера успішно запущено завершуємо роботу роутера
                if ($result != null) {
                    break;
                }
            }
        }
    }

}