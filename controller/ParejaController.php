<?php

require '../service/ParejaService.php';
require_once '../util/SecurityValidator.php';

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['familiar_id'])) {
    $familiar_id = $_GET['familiar_id'];
    $parejaService = new ParejaService();
    $pareja_id_array = $parejaService->findParejaByFamiliaId($familiar_id);
    $pareja_id = $pareja_id_array[0]["pareja_id"];

    header("Location: ../administra-descendientes.php?pareja_id=" . $pareja_id . "&familiar_id=" . $familiar_id);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pareja_id'])) {
    $pareja_id = $_GET['pareja_id'];
    //error_log(print_r($_POST, TRUE));
    $parejaService = new ParejaService();
    echo json_encode($parejaService->getDetallePareja($pareja_id));
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['familiar_id'])) {
    
    $familiar_id_pareja = $_POST['familiar_id'];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $notas = $_POST["notas"];
    
    $imagen_pareja_info = array(
        "pareja_img_notas" => $_POST["notas_pareja_img"],
        "pareja_img" => empty($_FILES['file_pareja_img']['name']) == false ? $_FILES["file_pareja_img"] : array()
    );  

    //error_log(print_r($_POST, TRUE));
    $parejaService = new ParejaService();
    echo json_encode($parejaService->addNuevaPareja($nombres, $apellidos, $notas, $familiar_id_pareja, $imagen_pareja_info));
    
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $esposo = array(
        "id" => $_POST['esposo_id'],
        "nombres" => $_POST['nombres_eo'],
        "apellidos" => $_POST['apellidos_eo'],
        "notas" => $_POST['notas_eo'],
        "img" => empty($_FILES['file_eo']['name']) == false ? $_FILES["file_eo"] : array()
    );
    
    $esposa = array(
        "id" => $_POST['esposa_id'],
        "nombres" => $_POST['nombres_ea'],
        "apellidos" => $_POST['apellidos_ea'],
        "notas" => $_POST['notas_ea'],
        "img" => empty($_FILES['file_ea']['name']) == false ? $_FILES["file_ea"] : array()
    );
    
    $imagen_pareja_info = array(
        "pareja_id" => $_POST["pareja_id"],
        "pareja_img_notas" => $_POST["notas_pareja_img"],
        "pareja_img" => empty($_FILES['file_pareja_img']['name']) == false ? $_FILES["file_pareja_img"] : array()
    );
    
    $parejaService = new ParejaService();
    echo json_encode($parejaService->modifyFullPareja($esposo, $esposa, $imagen_pareja_info));
}

exit;
?> 
