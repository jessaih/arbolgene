 <?php

	require '../service/AncestrosService.php';

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');

	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		
		$ancestrosService = new AncestrosService();
		echo $ancestrosService->getAncestros();
	}
	
	exit;

?> 
