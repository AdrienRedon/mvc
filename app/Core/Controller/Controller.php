<?php 
namespace App\Core\Controller;
use App\Core\DependencyInjection\ContainerAware;
use App\Core\DependencyInjection\ContainerInterface;
use App\Libs\Redirection;
use App\Libs\Flash;
class Controller extends ContainerAware
{
    protected $view;
    protected $redirect;
    /**
     * In order to resolve Model
     * @var ModelResolver
     */
    protected $model;
    protected $flash;
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->view = $this->container->resolve('View');
        $this->redirect = $this->container->resolve('Redirection');
        $this->view->setDirectoryPath('app/View/');
        $this->model = $this->container->resolve('ModelResolver');
        $this->flash = $this->container->resolve('Flash');
    }
    /**
     * Check if the request is an AJAX request
     * @return boolean [description]
     */
    public function isAjax()
    {
        return strtolower(filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest';
    }
}
