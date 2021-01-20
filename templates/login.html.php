<?php
if (isset($error)):
	echo '<div class="error">' . $error . '</div>';
endif;
?>
<form method="post" action="">

	<label for="email">E-mail cím:</label>
	<input type="text" name="email" id="email">

	<label for="password">Jelszó:</label>
	<input type="password" name="password" id="password">

	<input type="submit" name="submit" value="Bejelentkezés">
	
</form>
<h3>Még nem rendelkezik profillal?</h3>
<p><a href="/novice_to_ninja/author/register">Regisztráljon!</a></p>