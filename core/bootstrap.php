<?php 

namespace Core;

class Bootstrap
{
	protected $controller = DEFAULT_CONTROLLER;
	protected $method     = DEFAULT_METHOD;
	protected $params     = DEFAULT_ARGS;

	public function __construct()
	{
		$url = $this->parseUrl();

        $filename = ROOT . 'controllers/' . $url[0] . '_controller.php';

		if(file_exists($filename))
		{
			$this->controller = $url[0] . 'Controller';
		}
		else
		{
			$this->errors();
		}

		require_once($filename);

		$this->controller = new $this->controller;

        unset($url[0]);

		if(isset($url[1]))
		{
			if(method_exists($this->controller, $url[1]))
			{
				$this->method = $url[1];
				unset($url[1]);
			}
			else
			{
				$this->errors();
			}
		}

		$this->params = $url ? array_values($url) : [];

		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	/**
	 * Sépare le controller, la méthode et les arguments de l'url
	 * @return $url Tableau contenant le controller, la méthode et les arguments
	 */
	private function parseUrl()
	{
		if(isset($_GET['url']))
		{
			return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
		else 
		{
			return $url = [
				$this->controller,
				$this->method,
				$this->params
			];
		}
	}

	/**
	 * Appelle la méthode affichant une erreur 404
	 */
	private function errors()
	{
		require_once(ROOT . 'controllers/error_controller.php');
		$this->controller = new \ErrorController;
		$this->controller->_404();
		exit;
	}
}