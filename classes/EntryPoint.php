<?php
/**
 * vezérlésért felelő osztály
 */
class EntryPoint
{

	private $route;

	
	public function __construct(string $route){
		
		$this->route = $route;
		$this->checkUrl();

	}

	private function checkUrl() {

		if ($this->route !== strtolower($this->route)){
			
			http_response_code(301);
			header('Location: ' . strtolower($this->route));
		
		}

	}

	private function loadTemplate(string $templateFileName, array $variables = []){

		extract($variables);

		ob_start();

		include __DIR__.'\\templates\\' . $templateFileName;

		return ob_get_clean();

	}

	private function callAction(): array {

		require __DIR__ . '/../includes/DatabaseConnection.php';
		require __DIR__ . '/../classes/DatabaseTable.php';

		$jokesTable = new DatabaseTable($pdo, 'joke');
		$authorsTable = new DatabaseTable($pdo, 'author');

		if ($route === 'novice_to_ninja/joke/list') {
			include __DIR__ . '/../controllers/JokeController.php';
			$controller = new JokeController($jokesTable, $authorsTable);
			$page = $controller->list();
		}
		else if ($route === 'novice_to_ninja/joke/home' || $route === 'novice_to_ninja/') {
			include __DIR__ . '/../controllers/JokeController.php';
			$controller = new JokeController($jokesTable, $authorsTable);
			$page = $controller->home();
		}
		else if ($route === 'novice_to_ninja/joke/edit') {
			include __DIR__ . '/../controllers/JokeController.php';
			$controller = new JokeController($jokesTable, $authorsTable);
			$page = $controller->edit();
		}
		else if ($route === 'novice_to_ninja/joke/delete') {
			include __DIR__ . '/../controllers/JokeController.php';
			$controller = new JokeController($jokesTable, $authorsTable);
			$page = $controller->delete();
		}
		else if ($route === 'novice_to_ninja/register') {
			include __DIR__ . '/../controllers/RegisterController.php';
			$controller = new RegisterController($authorsTable);
			$page = $controller->showForm();
		}
		else {
			http_response_code(404);
			die('404');
		}

		return $page;

	}

	public function run() {

		$page = $this->callAction();

		$title = $page['title'];

		if (isset($page['variables'])) {
			$output = $this->loadTemplate($page['template'], $page['variables']);
		}
		else {
			$output = $this->loadTemplate($page['template']);
		}

		include __DIR__ . '/../templates/layout.html.php';

	}

}