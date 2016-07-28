<?php

namespace Jugger\Admin\Menu\Traits;

use Jugger\Admin\Menu\MenuItem;

/**
 * Трейт для удобного добавления в список дочерних элементов меню
 */
trait MenuCollection
{
    public function addItem(MenuItem $item) {
        $this->items[] = $item->toArray();
    }
}