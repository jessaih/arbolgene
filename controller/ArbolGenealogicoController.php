 <?php
	require '../service/ArbolGenealogicoService.php';

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	
	//error_log(print_r( $_POST, TRUE));
	
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		$pareja_id = $_GET['pareja_id'];	
		$arbolGenealogicoService = new ArbolGenealogicoService();
		if($_GET['full_content'] == true){
			echo json_encode($arbolGenealogicoService->getDetalleFamilia($pareja_id));
		} else {
			echo json_encode($arbolGenealogicoService->getDetalleDescendientes($pareja_id));
		}
	}
	else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['http_put'] == "false") {	
		$arbolGenealogicoService = new ArbolGenealogicoService();
		$response = $arbolGenealogicoService->addNuevoDescendiente();
		echo json_encode($response);
	} 
	else if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){		
		$arbolGenealogicoService = new ArbolGenealogicoService();
		$response = $arbolGenealogicoService->deleteDescendiente();
		echo json_encode($response);
	}
	else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['http_put'] == "true"){				
		$arbolGenealogicoService = new ArbolGenealogicoService();
		$response = $arbolGenealogicoService->modifyNuevoDescendiente();
		echo json_encode($response);
	}
	
	exit;

?> 
