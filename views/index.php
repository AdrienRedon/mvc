<h1>Page d'accueil</h1>

<?= $content ?>

<div class="text-logged">
	<?php if (isset($user)) { ?>
		<br>
		Bienvenue <?= $user->login ?> <br>
		Voulez-vous vous déconnecter ?
		<?= $this->html->link('sessions/logout', 'Se déconnecter') ?> <br>
	<?php } else { ?>
		<br>
		Vous n'êtes pas connecté !
		<?php 
			$this->form->open('sessions/login');
			$this->form->text('login');
			$this->form->password('password');
			$this->form->submit('Se connecter');
			$this->form->close();
		?>
	<?php } ?>
</div>

<br>

<code>

$.post('sessions/login', {'login' : 'admin', 'password' : 'admin'}).done(function(data, text, jqxhr) { 
	response = JSON.parse(jqxhr.responseText); 
	if(response.logged == true) { 
		$('.text-logged').text('Bienvenue ' + response.user.login); 
	} 
});

</code>
