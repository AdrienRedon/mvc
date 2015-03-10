<h1>Page d'accueil</h1>

<?= $content ?>

<div class="text-logged">

	<?php if(isset($user)) { ?>

		<p>
			Bienvenue <?= $user->login ?>.
			Voulez-vous vous déconnecter ?
			<?= $this->html->link('logout', 'Se déconnecter') ?>
		</p>

	<?php } else { ?>

		<p>Vous n'êtes pas connecté !</p>

		<?= $this->form->open('login') ?>

			<div>
				<?= $this->form->text('login', '', 'Login') ?>
			</div>

			<div>
				<?= $this->form->password('password', '', 'Password') ?>
			</div>

			<div>
				<?= $this->form->password('password_confirm', '', 'Confirm password') ?>
			</div>

			<div>
				<?= $this->form->submit('Se connecter') ?>
			</div>

		<?= $this->form->close() ?>

	<?php } ?>

</div>

<br>

<code>

$.post('<?= WEBROOT ?>session/login', {'login' : 'admin', 'password' : 'admin', 'password_confirm' : 'admin'}).done(function(data, text, jqxhr) {
	response = JSON.parse(jqxhr.responseText); 
	if(response.logged == true) { 
		$('.text-logged').text('Bienvenue ' + response.user.login);
	} 
});

</code>
