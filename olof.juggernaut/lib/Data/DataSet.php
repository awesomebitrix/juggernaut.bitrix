<?php

namespace Jugger\Data;

abstract class DataSet
{
    /**
     * инициализированны ли данные согласно сортеру и пагинатору
     * @var boolean
     */
    protected $isInit = false;
    /**
     * идекс текущего элемента
     * @var integer
     */
    protected $indexItem = -1;
    /**
     * данные
     * @var mixed
     */
    protected $data;
    /**
     * сортировщик
     * хранит в себе информацию о сортируемых столбцах и способах их сортировки
     * @var Sorter
     */
    public $sorter;
    /**
     * пагинатор
     * хранит в себе информацию о разбивке данных на страницы
     * @var Paginator 
     */
    public $paginator;
    /**
     * конструктор
     * @param mixed $data
     */
    public function __construct($data) {
        $this->data = $data;
    }
    /**
     * считывает очередную запись со страницы
     */
    public function fetch() {
        if (!$this->isInit) {
            $this->init();
        }
        $this->indexItem++;
        return $this->getNext();
    }
    /**
     * инициализация
     * инициализируются сортировщик, пагинатор и данные
     */
    protected function init() {
        if ($this->sorter) {
            $this->sorter->init();
        }
        if ($this->paginator) {
            $this->paginator->init();
        }
        $this->initData();
    }
    /**
     * возвращает следующий элемент страницы
     */
    protected abstract function getNext();
    /**
     * инициализация данных
     * после инициализации пагинатора и сортировщика
     */
    protected abstract function initData();
    /**
     * количество элементов на текущей странице
     */
    public abstract function getCount();
}