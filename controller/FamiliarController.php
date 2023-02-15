<?php

	require '../service/FamiliarService.php';

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
		
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		$familiarService = new FamiliarService();
		echo $familiarService->getFamiliar();
	}
	
	exit;
?>