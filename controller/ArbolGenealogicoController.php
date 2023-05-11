<?php

require '../service/ArbolGenealogicoService.php';
require_once '../util/SecurityValidatorServer.php';

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

//error_log(print_r( $_POST, TRUE));

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $arbolGenealogicoService = new ArbolGenealogicoService();
    echo $arbolGenealogicoService->getParejasOrigen();
}


exit;
?> 
