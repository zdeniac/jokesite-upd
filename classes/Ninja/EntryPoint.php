<?php
/**
 * vezérlést működtető osztály osztály
 */

namespace Ninja;


class EntryPoint
{

	private $route;
	private $routes;

	
	public function __construct(string $route, $routes){
		
		$this->route = $route;
		$this->routes = $routes;
		$this->checkUrl();

	}

	public function run() {

		$page = $this->routes->callAction($this->route);

		$title = $page['title'];

		if (isset($page['variables'])) {
			$output = $this->loadTemplate($page['template'], $page['variables']);
		}
		else {
			$output = $this->loadTemplate($page['template']);
		}

		include __DIR__ . '/../../templates/layout.html.php';

	}

//ha a megadott url nagybetűs, átirányítjuk uarra az url-re kisbetűvel
	private function checkUrl() {

		if ($this->route !== strtolower($this->route)){
			
			http_response_code(301);
			header('Location: ' . strtolower($this->route));
		
		}

	}
//betölti a template-et (view-t) a megfelelő változókkal
	private function loadTemplate(string $templateFileName, array $variables = []){

		extract($variables);

		ob_start();

		include __DIR__ . '/../../templates/' . $templateFileName;

		return ob_get_clean();

	}

}