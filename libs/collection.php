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
        if ($this->has($key))
        {
            unset($this->items[$key]);
        }
    }

    /**
     * @param $key
     * @param $value
     * @return array
     */
    public function lists($key, $value)
    {
        $results = [];

        foreach ($this->items as $item)
        {
            $results[$item[$key]] = $item[$value];
        }

        return new Collection($results);
    }

    /**
     * @param $key
     * @return array
     */
    public function extract($key)
    {
        $results = [];

        foreach ($this->items as $item)
        {
            if(isset($item->$key))
            {
                $results[] = $item->$key;
            }
        }

        return new Collection($results);
    }

    public function join($glue)
    {
        return implode($glue, $this->items);
    }

    public function max($key = false)
    {
        if (!$key)
        {
            return max($this->items);
        } else
        {
            return $this->extract($key)->max();
        }
    }

    public function min($key = false)
    {
        if (!$key)
        {
            return min($this->items);
        } else
        {
            return $this->extract($key)->min();
        }
    }

    public function first($key = false)
    {
        if (!$key)
        {
            $array = $this->items;
            return array_shift($array);
        } else
        {
            return $this->extract($key)->first();
        }
    }

    public function last($key = false)
    {
        if (!$key)
        {
            $array = $this->items;
            return array_pop($array);
        } else
        {
            return $this->extract($key)->last();
        }
    }

    public function limit($length, $start = 0)
    {
        $results = $this->items;
        return new Collection(array_slice($results, $start, $length));
    }

    public function offset($length)
    {
        $results = $this->items;
        return new Collection(array_slice($results, $length));
    }

    public function order($keys, $direction = 'ASC')
    {
        $array = array($this->items);
        uasort($array, [$this, strtoupper($direction) == 'ASC' ? 'asc' : 'desc']);
        return new Collection($array);
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

    /**
     * Private function
     */

    private function asc($a, $b)
    {
        return $a < $b;
    }

    private function desc($a, $b)
    {
        return $a > $b;
    }
}