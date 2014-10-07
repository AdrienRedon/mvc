<?php

class Asset
{
	public function css($src)
	{
		?>
			<link rel="stylesheet" href="<?= WEBROOT . 'public/css/' . $src ?>">
		<?php
	}

	public function script($src)
	{
		?>
			<script src="<?= WEBROOT . 'public/js/' . $src ?>"></script>
		<?php
	}
}
