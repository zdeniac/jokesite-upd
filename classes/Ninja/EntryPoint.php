<?php
/**
 * vezérlést működtető osztály
 */

namespace Ninja;

use \Ninja\Routes;


class EntryPoint
{


	private $route;
	private $routes;
	private $method;
	//localhost miatt kellett
	private $site = '/novice_to_ninja';

	
	public function __construct(string $route, string $method, Routes $routes) {
		
		$this->route = $route;
		$this->method = $method;
		$this->routes = $routes;

		$this->checkUrl();

	}

	public function run() {

		$routes = $this->routes->getRoutes();
		$authentication = $this->routes->getAuthentication();

		if (!isset($routes[$this->route])) {

			http_response_code(404);
			$output = $this->loadTemplate('404.html.php');
			$title = 'Hiba! A keresett oldal nem található!';
			
		}
		else {

//ha az aloldal bejelentkezést igényel, és a felhasználó nincs bejelentkezve
			if (isset($routes[$this->route]['login']) && !$authentication->isLoggedIn()) {
			
				header('location: ' . $this->site . '/login/error');
			
			}
			else {

				$controller = $routes[$this->route][$this->method]['controller'];
				$action = $routes[$this->route][$this->method]['action'];

				$page = $controller->$action();

//ajax-kérés esetén nem kell még egyszer betölteni a layout-ot
				if (isset($routes[$this->route]['ajax'])) {
					$output = $this->loadTemplate($page['template'], $page['variables']);
					echo $output;
					return;
				}

				$title = $page['title'];

				if (isset($page['variables'])) {
					$output = $this->loadTemplate($page['template'], $page['variables']);
				}
				else {
					$output = $this->loadTemplate($page['template']);
				}
				
			}
		}

		echo $this->loadTemplate('layout.html.php', ['loggedIn' => $authentication->isLoggedIn(), 'output' => $output, 'title' => $title]);

	}

//ha a megadott url nagybetűs, átirányítjuk uarra az url-re kisbetűvel
	private function checkUrl() {

		if ($this->route !== strtolower($this->route)){
			
			http_response_code(301);
			header('Location: ' . strtolower($this->route));
		
		}

	}

//betölti a template-et (view-t) a megfelelő változókkal
	private function loadTemplate(string $templateFileName, array $variables = []) {

		extract($variables);

		ob_start();

		include __DIR__ . '/../../templates/' . $templateFileName;

		return ob_get_clean();

	}

}