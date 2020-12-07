<?php

	$pdo = new PDO('mysql:host=localhost;port=3308;dbname=jokes_crud;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);