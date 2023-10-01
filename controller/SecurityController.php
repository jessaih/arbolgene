<?php

require '../service/ArbolGenealogicoService.php';

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $arbolGenealogicoService = new ArbolGenealogicoService();
    $arbolGenealogicoService->cierraSesion();
    header('Location: ../index.html');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["user"]) && isset($_POST["passwd"])) {
    $arbolGenealogicoService = new ArbolGenealogicoService();
    //$result = $arbolGenealogicoService->iniciaSesion($_POST["user"], $_POST["passwd"]);
    $result = true;
    echo "algo".$result;
    if($result == true){
        echo "algo".$result;
        
        header("Location: ../visualiza-parejas-origen.php");
    } else {
        //header('Location: ../index.html?unauthorized=true');
    }
}


exit;
?> 
