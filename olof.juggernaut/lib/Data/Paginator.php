<?php

namespace Jugger\Data;

/**
 * пагинатор
 * хранит в себе информацию о разбивке данных на страницы
 *
 * @author Ilya Rupasov <i.rpsv@live.com>
 */
class Paginator
{
    /**
     * текущая страница
     * @var integer
     */
    public $pageNow;
    /**
     * общее число страниц
     * @var integer
     */
    public $pageCount;
    /**
     * количество элементов на странице
     * @var integer
     */
    public $pageItemCount;
    /**
     * общее количество элементов
     * @var integer
     */
    public $totalItemCount;
}