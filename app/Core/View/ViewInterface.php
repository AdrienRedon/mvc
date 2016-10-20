<?php 

namespace App\Core\View;

interface ViewInterface
{
  public function setDirectoryPath($directoryPath);
  public function render($path, $vars = array());
}
