<?php

	require '../service/DescendienteService.php';
	require '../service/ArbolGenealogicoService.php';
        require_once '../util/SecurityValidator.php';

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
		$nombres = $_POST["nombres"];
		$apellidos = $_POST["apellidos"];
		$notas = $_POST["notas"];
		$pareja_id = $_POST["pareja_id"];
		$numero_hijo = $_POST["numero"];
		
		$response = $descendienteService->addNuevoDescendiente($nombres, $apellidos, $notas, $pareja_id, $numero_hijo);
		echo json_encode($response);
	} 
	else if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){		
		$descendiente_id = $_GET['descendiente_id'];
		$response = $descendienteService->deleteDescendiente($descendiente_id);
		echo json_encode($response);
	}
	else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['http_put'] == "true"){	
		$nombres = $_POST["nombres"];
		$apellidos = $_POST["apellidos"];
		$notas = $_POST["notas"];
		$descendiente_id = $_POST['descendiente_id'];
		$numero_hijo = $_POST["numero"];
		
		$response = $descendienteService->modifyDescendiente($nombres, $apellidos, $notas, $descendiente_id, $numero_hijo);
		echo json_encode($response);
	}
	
	exit;
?>