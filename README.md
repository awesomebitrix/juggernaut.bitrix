# Juggernaut

site: [https://irpsv.github.io/juggernaut.bitrix/](https://irpsv.github.io/juggernaut.bitrix/)

**Juggernaut** - это библиотека (с претензией на фреймворк), которая расширяет возможности BitrixFramework, а также облегчает жизнь разработчику.

Основная задача данного проекта: сделать приятной, удобной и простой разработку под Bitrix.

Если Вы не нашли ответ на свой вопрос или у Вас есть предложения/пожелания, можете изложить их [здесь](https://github.com/irpsv/juggernaut.bitrix/issues).

Ну а если Ваш интузиазм зашкаливает и Вы готовы напись/править пару строк кода, то уверен Вы знаете что делать ;-)

## Установка

На данный момент, установить модуль можно только используя **Composer**, командой:

```
composer require irpsv/juggernaut.bitrix
```

Затем вы можете скопировать папку `olof.juggernaut` и поместить ее к модулям системы, либо в файле `php_interface/init.php` подключить автозагрузчик Composer'а, а затем подключить модуль штатными средствами Битрик. Например:

```php
include $_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php';

\Bitrix\Main\Loader::includeModule('olof.juggernaut');
```
