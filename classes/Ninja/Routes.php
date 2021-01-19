<?php
//interface a route-okhoz

namespace Ninja;


interface Routes {

	public function getRoutes(): array;
	public function getAuthentication(): \Ninja\Authentication;

}