<?php

class Asset
{
	public function css($src)
	{
		?>
			<link rel="stylesheet" href="<?= WEBROOT . 'css/' . $src ?>">
		<?php
	}

	public function script($src)
	{
		?>
			<script src="<?= WEBROOT . 'js/' . $src ?>"></script>
		<?php
	}
}
