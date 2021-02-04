<?php

namespace JokeSite\Controllers;

use \Ninja\DatabaseTable;
use \Ninja\Authentication;


class Joke
{


	private $jokesTable;
	private $authorsTable;
	private $authentication;

	
	public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, Authentication $authentication) {
		
		$this->jokesTable = $jokesTable;
		$this->authorsTable = $authorsTable;
		$this->authentication = $authentication;

	}

	public function list(): array {

    	$jokes = [];

    	foreach ($this->jokesTable->findAll() as $joke) {

    		$author = $this->authorsTable->findById($joke['author_id']);

    		$jokes[] = [
    			'id' => $joke['id'], 
    			'text' => $joke['text'], 
    			'date' => $joke['date'], 
    			'name' => $author['name'],
    			'email' => $author['email'],
    			'author_id' => $author['id']
    		];

    	}

		$countJokes = $this->jokesTable->total();
		$user = $this->authentication->getUser();

		$title = 'Viccek listája';

		return [
			'template' => 'jokes.html.php', 
			'title' => $title, 
			'variables' => [
				'countJokes' => $countJokes,
				'jokes' => $jokes,
				'userId' => $user['id'] ?? null
				]
			];

	}
//ezt lehet, hogy össze lehet vonni a list-tel, ha van get['s'] akkor ajax, am sima lekérés
	public function ajaxSearch(): array {

    	$jokes = [];

    	$column = 'text';
    	$value = $_GET['s'];

    	foreach ($this->jokesTable->search($column, $value) as $joke) {

    		$author = $this->authorsTable->findById($joke['author_id']);

    		$jokes[] = [
    			'id' => $joke['id'], 
    			'text' => $joke['text'], 
    			'date' => $joke['date'], 
    			'name' => $author['name'],
    			'email' => $author['email'],
    			'author_id' => $author['id']
    		];

    	}

		return [
			'template' => 'jokesearch.html.php', 
			'variables' => [
				'jokes' => $jokes ?? null,
				'userId' => $user['id'] ?? null
				]
			];
	}
	
	public function home(): array {

		$title = 'Viccoldal';

		return ['template' => 'home.html.php', 'title' => $title];
	}

	public function delete() {

		$author = $this->authentication->getUser();
		$joke = $this->jokesTable->findById($_POST['id']);

		if ($author['id'] != $joke['author_id']) {
			return;
		}

		$this->jokesTable->delete($_POST['id']);
		
		header('Location: /novice_to_ninja/joke/list');
	}

//szerkesztés nézet
	public function edit(): array {

		$user = $this->authentication->getUser();

		if (isset($_GET['id'])) {
			$joke = $this->jokesTable->findById($_GET['id']);
		}

		$title = 'Vicc szerkesztése';

		return [
			'template' => 'editjoke.html.php',
			'title' => $title, 
			'variables' => [
				'joke' => $joke ?? null,
				'userId' => $user['id'] ?? null
			]
		];

	}

	public function saveEdit() {

		$author = $this->authentication->getUser();

		if ($_GET['id']) {
			
			$joke = $this->jokesTable->findById($_GET['id']);

			if ($joke['author_id'] != $author['id']) {
				return;
			}

		}

		$joke = $_POST['joke'];

		$joke['author_id'] = $author['id'];
		$joke['date'] = new \DateTime();

		$this->jokesTable->save($joke, $joke['id']);
		header('Location: /novice_to_ninja/joke/list');

	}


}