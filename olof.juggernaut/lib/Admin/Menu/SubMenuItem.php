<?php

namespace Jugger\Admin\Menu;

/**
 * Description of MenuSubItem
 *
 * @author USER
 */
class SubMenuItem extends MenuItem
{
    /**
     * ID родительского главного меню (MenuMainItem)
     * @var string
     */
    public $parent_menu;
    /**
     * динамическая подгрузка элементов
     * @var boolean
     */
    public $dynamic;
    /**
     * CSS класс крупной иконки
     * @var string
     */
    public $page_icon;
    /**
     * CSS класс иконки
     * @var string
     */
    public $icon;
    /**
     * список адресов, при которых пункт считает активным
     * @var array
     */
    public $more_url;
    /**
     * строковый ID модуля
     * @var string
     */
    public $module_id;
    
    public function addItem(MenuItem $item) {
        parent::addItem($item);
        $this->more_url[] = $item->url;
    }
}