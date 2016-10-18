<?php
namespace App\Core;
class Config
{
    /**
     * Settings in the config files
     * @var array
     */
    private $settings = array();
    /**
     * Constructor
     * @param string $path Path to the config file
     */
    public function __construct($path = null)
    {
        if ( ! isset($path)) {
            $path = DIRECTORY_SEPARATOR . 'app';
        }
        $this->settings = require (ROOT . $path . DIRECTORY_SEPARATOR . 'config.php');
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
