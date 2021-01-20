<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/novice_to_ninja/css/layout.css">
	<title><?=$title?></title>
</head>
<body>
	<nav>
		<ul>
			<li><a href="/novice_to_ninja/joke/home">Kezdőlap</a></li>
			<li><a href="/novice_to_ninja/joke/list">Viccek</a></li>
			<li><a href="/novice_to_ninja/joke/edit">Vicc feltöltése</a></li>
			<li>
				<a href="/novice_to_ninja/author/register">Regisztráció</a> / 
			<?php if($loggedIn):?>
				<a href="/novice_to_ninja/logout">Kijelentkezés</a>
			<?php else: ?>
				<a href="/novice_to_ninja/login">Bejelentkezés</a>
			<?php endif;?>
			</li>
		</ul>
	</nav>
	<main>
		<?=$output?>
	</main>
	<footer>
		
	</footer>
</body>
</html>