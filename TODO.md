2. CJ: кешировать ответа сервера
2. валидаторы
2. сделать возможность добавить в роутер маршруты массивом
2. избавиться от Singleton'ов
1. QueryBuilder
1. виджеты для bootstrap
1. PJAX + Composite
2. трейт CacheObject (кеширует параметры объекта)
1. маршрутизация и единая точка входа (завязанная на HttpException)
1. PHPUnit
1. кеширование (зависимое и кеш переменных)
1. AssetsManager
1. набор компонентов для работы с административным интерфейсом
1. набор компонентов для работы с инфоблоками
1. Паттерн repository (?)
1. [PSR-14](https://github.com/php-fig/fig-standards/blob/master/proposed/event-manager.md) (?)

Разделение обязанностей (что-то вроде эталона кода):

```php
/*
 * список правил
 */
$urlRewrite = [
    [
        "name" => "catalog",
        "file" => "/catalog/index.php",
        "rules" => [
            "sectionList" => "catalog/",
            "elementList" => "catalog/{sectionCode}/",
            "elementView" => "catalog/{sectionCode}/{elementCode}/",
        ],
    ],
];
/*
 * генерация url по правилам
 */
Url::to("catalog/elementList", ["sectionCode" => "..."]);
/*
 * подключение виджета
 */
Widget::run([
    "property" => "value",
]);
/*
 * подключение виджета с внутренним содержимым
 */
Widget::begin([
    "property" => "value",
]);
/*
 * content
 */
Widget::end(); // когда вызывается END, все содержимое, что было между блоками, пишется в переменную $content внутри класса
/*
 * Управление ресурсами
 * Кеширование происходит на уровне глобальных объектов,
 * при кешировании шаблона, сохраняется также информация о подключаемых файлах
 * при выгрузке из кеша, соответствующие файлы все равно подключаются
 */
Template::registerCssFile("path/to/file.css", Position::HEAD|HEADER|FOOTER);
Template::registerCss("css code", Position::HEAD|HEADER|FOOTER);
Template::registerJsFile("path/to/file.js", Position::HEAD|HEADER|FOOTER);
Template::registerJs("js code", Position::HEAD|HEADER|FOOTER);
/*
 * объект шаблона
 */
class Template
{
    /**
     * путь до файла кеша
     */
    public $path;
    /**
     * список подключенных JS ресурсов
     */
    public $assetsJs = [
        "POSITION_HEAD" => [
            "file1",
            "file2",
            "file3",
        ],
        "POSITION_FOOTER" => [
            // ...
        ],
    ];
    /**
     * подключенный JS код
     */
    public $assetsJsCode = [
        "POSITION" => "string code",
    ];
    /**
     * список подключенных CSS ресурсов
     */
    public $assetsCss = [
        "POSITION_HEAD" => [
            "file1",
            "file2",
            "file3",
        ],
        "POSITION_FOOTER" => [
            // ...
        ],
    ];
    /**
     * подключенный JS код
     */
    public $assetsCssCode = [
        "POSITION" => "string code",
    ];
    /**
     * содержимое шаблона (HTML)
     */
    public $output;
    /**
     * исполнение шаблона
     */
    public function execute() {
        if ($this->executeCacheCopy()) {
            return;
        }
        try {
            ob_start();
            $this->includeFile();
            $this->output = ob_get_clean();
        }
        finally {
            ob_end_clean();
        }
    }
    /**
     * проверяет наличие шаблона в кеше
     */
    public function executeCacheCopy() {
        $cacheCopy = $this->getCacheCopy();
        if ($cacheCopy) {
            $props = get_object_vars($cacheCopy);
            foreach ($props as $name => $value) {
                $this->$name = $value;
            }
            return true;
        }
        return false;
    }
    /**
     * подключение файла шаблона
     */
    public function includeFile() {
        include $this->path;
    }
    /**
     * выгружает и возвращает копию шаблона из кеша
     */
    public function getCacheCopy() {
        // code
    }
    /*
     * регистрация файла ресурса
     */
    public function registerCssFile($file, $position) {
        $this->registerFile("assetsCss", $file, $position);
    }
    public function registerJsFile($file, $position) {
        $this->registerFile("assetsJs", $file, $position);
    }
    protected function registerFile($container, $file, $position) {
        $this->$container[$position][] = $file;
    }
    public function registerJsCode($code, $position) {
        $this->assetsJsCode[$position] .= "\n;\n". $code;
    }
    public function registerCssCode($code, $position) {
        $this->assetsCssCode[$position] .= "\n". $code;
    }
}
```
