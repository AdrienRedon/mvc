<?php 

namespace Core;

class View
{
	protected $content;
	protected $layout;
	protected $title;

	protected $session;
	protected $flash;
	protected $html;
	protected $asset;
	protected $form;

	public function __construct()
	{
		$this->layout = Config::getInstance()->get('default_layout');
		$this->title  = Config::getInstance()->get('default_title');

		$this->session = new \Libs\Session;
		$this->flash = new \Libs\Flash($this->session);
		$this->html = new \Libs\Html;
		$this->asset = new \Libs\Asset;
		$this->form = new \Libs\Form($this->session);
	}

	/**
	 * Render the view
	 * @param $name
	 * @param $data
	 * @param $title
	 */
	public function render($name, $data = [], $title = null)
	{
		if(isset($title))
		{
			$title_for_layout = $title;
		}
		else
		{
			$title_for_layout = $this->title;
		}

		if(!empty($data))
		{
			extract($data);
		}

		ob_start();
		require_once(ROOT . "views/$name.php");
		$content_for_layout = ob_get_clean();

		if($this->layout == false)
		{
			echo $content_for_layout;
		}
		else
		{
			require_once(ROOT . "views/layouts/$this->layout.php");
		}
	}

	/**
	 * Return JSON encoded data
	 * @param $data
	 * @param $header
	 */
	public function json($data, $header = 200)
	{
		if($header == 500)
		{
			header('500 Internal Server Error', true, 500);
		}
		elseif ($header == 404) 
		{
			header('404 Not Found', true, 404);
		}
		else
		{
			header('200 OK', true, 200);
		}

		die(json_encode($data));
	}
}