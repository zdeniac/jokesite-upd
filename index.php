<?php
try {

	include __DIR__ . '\\classes\\EntryPoint.php';

	$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

	$entryPoint = new EntryPoint($route);
	$entryPoint->run();

}
catch (PDOException $e) {
	
	$title = 'Hiba!';
	$output = 'Adatbázis hiba: ' . $e->getMessage(); ' a ' . $e->getFile() . ' fájl ' . $e->getLine() . '. számú sorában.';

}

include __DIR__ . '/templates/layout.html.php';