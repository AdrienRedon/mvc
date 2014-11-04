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
     * Create a new collection of items
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Convert the collection in array
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * Add the items to the collection
     * @param array $items
     */
    public function add(array $items)
    {
        array_merge($this->items, $items);
    }

    /**
     * Get a value by its key
     * @param $key
     * @return $value
     */
    public function get($key)
    {
        return $this->has($key) ? $this->items[$key] : null;
    }

    /**
     * Set a value at a given key
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Check if the collection has the key
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Delete an item by its key
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

    /**
     * Return the max item of the collection
     * @param $key
     * @return mixed
     */
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

    /**
     * Return the min item of the collection
     * @param $key
     * @return mixed
     */
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

    /**
     * Return the first item of the collection
     * @param $key
     * @return mixed
     */
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

    /**
     * Return the last item of the collection
     * @param $key
     * @return mixed
     */
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

    /**
     * Add a limit to the collection
     * @param $length
     * @param int $start
     * @return Collection
     */
    public function limit($length, $start = 0)
    {
        $results = $this->items;
        return new Collection(array_slice($results, $start, $length));
    }

    /**
     * Add an offset to the collection
     * @param $length
     * @return Collection
     */
    public function offset($length)
    {
        $results = $this->items;
        return new Collection(array_slice($results, $length));
    }

    /**
     * Paginate the collection
     * @param $page
     * @param $elements
     * @return Collection
     */
    public function paginate($page, $elements)
    {
        return $this->limit($elements, ($page - 1) * $elements);
    }

    /**
     * Order the collection by a specific key given
     * @param $key
     * @param string $direction
     * @return Collection
     */
    public function orderBy($key, $direction = 'ASC')
    {

        $arrayKey = $this->extract($key)->toArray();
        strtoupper($direction) == 'ASC' ? asort($arrayKey) : arsort($arrayKey);
        $array = $this->items;
        $results = [];
        foreach ($arrayKey as $name => $value) 
        {
            foreach ($array as $k => $v) 
            {
                if($k == $name)
                {
                    $results[$k] = $v;
                    unset($array[$k]);
                }
            }
        }
        return new Collection($results);
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