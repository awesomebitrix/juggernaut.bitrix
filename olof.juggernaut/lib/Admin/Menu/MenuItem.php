<?php

namespace Jugger\Admin\Menu;

abstract class MenuItem
{
    /**
     * Трейт для удобного добавления элементов
     */
    use Traits\MenuCollection;
    use \Jugger\Base\Traits\GetSetProperty;
    /**
     * надпись
     * @var string
     */
    public $text;
    /**
     * ссылка
     * @var string
     */
    public $url;
    /**
     * приоритет (от меньшего к большему)
     * @var integer
     */
    public $sort;
    /**
     * подсказка
     * @var string
     */
    public $title;
    /**
     * скрывать ли в цепочке навигации (true - скрыть из цепочки навигации)
     * @var boolean
     */
    public $skip_chain;
    /**
     * HTML идентификатор дочерних элементов
     * нужно указывать, чтобы при активности дочерних элементов,
     * родительский был развернут
     * @var string
     */
    public $items_id;
    /**
     * дочерние элементы меню (подменю)
     * @var array
     */
    public $items;
    /**
     * конструктор
     * @param string $text  надпись
     * @param string $url   ссылка
     * @param string $icon  иконка
     * @param array $other остальные параметры
     */
    public function __construct($text, $url = null, array $other = []) {
        $this->text = $text;
        $this->url  = $url;
        foreach ($other as $property => $value) {
            $this->$property = $value;
        }
    }
    /**
     * преобразование данных в массив
     * все поля, строго равные null не будут включены в результирующий массив
     * @return array
     */
    public function toArray() {
        $ret = get_object_vars($this);
        $ret = array_filter($ret, function($value) {
            return ! empty($value);
        });
        return $ret;
    }
}