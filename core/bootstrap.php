<?php 

class Bootstrap
{
	protected $controller = DEFAULT_CONTROLLER;
	protected $method     = DEFAULT_METHOD;
	protected $params     = DEFAULT_ARGS;

	public function __construct()
	{
		$url = $this->parseUrl();

		if(file_exists(ROOT . 'controllers/' . $url[0] . '.php'))
		{
			$this->controller = $url[0];
			unset($url[0]);
		}
		else
		{
			$this->errors();
		}

		require_once(ROOT . 'controllers/' . $this->controller . '.php');

		$this->controller = new $this->controller;

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
		require_once(ROOT . 'controllers/errors.php');
		$this->controller = new Errors;
		$this->controller->_404();
		exit;
	}
}