<?php
if (!empty($errors)):
?>
<div class="errors">
	<p>Sikertelen regisztráció!</p>
	<ul>
	<?php foreach ($errors as $error):?>
		<li><?=$error?></li>
	<?php endforeach; ?>
	</ul>
</div>
<?php
endif;
?>
<form action="" method="post">

	<label for="name">Név:</label>
	<input type="text" name="author[name]" id="name" value="<?=$author['name'] ?? ''?>">

	<label for="email">E-mail cím:</label>
	<input type="text" name="author[email]" id="email" value="<?=$author['email'] ?? ''?>">

	<label for="password">Jelszó:</label>
	<input type="password" name="author[password]" id="password">

	<input type="submit" name="submit" value="Regisztráció">

</form>