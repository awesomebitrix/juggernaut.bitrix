<?php

namespace Jugger\Data;

use Jugger\Exception\SorterException;

/**
 * сортировщик
 * хранит в себе информацию о сортируемых столбцах и способах их сортировки
 *
 * @author Ilya Rupasov <i.rpsv@live.com>
 */
class Sorter
{
    /**
     * обчная сортировка
     */
    const TYPE_GENERAL = 1;
    /**
     * сортировка по пользовательской функции
     */
    const TYPE_USER = 2;
    /**
     * натуральная сортировка
     */
    const TYPE_NATURAL = 3;
    
    /**
     * столбцы, по которым происходит сортировка
     * @var array
     */
    protected $columns = [];
    
    public function __construct(array $columns = []) {
        foreach ($columns as $key => $value) {
            if (is_array($value)) {
                $sortInfo = $value;
            }
            else {
                $sortInfo = [
                    "sort" => self::TYPE_NATURAL,
                ];
            }
            $this->columns[$key] = $sortInfo;
        }
    }
    /**
     * назначение сортировки для столбца
     * @param mixed $column название столбца
     * @param integer $sort тип сортировки
     * @param \Closure $callback функция для пользовательской сортировки
     */
    protected function set($column, $sort, \Closure $callback = null) {
        $this->columns[$column] = compact("sort", "callback");
    }
    /**
     * назначение обычной сортировки для столбца
     * @param mixed $column название столбца
     */
    public function setGeneral($column) {
        $this->set($column, self::TYPE_GENERAL);
    }
    /**
     * назначение натуральной сортировки для столбца
     * @param mixed $column название столбца
     */
    public function setNatural($column) {
        $this->set($column, self::TYPE_NATURAL);
    }
    /**
     * назначение пользовательской сортировки для столбца
     * @param mixed $column название столбца
     * @param \Closure $callback функция сортировки
     */
    public function setUser($column, \Closure $callback) {
        $this->set($column, self::TYPE_USER, $callback);
    }
    /**
     * сравнение элементов по указанному столбцу
     * @param mixed $a
     * @param mixed $b
     * @param string $column название столбца
     */
    public function compare($a, $b, $column) {
        $sortInfo = $this->columns[$column];
        $sort = $sortInfo['sort'];
        if ($sort == self::TYPE_USER) {
            return $sortInfo($a, $b, $column);
        }
        //
        $a = $a[$column];
        $b = $b[$column];
        if ($sort == self::TYPE_GENERAL) {
            return strnatcmp($a, $b);
        }
        else if ($sort == self::TYPE_NATURAL) {
            return strcmp($a, $b);
        }
        else {
            ob_start();
            var_dump($sort);
            throw new SorterException("Указан неизвестный тип сортировки: ".ob_end_clean());
        }
    }
}