<?php

namespace Jugger\Base;

class FrontController
{
    const EVENT_INIT            = 'mainOnInit';
    const EVENT_BEFORE_REQUEST  = 'mainOnBeforeRequest';
    const EVENT_AFTER_REQUEST   = 'mainOnAfterRequest';
    const EVENT_ERROR           = 'mainOnError';
    /**
     * Функция обработки ошибки
     * @var callable
     */
    protected $errorHandler;
    /**
     * Инициализация предварительных данных
     */
    public function __construct() {
        $this->initAutoloader();
        $this->initListeners();
        $this->initErrorHandler();
        //
        Event::trigger(self::EVENT_INIT);
    }
    /**
     * инициализация автозагрузчика,
     * для возможности неявно подключать классы модулей, без ручного подключения,
     * для возможности вызова класса компонентов напрямую (не через APPLICATION)
     */
    public function initAutoloader() {}
    /**
     * загружает файлы инициализации всех активных модулей.
     * вместо того чтобы вносить какие-либо изменения в файл 'php_interface/init.php'
     * нужно в каждом модуле, если это требуется,
     * создать файл 'init.php', который будет подгружаться в данном событии.
     * в файле 'init.php' можно вешать слушателей на любые события,
     * а также производить любые необходимые действия с учетом текущего этапа загрузки
     */
    public function initListeners() {}
    /**
     * Точка входа
     */
    public function run() {
        try {
            $this->onBeforeRequest();
            $response = $this->handleRequest();
            
            $this->onAfterRequest();
            $response->send();
            
            return $response->status;
        }
        catch (Exception $error) {
            call_user_func($this->errorHandler, $error);
            return $error->getCode();
        }
    }
    /**
     * событие ПЕРЕД обработкой запроса,
     * сюда можно повешать выполнение агентов
     */
    public function onBeforeRequest() {
        $this->initSite();
        $this->initUrlRewrite();
        //
        Event::trigger(self::EVENT_BEFORE_REQUEST);
    }
    /**
     * инициализируются параметры запрошеного сайта:
     * - id
     * - локализация (по-умолчанию)
     * - шаблон (по-умолчанию)
     * - ...
     */
    public function initSite() {}
    /**
     * инициализация URL менеджера
     */
    public function initUrlRewrite() {}
    /**
     * непосредственная обработка запроса,
     * определяет запрошеную страницу,
     * формирует объект ответа,
     * обработка запрошенной страницы,
     * подключает запрошенную страницу на основе полученного маршрута,
     * инициализирует контроллер страницы которые отвечает:
     * - за вывод данных
     * - за тип данных
     * - за подключение шаблона
     * - за атрибуты страницы
     * - др.
     */
    public function handleRequest() {
        list($page, $params) = $this->parseRequest();
        $pageController = new PageController($page);
        $pageController->params = $params;
        $pageController->run();
        return $pageController->response;
    }
    /**
     * событие ПОСЛЕ обработки запроса,
     * сюда можно повешать различные логгирования
     */
    public function onAfterRequest() {
        Event::trigger(self::EVENT_AFTER_REQUEST);
    }
    /**
     * вещает обработчика ошибок,
     * если не был установлен никакой кастомный
     */
    public function initErrorHandler() {
        if ($this->errorHandler === null) {
            /**
             * подключает страницы с соответствующими страницами
             */
            $this->errorHandler = function(Exception $error) {
                if ($error instanceof NotFoundHttpException) {
                    include '404.php';
                }
                elseif ($error instanceof BadRequestHttpException) {
                    include '400.php';
                }
                else {
                    include '500.php';
                }
            };
        }
    }
    /**
     * выполняет разбор запроса, на основе URL менеджера и текущего сайта
     */
    public function parseRequest() {}
}