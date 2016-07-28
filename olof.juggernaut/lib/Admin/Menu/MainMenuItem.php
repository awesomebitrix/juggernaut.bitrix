<?php

namespace Jugger\Admin\Menu;

class MainMenuItem extends MenuItem
{
    const GLOBAL_MENU_CONTENT = "global_menu_content";
    const GLOBAL_MENU_MARKETING = "global_menu_marketing";
    const GLOBAL_MENU_STORE = "global_menu_store";
    const GLOBAL_MENU_SERVICES = "global_menu_services";
    const GLOBAL_MENU_STATISTICS = "global_menu_statistics";
    const GLOBAL_MENU_MARKETPLACE = "global_menu_marketplace";
    const GLOBAL_MENU_SETTINGS = "global_menu_settings";
    
    /**
     * Идентификатор меню
     * @var string
     */
    public $menu_id;
    /**
     * раздел помощи?
     * @var string
     */
    public $help_section;
    /**
     * Регистрация пункта меню
     */
    public function register() {
        foreach ($this->items as & $item) {
            $this->setChildrenItemsId($item);
        }
        AddEventHandler("main", "OnBuildGlobalMenu", function(){
            return [
                $this->menu_id => $this->toArray()
            ];
        });
    }
    
    protected function setChildrenItemsId(array & $item) {
        $item['items_id'] = $this->items_id;
        foreach ($item['items'] as & $child) {
            $this->setChildrenItemsId($child);
        }
    }
}