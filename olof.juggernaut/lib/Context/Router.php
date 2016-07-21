<?php

namespace Jugger\Context;

use Jugger\Context\Router\NotFoundFile;

class Router
{
    /**
     * регулярное выражение,
     * которое подставляется к параметру по-умолчанию
     * @var string
     */
    protected $defaultRegExp = "[^\\/]+";
    /**
     * базовая директория,
     * от которой строиться путь к файлам маршрутов
     * @var string
     */
    protected $baseDir;
    /**
     * конструктор
     * @param string $baseDir базовая директория, если NULL или не указан параметр,
     * то подставляется значение DOCUMENT_ROOT
     */
    public function __construct($baseDir = null) {
        if (is_null($baseDir)) {
            $baseDir = $_SERVER['DOCUMENT_ROOT'];
        }
        $this->baseDir = rtrim($baseDir,"/") ."/";
    }
    /**
     * парсинг маршрута и подключение файла,
     * если текущий URL соответствует маршруту
     * @param mixed $pattern регулярное выражение (шаблон), или массив шаблонов маршрута.
     * формат записи маршрута:
     *  {nameParam},
     *  {nameParam:regExp}
     * где 'regExp' - регулярное выражение. Например, '\d+' или '[0-9]+'
     * @param string $file файл, которому соответствует указанный маршрут
     * @return \Router
     */
    public function run($pattern, $file) {
        if (is_array($pattern)) {
            foreach ($pattern as $p) {
                $this->runSingle($p, $file);
            }
        }
        else {
            $this->runSingle($pattern, $file);
        }
        return $this;
    }
    /**
     * парсинг единственного маршрута
     * @param string $pattern шаблон маршрута
     * @param string $file файл, которому соответствует указанный маршрут
     */
    protected function runSingle($pattern, $file) {
        $re = "/\\{([^\\}]+)\\}/";
        preg_match_all($re, $pattern, $segmentList);
        $segmentList = $segmentList[1];
        if ( ! empty($segmentList)) {
            $params = $this->getParamsAndReplaceRegExp($pattern, $segmentList);
        }
        $this->parseUri($pattern, $file, $params);
    }
    /**
     * замена шаблонов маршрутов на полноценные регулярные выражение
     * и создание списка параметров маршрута
     * @param string $pattern шаблон маршрута
     * @param array $segmentList
     * @return array список названий параметров в том порядке,
     * в каком они встречаются в маршруте
     */
    protected function getParamsAndReplaceRegExp(& $pattern, array $segmentList) {
        $params = [];
        foreach ($segmentList as $segment) {
            $re = $this->defaultRegExp;
            $data = preg_split("/:/", $segment);
            if (isset($data[1])) {
                $re = $data[1];
            }
            $pattern = preg_replace(
                "/\{".preg_quote($segment)."\}/",
                "(".$re.")",
                $pattern
            );
            $params[] = $data[0];
        }
        return $params;
    }
    /**
     * поиск файла с комнца маршрута
     * например, URL запроса выглядит так: "/catalog/section1/section2/element1/",
     * То поиск поочередно будет перебирать директории в поисках файла 'index.php':
     * - /catalog/section1/section2/element1/index.php
     * - /catalog/section1/section2/index.php
     * - /catalog/section1/index.php
     * - /catalog/index.php
     * в корень сайта опускаться поиск не будет
     * также никакие параметры не будут добавлены в переменные GET и REQUEST,
     * т.к. нет шаблона маршрута
     * данный способ хорошо подходит для стандартной ситуации Битрикс
     * когда маршрутизация ложится на плечи компонентов
     * @return \Router
     */
    public function runRecursive() {
        $uri = rtrim($this->getUri(), "/") ."/";
        while (false !== $p = strrpos($uri, "/")) {
            $uri = substr($uri, 0, $p);
            if ($uri === "" || preg_match("/\./", $uri) == true) {
                break;
            }
            $file = $this->baseDir . ltrim($uri,"/") . "/index.php";
            if (file_exists($file)) {
                include $file;
                die();
            }
        }
        return $this;
    }
    /**
     * возвращает URI без строки параметров
     * @return string
     */
    protected function getUri() {
        return preg_split("/\?/", $_SERVER['REQUEST_URI'])[0];
    }
    /**
     * парсинг текущего URI согласно указанному шаблону,
     * если URI соответствует шаблону, то подключается соответствующий файд
     * и выполнение скрипта прекращается
     * @param string $pattern шаблон маршрута
     * @param string $file файл, которому соответствует указанный маршрут
     * @param array $params список названий параметров
     * @throws NotFoundFile выбрасывается,
     * если указанный файл (соответствующий маршруту) не существует, недоступен или является символьной ссылкой (см. file_exist)
     */
    protected function parseUri($pattern, $file, array $params) {
        preg_match(
            "~^".$pattern."$~",
            $this->getUri(),
            $m
        );
        if ( ! empty($m)) {
            array_shift($m);
            $i=0;
            while (isset($params[$i])) {
                $_GET[ $params[$i] ] = $m[$i];
                $_REQUEST[ $params[$i] ] = $m[$i];
                $i++;
            }
            if (file_exists($file)) {
                include $file;
            }
            else {
                throw new NotFoundFile();
            }
            die();
        }
    }
    /**
     * окончание обработки,
     * подключение /bitrx/urlrewrite.php
     */
    public function end() {
        include_once $_SERVER['DOCUMENT_ROOT']."/bitrix/urlrewrite.php";
        die();
    }
}