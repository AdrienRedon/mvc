<?php
namespace App\Libs;
use App\Core\Config;
use App\Libs\SessionInterface;
class Redirection
{
    protected $session;
    
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    
    public function back()
    {
        if(array_key_exists('HTTP_REFERER', $_SERVER))
        {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else
        {
            $this->home();
        }
    }
    
    public function backWithInput($input)
    {
        $this->session->set('input', $input);
        $this->back();
    }
    public function to($url)
    {
        $url = trim($url, '/');
        header('Location: ' . WEBROOT. $url);
    }
    public function home()
    {
        $config = new Config();
        $this->to($config->get('home_route'));
    }
}
