<?php

class Form {

	/**
	 * Ouvre un nouveau formulaire
	 * @param  $url    Lien vers l'action du formulaire
	 * @param  $method Méthode du formulaire
	 * @param  $token  Valeur du token
	 * @param  $file   Formulaire pour envoyer des fichiers
	 */
	public function open($url, $method = 'POST', $token = false, $file = false)
	{
		?>
			<form action="<?= WEBROOT . $url ?>" method="<?= $method ?>"<?php if($file) { ?> enctype="multipart/form-data"<?php } ?>>
			<?php if($token) { ?>
				<input type="hidden" name="token" value="<?= $config['token'] ?>">
			<?php } ?>
		<?php
	}

	/**
	 * Ferme le formulaire
	 */
	public function close()
	{
	?>
		</form>
	<?php
	}

	/**
	 * Champ input
	 * @param  $type        Type du champ
	 * @param  $name        Nom du champ
	 * @param  $value       Valeur du champs
	 * @param  $placeholder Valeur du placeholder
	 */
	public function input($type, $name, $value = '', $placeholder = '')
	{
		?>
			<input type="<?= $type ?>"<?php if($name != '') { ?> name="<?= $name ?>"<?php } if($value != '') { ?> value="<?= $value ?>"<?php } if($placeholder != '') { ?> placeholder="<?= $placeholder ?>"<?php } ?>>
		<?php
	}

	/**
	 * Champ textarea
	 * @param $name 	   Nom du champ
	 * @param $value 	   Valeur du champ
	 * @param $placeholder Valeur du placeholder
	 */
	public function textarea($name, $value = '', $placeholder = '')
	{
		?>
			<textarea name="<?= $name ?>"<?php if($placeholder != '') { ?> placeholder="<?= $placeholder ?>" <?php } ?>><?= $value ?></textarea>
		<?php
	}

	/**
	 * Champ input de type text
	 * @param  $name        Nom du champ
	 * @param  $value       Valeur du champs
	 * @param  $placeholder Valeur du placeholder
	 */
	public function text($name, $value = '', $placeholder = '')
	{
		$this->input('text', $name, $value, $placeholder);
	}

	/**
	 * Champ input de type email
	 * @param  $name        Nom du champ
	 * @param  $value       Valeur du champs
	 * @param  $placeholder Valeur du placeholder
	 */
	public function email($name, $value = '', $placeholder = '')
	{
		$this->input('email', $name, $value, $placeholder);
	}

	/**
	 * Champ input de type password
	 * @param  $name        Nom du champ
	 * @param  $value       Valeur du champs
	 * @param  $placeholder Valeur du placeholder
	 */
	public function password($name, $value = '', $placeholder = '')
	{
		$this->input('password', $name, $value, $placeholder);
	}

	/**
	 * Champ input de type number
	 * @param  $name        Nom du champ
	 * @param  $value       Valeur du champs
	 * @param  $placeholder Valeur du placeholder
	 */
	public function number($name, $value = '', $placeholder = '')
	{
		$this->input('number', $name, $value, $placeholder);
	}

	/**
	 * Champ input de type file
	 * @param  $name        Nom du champ
	 * @param  $value       Valeur du champs
	 * @param  $placeholder Valeur du placeholder
	 */
	public function file($name, $value = '', $placeholder = '')
	{
		$this->input('file', $name, $value, $placeholder);
	}

	/**
	 * Champ input de type submit
	 * @param  $name        Nom du champ
	 * @param  $value       Valeur du champs
	 */
	public function submit($value = 'Envoyer')
	{
		$this->input('submit', '', $value);
	}

}