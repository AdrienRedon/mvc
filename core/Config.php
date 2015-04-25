<?php 

namespace Core;

class Config
{

    private $settings = array();

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
