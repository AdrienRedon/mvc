<?php

class Asset
{
	public function css($src)
	{
		?>
			<link rel="stylesheet" href="<?= WEBROOT . $src ?>">
		<?php
	}

	public function script($src)
	{
		?>
			<script src="<?= WEBROOT . $src ?>"></script>
		<?php
	}
}