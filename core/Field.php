<?php 

namespace Core;

class Field 
{
    /**
     * Name of the field
     * @var string
     */
    public $name;

    /**
     * Type of the field
     * @var string
     */
    public $type;

    /**
     * Size of the field
     * @var int
     */
    public $size;

    /**
     * If the field is required
     * @var bool
     */
    public $required;

    /**
     * If the field is unsigned
     * @var bool
     */
    public $unsigned;

    /**
     * If the field is auto-incrementable
     * @var bool
     */
    public $auto_increment;

    /**
     * If the field is the primary key
     * @var bool
     */
    public $primary;

    /**
     * Set required attribute to true
     * @return $this
     */
    public function required()
    {
        $this->required = true;
        return $this;
    }

    /**
     * Set auto_increment attribute to true
     * @return $this
     */
    public function auto_increment()
    {
        $this->auto_increment = true;
        return $this;
    }

    /**
     * Set unsigned attribute to true
     * @return $this
     */
    public function unsigned()
    {
        $this->unsigned = true;
        return $this;
    }

    /**
     * Set size attribute
     * @return $this
     */
    public function size($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Set primary attribute to true
     * @return $this
     */
    public function primary()
    {
        $this->primary = true;
        return $this;
    }

    /**
     * Convert a field in string
     * @return string
     */
    public function __toString()
    {
        $string = $this->name . ' ' . $this->type;
        if(isset($this->size))
        {
            $string .= '(' . $this->size . ')';
        }
        if($this->unsigned)
        {
            $string .= ' UNSIGNED';
        }
        if($this->auto_increment)
        {
            $string .= ' AUTO_INCREMENT';
        }
        if($this->primary)
        {
            $string .= ' PRIMARY KEY';
        }
        return $string;
    }
}