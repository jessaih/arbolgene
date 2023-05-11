<?php

require '../service/FamiliarService.php';
require_once '../util/SecurityValidatorServer.php';

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $familiar_id = $_GET['familiar_id'];
    $familiarService = new FamiliarService();
    echo json_encode($familiarService->getDetalleFamiliar($familiar_id));
}

exit;
?>