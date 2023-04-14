<?php

require_once '../db/ConnectionManager.php';
require_once 'FamiliarService.php';
require_once '../util/FileUtil.php';

class ParejaService {

    public function getDetallePareja($pareja_id) {
        $response = array();
        $parejaService = new ParejaService();
        $familiarService = new FamiliarService();
        $pareja = $parejaService->getParejaById($pareja_id);
        $pareja_info = $parejaService->getParejaInfo($pareja_id);
        $familiar_eo_info = $familiarService->getFamiliarInfo($pareja[0]["eo_id"]);
        $familiar_ea_info = $familiarService->getFamiliarInfo($pareja[0]["ea_id"]);

        if (count($pareja) > 0) {
            $response = array(
                "pareja" => $pareja,
                "pareja_info" => $pareja_info,
                "familiar_eo_info" => $familiar_eo_info,
                "familiar_ea_info" => $familiar_ea_info,
                "status" => "OK",
                "status_description" => ""
            );
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "Ocurrio un error con la obtencion de la pareja ";
        }

        return $response;
    }

    public function getParejaInfo($pareja_id) {
        $connectionManager = new ConnectionManager();
        $pareja_info = array();

        $sql_pareja_info = "SELECT pi.pareja_info_id, pi.ruta_img, pi.notas 
					FROM pareja_info pi
					where pi.pareja_id_fk = " . $pareja_id . ";";
        $result_pareja_info = $connectionManager->connection->query($sql_pareja_info);

        $connectionManager->connection->close();

        if ($result_pareja_info->num_rows > 0) {
            while ($row_pareja_info = $result_pareja_info->fetch_assoc()) {
                $pareja_info[] = $row_pareja_info;
            }
        }
        return $pareja_info;
    }

    public function getParejaById($pareja_id) {
        $connectionManager = new ConnectionManager();
        $pareja = array();

        $sql_pareja = "SELECT p.pareja_id as pareja_id, p.nivel as nivel,
					f_esposa.familiar_id as ea_id, f_esposa.nombres as nom_ea, f_esposa.apellidos as ape_ea, f_esposa.notas as notas_ea,
					f_esposo.familiar_id as eo_id, f_esposo.nombres as nom_eo, f_esposo.apellidos as ape_eo, f_esposo.notas as notas_eo
					FROM pareja p 
					inner join familiar f_esposa on f_esposa.familiar_id = p.esposa_id_fk
					inner join familiar f_esposo on f_esposo.familiar_id = p.esposo_id_fk
					where p.pareja_id = " . $pareja_id . ";";
        $result_pareja = $connectionManager->connection->query($sql_pareja);

        $connectionManager->connection->close();

        if ($result_pareja->num_rows > 0) {
            if ($row_pareja = $result_pareja->fetch_assoc()) {
                $pareja[] = $row_pareja;
            }
        }
        return $pareja;
    }

    public function findParejaByFamiliaId($familiar_id) {
        $connectionManager = new ConnectionManager();
        $pareja = array();

        $sql_pareja = "SELECT p.pareja_id as pareja_id
					FROM pareja p 
                  	where p.esposo_id_fk = " . $familiar_id . " or p.esposa_id_fk = " . $familiar_id . " order by pareja_id limit 1;";
        $result_pareja = $connectionManager->connection->query($sql_pareja);

        $connectionManager->connection->close();

        if ($result_pareja->num_rows > 0) {
            if ($row_pareja = $result_pareja->fetch_assoc()) {
                $pareja[] = $row_pareja;
            }
        }
        return $pareja;
    }

    public function addNuevaPareja($nombres, $apellidos, $notas, $familiar_id_pareja_inicial, $imagen_pareja_info) {
        $response = array();

        $familiarService = new FamiliarService();
        $familiar_response = $familiarService->addNuevoFamiliarConImagen($nombres, $apellidos, $notas, $familiar_id_pareja_inicial);

        if ($familiar_response["status"] == "OK") {
            $familiar_id_pareja = $familiar_response["familiar_id"];

            $pareja_nivel_response = $this->findParejaNivelByFamiliarId($familiar_id_pareja_inicial);
            $pareja_nivel = $pareja_nivel_response[0]["nivel"] + 1;

            $connectionManager = new ConnectionManager();
            //Inserta registro en tabla
            $sql_pareja = "INSERT INTO pareja (esposo_id_fk, esposa_id_fk, nivel) VALUES" .
                    " (" . $familiar_id_pareja_inicial . ", " . $familiar_id_pareja . ", " . $pareja_nivel . ");";

            $connectionManager->connection->query($sql_pareja);
            $pareja_id = $connectionManager->connection->insert_id;

            //Verifica si trae imagen de pareja para insertarla y crear registro, de lo contrario manda un OK
            $response_imagen = null;

            if (!empty($imagen_pareja_info["pareja_img"])) {
                $imagen_pareja_info["pareja_id"] = $pareja_id;
                $response_imagen = $this->addImagenPareja($imagen_pareja_info);
            } else {
                $response_imagen = array("status" => "OK");
            }

            if ($pareja_id != null && $response_imagen["status"] == "OK") {
                $response["pareja_id"] = $pareja_id;
                $response["status"] = "OK";
                $response["status_description"] = "";
            } else {
                $response["status"] = "Error";
                $response["status_description"] = "Ocurrio un error con la creacion de la pareja ";
            }
            $connectionManager->connection->close();
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "Ocurrio un error con la creacion del familiar en pareja_service ";
        }

        return $response;
    }

