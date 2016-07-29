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
    public static $instance;

    public function build() {
        global $APPLICATION;
        $graph = $this->buildGraph();
        foreach ($graph as $name => $value) {
            $APPLICATION->SetPageProperty($name, $value);
        }
        self::$instance = $this;
    }
    
    public static function show() {
        global $APPLICATION;
        $properties = (new \ReflectionClass(get_called_class()))->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $prop) {
            if ($prop->isStatic()) {
                continue;
            }
            $APPLICATION->ShowMeta("og:".$prop->getName());
        }
    }
}