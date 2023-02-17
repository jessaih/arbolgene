 <?php

	require '../service/ParejaService.php';

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
		
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		$familiar_id = $_GET['familiar_id'];
		$parejaService = new ParejaService();
		$pareja_id_array = $parejaService->findParejaByFamiliaId($familiar_id);
		$pareja_id = $pareja_id_array[0]["pareja_id"];
		
		header("Location: ../administra-descendientes.html?pareja_id=".$pareja_id);
		exit;
	} 
	else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$familiar_id = $_GET['familiar_id'];
		/*$parejaService = new ParejaService();
		$pareja_id_array = $parejaService->findParejaByFamiliaId($familiar_id);
		$pareja_id = $pareja_id_array[0]["pareja_id"];
		*/
		header("Location: ../administra-descendientes.html?pareja_id=".$pareja_id);
		exit;
	} 
	
	exit;

?> 