    public function modifyFullPareja($esposo, $esposa, $imagen_pareja_info) {
        $response = array();

        $familiarService = new FamiliarService();

        $_FILES["file"] = $esposo["img"];
        $response_esposo = $familiarService->modifyFamiliarConImagen($esposo["nombres"], $esposo["apellidos"], $esposo["notas"], $esposo["id"]);

        $_FILES["file"] = $esposa["img"];
        $response_esposa = $familiarService->modifyFamiliarConImagen($esposa["nombres"], $esposa["apellidos"], $esposa["notas"], $esposa["id"]);

        //Verifica si trae imagen de pareja para insertarla y crear registro, de lo contrario manda un OK
        $response_imagen = null;

        if (!empty($imagen_pareja_info["pareja_img"])) {
            $response_imagen = $this->addImagenPareja($imagen_pareja_info);
        } else {
            $response_imagen = array("status" => "OK");
        }

        if ($response_esposo["status"] == "OK" && $response_esposa["status"] == "OK" && $response_imagen["status"] == "OK") {
            $response["status"] = "OK";
            $response["status_description"] = "";
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "Ocurrio un error con la actualizacion de los miembros de la pareja ";
        }
    }

    public function addImagenPareja($imagen_pareja_info) {

        $fileUtil = new FileUtil();
        $connectionManager = new ConnectionManager();
        $response = array();

        $pareja_id = $imagen_pareja_info["pareja_id"];
        $pareja_img = $imagen_pareja_info["pareja_img"];
        $pareja_img_notas = $imagen_pareja_info["pareja_img_notas"];

        $filename = $pareja_id . $pareja_img['name'];
        $location = '../assets/img/album/';

        //Intenta subir archivo a servidor, de tener exito, inserta información en base de datos
        if ($fileUtil->addImageNew($pareja_img, $filename, $location)) {

            //Verifica si hay informacion relacionada al familiar en la tabla famliar_info
            $pareja_info = $this->getParejaInfo($pareja_id);
            $sql_pareja_info = null;

            //Si hay información se actualiza, de lo contrario se inserta
            if (count($pareja_info) > 0) {
                $sql_pareja_info = "UPDATE pareja_info SET " .
                        " ruta_img ='" . $filename . "', notas ='" . $pareja_img_notas . "' " .
                        " WHERE pareja_id_fk = " . $pareja_id . " and pareja_info_id = " . $pareja_info[0]["pareja_info_id"];

                $deleteFilename = $pareja_info[0]["ruta_img"];
                if ($fileUtil->deleteImage($deleteFilename, $location)) {
                    $response["status"] = "OK";
                    $response["status_description"] = "";
                } else {
                    $response["status"] = "Error";
                    $response["status_description"] = "No se pudo eliminar la imagen antigua";
                }
            } else {
                $sql_pareja_info = "INSERT INTO pareja_info (ruta_img, notas, pareja_id_fk) VALUES" .
                        " ('" . $filename . "', '" . $pareja_img_notas . "' ," . $pareja_id . ");";
            }

            $query_result = $connectionManager->connection->query($sql_pareja_info);

            if ($query_result == TRUE) {
                $response["status"] = "OK";
                $response["status_description"] = "";
            } else {
                $response["status"] = "Error";
                $response["status_description"] = "No se pudo ejecutar la insercion / actualizacion de la informacion de pareja";
            }
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "No se pudo subir la imagen al servidor";
        }

        return $response;
    }

    public function findParejaNivelByFamiliarId($familiar_id) {
        $connectionManager = new ConnectionManager();
        $pareja = array();

        $sql_pareja = "SELECT p.nivel  " .
                " FROM pareja p" .
                " INNER JOIN descendiente d ON d.pareja_id_fk = p.pareja_id " .
                " WHERE d.familiar_id_fk = " . $familiar_id;
        $result_pareja = $connectionManager->connection->query($sql_pareja);

        $connectionManager->connection->close();

        if ($result_pareja->num_rows > 0) {
            if ($row_pareja = $result_pareja->fetch_assoc()) {
                $pareja[] = $row_pareja;
            }
        }
        return $pareja;
    }

}

?>