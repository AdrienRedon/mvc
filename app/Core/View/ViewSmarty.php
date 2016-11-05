<?php 

namespace App\Core\View;

use \Smarty;
use App\Core\DependencyInjection\ContainerAware;
use App\Core\DependencyInjection\ContainerInterface;

class ViewSmarty extends ContainerAware implements ViewInterface
{
    protected $smarty;
    protected $directoryPath;
    protected $defaultView;
    protected $auth;
    protected $asset;

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->smarty = new Smarty();
        $this->auth = $this->container->resolve('Auth');
        $this->asset = $this->container->resolve('Asset');
        $this->smarty->debugging = false;
        $this->smarty->caching = false;
        $this->smarty->cache_lifetime = 120;
    }

    public function setDirectoryPath($directoryPath)
    {
        $this->directoryPath = $directoryPath;
        $this->smarty->setTemplateDir(ROOT . $this->directoryPath);
        $this->smarty->setCompileDir(ROOT . $this->directoryPath . '/templates_c');
        $this->smarty->setCacheDir(ROOT . $this->directoryPath . '/cache');
        $this->smarty->setConfigDir(ROOT . $this->directoryPath . '/configs');
    }

    public function render($path, $vars = array())
    {
        foreach($vars as $key => $value) {
            if (is_object($value)) {
                $this->smarty->registerObject($key, $value);
            } else {
                $this->smarty->assign($key, $value);
            }
        }
        $this->smarty->assign('logged', $this->auth->check());
        $this->smarty->assign('asset', $this->asset);
        $this->smarty->display(ROOT . $this->directoryPath . $path . '.tpl');
    }
}
