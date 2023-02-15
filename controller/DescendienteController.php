<?php

	require '../service/DescendienteService.php';
	require '../service/ArbolGenealogicoService.php';

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');

	$descendienteService = new DescendienteService();
	
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		$pareja_id = $_GET['pareja_id'];

		if($_GET['full_content'] == true){
			$arbolGenealogicoService = new ArbolGenealogicoService();
			echo json_encode($arbolGenealogicoService->getDetalleFamilia($pareja_id));
		} else {
			echo json_encode($descendienteService->getDetalleDescendientes($pareja_id));
		}
	}
	else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['http_put'] == "false") {	
		$response = $descendienteService->addNuevoDescendiente();
		echo json_encode($response);
	} 
	else if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){		
		$response = $descendienteService->deleteDescendiente();
		echo json_encode($response);
	}
	else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['http_put'] == "true"){				
		$response = $descendienteService->modifyNuevoDescendiente();
		echo json_encode($response);
	}
	
	exit;
?>