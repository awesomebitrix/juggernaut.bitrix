<?php

namespace Jugger\Schema;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OpenGraphBitrix
 *
 * @author Ilya Rupasov <i.rpsv@live.com>
 */
class OpenGraphBitrix extends OpenGraph
{
    public function build() {
        global $APPLICATION;
        $graph = $this->buildGraph();
        foreach ($graph as $name => $value) {
            $APPLICATION->SetPageProperty($name, $value);
        }
    }
    
    public function show() {
        $properties = (new \ReflectionClass($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $prop) {
            $APPLICATION->ShowMeta("og:".$prop);
        }
    }
}