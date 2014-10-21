<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 21/10/2014
 * Time: 08:25
 */

namespace Libs;

class Collection implements \ArrayAccess, \IteratorAggregate
{
    protected $items;

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param array $items
     */
    public function merge(array $items)
    {
        array_merge($this->items, $items);
    }

    /**
     * @param $key
     * @return $value
     */
    public function get($key)
    {
        return $this->has($key) ? $this->items[$key] : null;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param $key
     */
    public function delete($key)
    {
        if($this->has($key))
        {
            unset($this->items[$key]);
        }
    }



    /**
     * Interface ArrayAccess
     */


    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed|void
     */
    public function offsetGet($offset)
    {
        $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }



    /**
     * Interface IteratorAggregate
     */

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}