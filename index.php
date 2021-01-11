<?php
try {

	include __DIR__ . '/includes/autoload.php';

	$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

	$entryPoint = new \Ninja\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \JokeSite\Routes());
	$entryPoint->run();

}
catch (PDOException $e) {
	
	$title = 'Hiba!';
	$output = 'Adatbázis hiba: ' . $e->getMessage(); ' a ' . $e->getFile() . ' fájl ' . $e->getLine() . '. számú sorában.';

}

//előfordulhat olyan eset, hogy kétszer van behívva a layout view
include_once __DIR__ . '/templates/layout.html.php';