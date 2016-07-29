<?php

namespace Jugger\Schema;

/**
 * Description of OpenGraph
 *
 * @author Ilya Rupasov <i.rpsv@live.com>
 */
abstract class OpenGraph
{
    const TYPE_ARTICLE = 'article';
    const TYPE_BOOK = 'book';
    const TYPE_PROFILE = 'profile';
    const TYPE_WEBSITE = 'website';
    
    public $title;
    public $type;
    public $image;
    public $url;
    public $description;
    
    public function buildGraph() {
        $graph = [];
        $class = new \ReflectionClass($this);
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $value = $property->getValue($this);
            if (empty($value)) {
                continue;
            }
            if (!is_array($value)) {
                $value = [$value];
            }
            foreach ($value as $item) {
                $graph['og:'.$property->getName()] = $item;
            }
        }
        return $graph;
    }
    
    public abstract function build();
}