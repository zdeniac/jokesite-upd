<?php

	namespace JokeSite\Controllers;
	use \Ninja\DatabaseTable;

	class Joke
	{


		public $jokesTable;
		public $authorsTable;

		
		public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable) {
			
			$this->jokesTable = $jokesTable;
			$this->authorsTable = $authorsTable;

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
	    			'email' => $author['email']
	    		];

	    	}

			$countJokes = $this->jokesTable->total();

			$title = 'Viccek listája';

			return ['template' => 'jokes.html.php', 
					'title' => $title, 
					'variables' => ['countJokes' => $countJokes, 'jokes' => $jokes]
				];

		}
		
		public function home(): array {

			$title = 'Viccoldal';

			return ['template' => 'home.html.php', 'title' => $title];
		}

		public function delete() {

			$this->jokesTable->delete($_POST['id']);
			
			header('Location: /novice_to_ninja/joke/list');
		}

		public function edit(): array {

			if (isset($_POST['joke'])) {

				$joke = $_POST['joke'];
				$joke['author_id'] = 1;
				$joke['date'] = new DateTime();

				$this->jokesTable->save($joke, $joke['id']);
				header('Location: /novice_to_ninja/joke/list');

			}
			else {

				if (isset($_GET['id'])) {
					
					$joke = $this->jokesTable->findById($_GET['id']);

				}

				$title = 'Vicc szerkesztése';

				return ['template' => 'editjoke.html.php',
						'title' => $title, 
						'variables' => ['joke' => $joke ?? null]
					];

			}

		}


	}