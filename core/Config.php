<?php 

namespace Core;

class Config
{
    /**
     * Settings in the config files
     * @var array
     */
    private $settings = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->settings = require (ROOT . '/config/config.php');
    }

    /**
     * Get value from the config
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function get($key)
    {
        if(!isset($this->settings[$key]))
        {
            return null;
        }
        return $this->settings[$key];
    }

}
