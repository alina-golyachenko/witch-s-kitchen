<?php

namespace Core;

/**
 * Главный класс ядра системы. Запускается первым в главном index.php
 * {синглтон}
 */
require "vendor/autoload.php";
class Core
{
    private static $instance;
    private static $mainTemplate;
    private static $db;
    private static $globalError = false;
    private function __construct(){
        global $Config;
        spl_autoload_register('Core\\Core::__autoload');
        self::$db = new \Core\DB(
            $Config['Database']['Server'],
            $Config['Database']['Username'],
            $Config['Database']['Password'],
            $Config['Database']['Database']
        );
    }

    /**
     * Возвращает экземпляр ядра системы
     * @return Core
     */
    public static function getInstance(){

        if(empty(self::$instance)){
            self::$instance = new Core();
            return self::getInstance();
        }
        else{
            return self::$instance;
        }
    }

    /**
     * Получаем объект для  соединения с БД
     */

    public function getDB()
    {
        return self::$db;
    }

    /**
     * Инициализация системы.
     * Начинает сессию,добавляет автозагрузку классов,
     * добавляет подсоединение к бд
     */
    # будет инициализировать всю систему
    public function init(){
        session_start();

        # добавляем автозагрузку классов
        self::$mainTemplate = new Template();
    }

    /**
     * Автозагружает классы (чтобы не писать постоянно include)
     * @param $className
     *
     */
    public static function __autoload($className){
        $fileName = $className.'.php';
        if(is_file($fileName)){
            include($fileName);
        }
    }

    /**
     * Делает парсинг url-адреса и находит нужный контроллер
     */

    # получаем класс и название метода из
    # адресной строки. Затем вызываем контроллер,
    # подходящий по имени классу и также метод
    public function run(){

        # из адресной строки вытаскиваем адрес
//        $path = $_GET['path'];
//        var_dump($_GET['path']);
        $path = $_SERVER['REQUEST_URI'];

        # разбиваем адрес на кусочки
//        if (count($path) !== 1){
//            array_shift();
//        }
        $pathParts = explode('/', $path);
        var_dump($pathParts);
        # вытаскиваем имя класса. Если такого нет, ставим класс по умолчанию
        $className = ucfirst($pathParts[0]);
        var_dump(ucfirst($pathParts[0]));
        var_dump(ucfirst($pathParts[1]));
        if(empty($className) && empty($pathParts[1])){
            # получаем полный путь к классу
            $fullClassName = 'Controllers\\Recipes';
        }
        else if (empty($className) && !empty($pathParts[1])){
            $fullClassName = 'Controllers\\'.$pathParts[1];
        }
        else{
            $fullClassName = 'Controllers\\'.$className;
        }


        # получаем имя нужного метода
        $methodName = ucfirst($pathParts[1]);
        # если метода нет, вызываем тот, что по
        # умолчанию, чтобы не было ошибки
        if(empty($methodName)){
            # получаем полный путь к методу
            $fullMethodName = 'actionIndex';
        }
        else{
            $fullMethodName = 'action'.$methodName;
        }
        var_dump($fullClassName);
        var_dump(class_exists($fullClassName));

        # Если такой класс есть в папке с контроллерами,
        # создаём объект одноименного контроллера
        if (class_exists($fullClassName)){
            # вот этот объект
            $controller = new $fullClassName();
            # если существует такой метод в контроллере
            if (method_exists($controller, $fullMethodName)){

                # Используем reflection api. Если в $_GET есть параметры, нужные для
                # метода, передаём их.
                # Если такого класса или метода нет, кидается эксепшн
                $method = new \ReflectionMethod($fullClassName, $fullMethodName);

                $paramsArray = [];
                foreach ($method -> getParameters() as $parameter){
                    array_push($paramsArray, isset($_GET[$parameter -> name]) ? $_GET[$parameter -> name] : null);
                }
                var_dump($paramsArray);

                # передаём массив не целиком, а как отдельные параметры
                $result = $method -> invokeArgs($controller, $paramsArray);
                var_dump($result);

                # устанавливаем нужные параметры для шаблона в приватное поле
                if (is_array($result)){
                    self::$mainTemplate -> setParams($result);
                }
            }
            else{
                self::$mainTemplate -> display('Views/Layout/404.php');
            }

        }
        else{
            self::$mainTemplate -> display('Views/Layout/404.php');
        }


    }

    /**
     * Завершает работу системы и выводит результат (шаблон)
     */
    public function done(){
        self::$mainTemplate -> display('Views/Layout/index.php');
    }


}