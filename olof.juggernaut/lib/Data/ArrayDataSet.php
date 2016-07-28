<?php

namespace Jugger\Data;

/**
 * набор данных для массива
 *
 * @author Ilya Rupasov <i.rpsv@live.com>
 */
class ArrayDataSet extends DataSet
{
    public function __construct(array $data) {
        parent::__construct($data);
    }
    
    protected function getNext() {
        return array_key_exists($this->indexItem, $this->data)
            ? $this->data[$this->indexItem]
            : false;
    }

    protected function initData() {
        if ($this->sorter) {
            // pass
        }
        if ($this->paginator) {
            // pass
        }
    }

    public function getCount() {
        return count($this->data);
    }
}