<h1>Page d'accueil</h1>

<?= $content ?>

<div class="text-logged">
	<?php if (isset($user)) { ?>
		<br>
		Bienvenue <?= $user->login ?> <br>
		Voulez-vous vous déconnecter ?
		<?= $this->html->link('sessions/logout', 'Se déconnecter') ?>
	<?php } else { ?>
		<br>
		Vous n'êtes pas connecté !
	<?php } ?>
</div>

<?php 
	$form = new Form();
	$form->open('sessions/login');
	$form->text('login');
	$form->password('password');
	$form->submit('Se connecter');
	$form->close();
?>


<code>

$.post('sessions/login', {'login' : 'admin', 'password' : 'admin'}).done(function(data, text, jqxhr) { 
	response = JSON.parse(jqxhr.responseText); 
	if(response.logged == true) { 
		$('.text-logged').text('Bienvenue ' + response.user.login); 
	} 
});

</code>
