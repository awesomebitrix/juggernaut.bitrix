<?php

namespace Jugger\Context;

/**
 * компонент (не в нотации Битрикс) ленивой загрузки данных на страницу
 * порядок загрузки:
 * 1. Инициализация загрузки: генерация JS кода и отправка AJAX запроса к серверу на догрузку данных
 * 2. Догрузка данных: парсинг ответа сервера:
 *      - если ошибка: запись в консоль JS объект ответа (XMLHttpRequest)
 *      - если задан <b>callback</b>: вызов функции, в качестве параметра отправляется объект ответа (XMLHttpRequest)
 *      - иначе: вывод ответа в контейнер с указанным <b>uniqId</b>
 * 3. Инициализация PJAX:
 *      3.1. если задан атрибут PJAX в параметрах компонента, то шаг 3.1, иначе выход
 *      3.2. если доступны либы jQuery и PJAX, то шаг 3.2, иначе выход
 *      3.3. привязка PJAX к событиями указанным в параметрах
 * @author Ilya Rupasov <i.rpsv@live.com>
 */
class CompoJax
{
    /**
     * дополнительные параметры:
     * - url: адрес по которому делается запрос (по умолчанию: self запрос, на тот же адрес).
     * Также к любому URL добавляются параметры запроса 'requestKey' и 'uniqId'
     * - loading: контент HTML который выводиться вместо контент при загрузке
     * - requestKey: имя GET параметры, в котором будет содержаться 'uniqId'
     * - callback: функция, которая будет вызываться после получения ответа от сервера при догрузке данных
     * - pjax: массив данных для инициализации PJAX. Формат данных:
     *      - selector: список селекторов в формате строки CSS. Например, 'a.pjax', 'form#myform', '.className', ...
     *      - container: контейнер, куда будет грузиться данные (по умолчанию: контейнер с id равным uniqId)
     *      - options: остальные настройки PJAX библиотеки. Подробнее: https://github.com/defunkt/jquery-pjax#pjax-options
     * @var array
     */
    protected static $params;
    /**
     * идентификатор, который уникально определяет данный блок,
     * в рамках работы скрипта и на странице
     * @var string
     */
    protected static $uniqId;
    /**
     * имя GET параметра, которые содержит uniqId текущего блока (по умолчанию: 'compojaxuniqid')
     * @var string 
     */
    protected static $requestKey;
    /**
     * флаг определяющий, первое ли обращение к классу или нет
     * именно к классу (CompoJax), а не блоку (CompoJax::begin)
     * @var boolean
     */
    protected static $isFirstCall = true;
    /**
     * начала блока ленивой загрузки
     * все содержимое внутри данного блока (до вызова CompoJax::end)
     * будет обернуто в JS и загрузиться асинхронно через AJAX
     * @param string $uniqId уникальный идентификтор блока как в рамках PHP скрипта, так и на странице HTML
     * @param array $params конфигурация блока
     * @return boolean TRUE - если AJAX запрос относиться к данному блоку и нужно вывести данные, иначе FALSE
     */
    public static function begin($uniqId, array $params = []) {
        self::$uniqId = $uniqId;
        self::processParams($params);
        //
        if (self::isValidRequest()) {
            self::clearBuffer();
            return true;
        }
        elseif (self::existRequest() === false) {
            self::printLazyLoadJs();
        }
        return false;
    }
    /**
     * выводит содержимое блока ленивой загрузки
     * а также выводит скрипты PJAX (подключать его нужно отдельно и выше по коду)
     * для кастомизации для разных CMS и проектов, достаточно перегрузить данный метод
     */
    public static function end() {
        ob_end_flush();
        self::processPjax();
        die();
    }
    /**
     * выводит на PJAX скрипт на основе конфигурации блока
     * @param array $pjax параметры PJAX @see CompoJax::$params
     */
    protected static function printPjaxJs(array $pjax) {
        $re = "/[^a-z0-9\\.\\#\\=\\'\\\"](form)[^a-z]+|^(form)[^a-z]+|^(form)$/im"; // для поиска формы
        //
        echo "_PJAX_JS_(function(){\n";
        echo "if (typeof jQuery === 'undefined' || typeof jQuery.pjax === 'undefined') { return; };\n";
        echo "jQuery(function($){\n";
        foreach ($pjax as $item) {
            $selector = $item['selector'];
            $container = isset($item['container']) ? $item['container'] : "#".self::$uniqId;
            if (empty($selector)) {
                continue;
            }
            $options = isset($item['options']) ? $item['options'] : null;
            $event = preg_match($re, $selector) > 0
                ? 'submit'
                : 'click';
            self::printPjaxItemJs($selector, $event, $container, $options);
        }
        echo "});\n})();\n";
    }
    /**
     * выводит биндинг PJAX событий для конкретного элемента
     * @param string $selector селектор к которому привязывается событие
     * @param string $event событие к которому идет привязка ('submit' или 'click')
     * @param string $container HTML контейнер в который будет происходить выгрузка AJAX запроса
     * @param array  $options параметры PJAX
     */
    protected static function printPjaxItemJs($selector, $event, $container, array $options = null) {
        echo "$(document).on('{$event}', '{$selector}', function(event) {\n";
        if ($options) {
            $options = json_encode($options);
            echo "$.pjax.{$event}(event, '{$container}', {$options});";
        }
        else {
            echo "$.pjax.{$event}(event, '{$container}');";
        }
        echo "\n});\n";
    }
    /**
     * вывод JS для организации ленивой загрузки блока
     */
    protected static function printLazyLoadJs() {
        $id = self::$uniqId;
        $param = self::$requestKey;
        //
        $url = self::$params['url'];
        $loading = self::$params['loading'];
        $callback = self::$params['callback'];
        //
        if (self::$isFirstCall) {
            self::$isFirstCall = false;
            self::printCompoJaxJs();
        }
        echo <<<HTML
<div id="{$id}">
    {$loading}
    <script>
        (function(){
            var url = '{$url}';
            if (url === '') {
                url = location.pathname;
                if (location.search === '') {
                    url += '?{$param}={$id}';
                }
                else {
                    url += location.search + '&{$param}={$id}';
                }
            }
            var id = '{$id}';
            var callback = {$callback};
            compoJax.sendRequest(url, id, callback);
        })();
    </script>
</div>
HTML;
    }
    /**
     * проверка соотвествия запросу, к данному блоку
     * уникальность блока и соотвествие определяется по 'uniqId' и 'requestKey'
     * @return boolean TRUE - если запрос относиться к данному блоку
     */
    protected static function isValidRequest() {
        return self::existRequest() && $_GET[self::$requestKey] === self::$uniqId;
    }
    /**
     * проверка: содержит ли запрос данные для этого блока
     * @return boolean TRUE - если запрос относиться к данному блоку
     */
    protected static function existRequest() {
        return isset($_GET[self::$requestKey]);
    }
    /**
     * отчистка буфера
     * для кастомизации для CMS
     * нужно перегрузить данные метод (также как метод 'end')
     * @global \CMain $APPLICATION
     */
    protected static function clearBuffer() {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
    }
    /**
     * проверка на необходимость вывода
     * и собственно вывод PJAX блока
     */
    protected static function processPjax() {
        if ( ! empty(self::$params['pjax'])) {
            $pjax = self::$params['pjax'];
            self::printPjaxJs($pjax);
        }
    }
    /**
     * инициализация параметров по умолчанию
     * @param array $params
     */
    protected static function processParams(array $params) {
        self::$params = $params;
        if ( ! isset($params['callback'])) {
            self::$params['callback'] = 'null';
        }
        if ( ! isset($params['requestKey'])) {
            self::$requestKey = 'compojaxuniqid';
        }
    }
    /**
     * вывод JS скрипта инициализирующего объект compoJax
     */
    public static function printCompoJaxJs() {
        echo <<<HTML
<script>
window.compoJax = {
    /**
     * параметры запроса
     */
    params: {},
    /**
     * кросс-платформенное создание объекта XMLHttpRequest
     */
    createXHR: function() {
        var XMLHttpFactories = [
            function () {return new XMLHttpRequest()},
            function () {return new ActiveXObject("Msxml2.XMLHTTP")},
            function () {return new ActiveXObject("Msxml3.XMLHTTP")},
            function () {return new ActiveXObject("Microsoft.XMLHTTP")}
        ];
        //
        var xmlhttp = false;
        for (var i=0;i<XMLHttpFactories.length;i++) {
            try {
                xmlhttp = XMLHttpFactories[i]();
            }
            catch (e) {
                continue;
            }
            break;
        }
        return xmlhttp;
    },
    /**
     * отправка AJAX запроса
     */
    sendRequest: function(url, id, callback) {
        var context = {
            'id': id,
            'url': url
        };
        var xhr = this.createXHR();
        xhr.onreadystatechange = function() {
            if (xhr.readyState != 4) {
                return;
            }
            else if (typeof callback === "function") {
                callback(xhr, context);
            }
            else if (xhr.status != 200) {
                console.log(xhr);
            }
            else {
                var res = xhr.responseText.split('_PJAX_JS_');
                document.getElementById(id).innerHTML = res[0];
                if (res[1] !== undefined) {
                    var scr = document.createElement('script');
                        scr.innerHTML = res[1];
                    document.getElementById(id).appendChild(scr);
                }
            }
        };
        xhr.open("GET", url, true);
        xhr.send();
    }
};
</script>
HTML;
    }
}