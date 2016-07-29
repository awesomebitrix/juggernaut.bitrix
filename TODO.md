1. JSON-LD
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

Провайдер данных:

```php
$data = new ResultProvider(
	Result $result,
	Sorter $sorter,
	Paginator $paginator
);
// обращение к элементам
$data->sorter;
$data->paginator;


/*
 * список элементов инфоблока (массив)
 * с сортировкой по названию, цене, и популярности (свойства)
 * с пагиначией по 50 элементов на странице
 */
$elementList = IblockElement::getList()->fetchAll();

$data = new ArrayProvider($elementList);

$data->sorter = new Sorter(["name","price","popular"]);
$data->sorter->setSortTypes("name", [
	Sorter::ASC_NATURAL,
	Sorter::DESC_NATURAL,
]);

$data->paginator = new Paginator(50, count($elementList));
$data->paginator->nowPage = 3;

foreach ($data->getModels() as $model) {
	// ...
}

// первый элемент (с учетом сортировки и пагинации)
$data->get(0) = "...";
// true, т.к. на странице максимум 50 записей, следовательно индексы 0-49
$data->get(50) === null;
// найти первый элемент на текущей странице (3 параметр: true) который удовлетворяет условию: $row['name'] === 'искомое имя'
$data->find("name", "искомое имя", true);
```

ActiveRecord и ServiceLayer:

```php
/*
 * AR: простой доступ к таблице, без логики, без первичных ключей
 * данный класс, знает только о своей таблице
 * как будто он один в этом мире :-)
 * доступ к полям записи как к свойствам
 */
$model = new IblockElemenetMeta();
$model->field = '123';
$model->save();
$model->delete();

/*
 * поиск по условию WHERE (без всяких сортировок и др.)
 * все условия строятся с помощью класса Query
 */
$model = ActiveRecord::getRow($whereCondition);
$model = ActiveRecord::getRowByPrimary($primary);
$model = ActiveRecord::getRowByField($field, $value);

$model = ActiveRecord::getList($whereCondition);
$model = ActiveRecord::getListByField($whereCondition);

/*
 * SL: содержит логику и связь с другими таблицами
 * наследуется от AR и содержит все ее методы и свойства
 */
$model = new IblockElement();
$model->getSectionList(); // список разделов элемента
$model->getIblock();   // инфоблок
$model->getSection();  // секция указанная непосредственно в атрибуте

$model->addSection($section);

$model->save(); // сохраняет не только инфоблок, но и также каскадно сохраняет разделы
```
