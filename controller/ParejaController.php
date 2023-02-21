<?php

require '../service/ParejaService.php';

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['familiar_id'])) {
    $familiar_id = $_GET['familiar_id'];
    $parejaService = new ParejaService();
    $pareja_id_array = $parejaService->findParejaByFamiliaId($familiar_id);
    $pareja_id = $pareja_id_array[0]["pareja_id"];

    header("Location: ../administra-descendientes.html?pareja_id=" . $pareja_id . "&familiar_id=" . $familiar_id);
    exit;
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pareja_id'])) {
    $pareja_id = $_GET['pareja_id'];
    //error_log(print_r($_POST, TRUE));
    $parejaService = new ParejaService();
    echo json_encode($parejaService->getDetallePareja($pareja_id));
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $familiar_id_pareja = $_POST['familiar_id'];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $notas = $_POST["notas"];

    //error_log(print_r($_POST, TRUE));
    $parejaService = new ParejaService();
    echo json_encode($parejaService->addNuevaPareja($nombres, $apellidos, $notas, $familiar_id_pareja));
}

exit;
?> 
