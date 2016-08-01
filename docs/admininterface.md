#Административный интерфейс:

[https://dev.1c-bitrix.ru/api_help/main/general/admin.section/index.php](https://dev.1c-bitrix.ru/api_help/main/general/admin.section/index.php)

Содержание:
1. Структура файлов
2. Добавление страницы
3. Добавление меню
4. Виджеты админки
4.1. Список
4.2. Фильтр
4.3. Форма

## 1. Струкутра файлов

Все административные скрипты располагаются в папке /admin/ директории модуля.
Файл 'menu.php' содержит информацию об административном меню.

## 2. Добавление страницы

## 3. Добавление меню

```php
/* @var $this CAdminMenu */

use Jugger\Ui\Hermitage\Icon;
use Jugger\Admin\Menu\MainMenuItem;
use Jugger\Admin\Menu\SubMenuItem;

/*
 * Создание административного меню (основное)
 */
$menuParent = new SubMenuItem("Управление меню");
$menuParent->icon = Icon::MENU_FORM;
$menuParent->addItem(new SubMenuItem("Список", "/bitrix/admin/my_menu_list.php"));
$menuParent->addItem(new SubMenuItem("Добавить", "/bitrix/admin/my_menu_update.php"));
/*
 * Создание главного меню (боковое)
 */
$mainMenu = new MainMenuItem("Мой раздел");
$mainMenu->sort = 1000;
$mainMenu->menu_id = "global_menu_my_menu";
$mainMenu->items_id = $mainMenu->menu_id;
/*
 * Привязка основного меню в боковому
 */
$mainMenu->addItem($menuParent);
/*
 * Регистрация меню
 */
$mainMenu->register();
```

## 4. Виджеты

- CAdminList
- CAdminSorting
- CAdminResult

