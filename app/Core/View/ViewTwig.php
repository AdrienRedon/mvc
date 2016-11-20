<?php 

namespace App\Core\View;

use \Twig_Loader_Filesystem;
use \Twig_Environment;
use App\Core\DependencyInjection\ContainerAware;
use App\Core\DependencyInjection\ContainerInterface;

class ViewTwig extends ContainerAware implements ViewInterface
{
    protected $loader;
    protected $twig;
    protected $directoryPath;
    protected $defaultView;
    protected $auth;
    protected $asset;

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->auth = $this->container->resolve('Auth');
        $this->asset = $this->container->resolve('Asset');
        $this->config = $this->container->resolve('Config');
    }

    public function setDirectoryPath($directoryPath)
    {
        $this->directoryPath = $directoryPath;
        $this->loader = new Twig_Loader_Filesystem(ROOT . $directoryPath);
        $this->twig = new Twig_Environment($this->loader, [
            'debug' => $this->config->get('debug'),
            'cache' => ROOT. $directoryPath . 'cache'
        ]);
    }

    public function render($path, $vars = array())
    {
        $vars = array_merge($vars, [
            'asset' => $this->asset, 
            'logged' => $this->auth->check()
        ]);
        echo $this->twig->render($path . '.twig', $vars);
    }
}