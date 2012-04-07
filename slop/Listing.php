<?php

/**
 * Listing
 *
 * Array like object.  Unlike standard PHP arrays, the Listing object
 * can only have numeric indices, ranging from 0 to (n-1).  This does
 * in fact make a Listing less powerful in many ways than PHP's native
 * Array class, but gives it a more rigid and controlled definition -
 * similar to Python's List or JavaScript's Array object.
 *
 * @uses ArrayAccess
 * @uses Countable
 * @uses Iterator
 * @package 
 * @version $id$
 */
class Listing implements ArrayAccess, Countable, Iterator {

    private $data = array();
    private $counter = 0;

    private static $aliases = array(
            'append' => 'push',
            'extend' => 'concat',
        );

    public static function fromArray($array) {
        if (!is_array($array)) {
            throw new InvalidArgumentException('Array');
        }
        $list = new Listing();
        $list->data = $array;
        return $list;
    }

    public function __construct($data = array()) {
        $this->data = func_get_args();
    }

    public function current() {
        return $this->offsetGet($this->counter);
    }

    public function rewind() {
        $this->counter = 0;
    }

    public function key() {
        return $this->counter;
    }

    public function next() {
        return ++$this->counter;
    }

    public function valid() {
        $count = $this->count();
        return ($count > 0 && $this->counter < $count);
    }

    public function count() {
        return count($this->data);
    }

    public function offsetExists($offset) {

    }

    public function offsetGet($offset) {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value) {
        if ($offset === null) {
            $offset = $this->count();
        }
        if (!is_int($offset)) {
            throw new OutOfRangeException($offset);
        }
        if ($offset > $this->count() || $offset < 0)  {
            throw new OutOfBoundsException($offset);
        }
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset) {
        unset($this->data[$offset]);
        $this->data = array_values($this->data);
    }

    public function toArray() {
        return $this->data;
    }

    public function pop() {
        return array_pop($this->data);
    }

    public function push($item) {
        return array_push($this->data, $item);
    }

    public function __call($method, $args) {
        if (!empty(self::$aliases[$method])) {
            return call_user_func_array(array($this, self::$aliases[$method]), $args);
        }
        array_unshift($args, $this->data);
        if (is_callable("array_".$method)) {
            $return_val = call_user_func_array("array_".$method, $args);
            if (is_array($return_val)) {
                $return_val = Listing::fromArray($return_val);
            }
            return $return_val;
        }
        throw new BadMethodCallException($method);
    }

    public function concat($list) {
        if (!is_array($list)) {
            if (is_object($list) && get_class($list) == 'Listing') {
                $list = $list->toArray();
            } else {
                throw new InvalidArgumentException($list);
            }
        }
        $this->data = array_merge($this->data, array_values($list)); 
    }

    public function contains($value) {
        return in_array($value, $this->data);
    }


}
