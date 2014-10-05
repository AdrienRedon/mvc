<?php 

require_once(ROOT.'libs/form.php');

class View
{
	public $content;
	public $layout = 'default';
	public $title = 'MVC';

	public function __construct()
	{
		
	}

	public function render($name, $data = null, $title = null)
	{
		if(isset($title))
		{
			$title_for_layout = $title;
		}
		else
		{
			$title_for_layout = $this->title;
		}

		if(isset($data))
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