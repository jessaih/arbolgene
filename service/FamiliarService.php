<?php

require_once '../db/ConnectionManager.php';
require_once '../util/FileUtil.php';

class FamiliarService {

    public function getFamiliarInfo($familiar_id_fk) {
        $connectionManager = new ConnectionManager();
        $familiar_info = array();

        $sql_familiar_info = "SELECT *
					FROM familiar_info fi
					WHERE fi.familiar_id_fk = " . $familiar_id_fk . ";";
        $result_familiar_info = $connectionManager->connection->query($sql_familiar_info);

        $connectionManager->connection->close();

        if ($result_familiar_info->num_rows > 0) {
            while ($row_familiar_info = $result_familiar_info->fetch_assoc()) {
                $familiar_info[] = $row_familiar_info;
            }
        }
        return $familiar_info;
    }

    public function getFamiliar($familiar_id) {
        $connectionManager = new ConnectionManager();
        $familiar_info = array();

        $sql_familiar_info = "SELECT *
					FROM familiar f
					WHERE f.familiar_id = " . $familiar_id . ";";
        $result_familiar_info = $connectionManager->connection->query($sql_familiar_info);

        $connectionManager->connection->close();

        if ($result_familiar_info->num_rows > 0) {
            while ($row_familiar_info = $result_familiar_info->fetch_assoc()) {
                $familiar_info[] = $row_familiar_info;
            }
        }
        return $familiar_info;
    }

    public function getDetalleFamiliar($familiar_id) {

        $familiar = $this->getFamiliar($familiar_id);
        $familiar_info = $this->getFamiliarInfo($familiar_id);

        $response = array(
            "familiar" => $familiar,
            "familiar_info" => $familiar_info,
        );

        return $response;
    }

    public function addNuevoFamiliarConImagen($nombres, $apellidos, $notas) {
        $response = array();
        $status = null;

        $familiar_response = $this->addNuevoFamiliar($nombres, $apellidos, $notas);
        $familiar_id = $familiar_response["familiar_id"];

        if ($familiar_id != null) {
            $response["familiar_id"] = $familiar_id;
            //Verifica si trae un archivo para subir
            if (empty($_FILES['file']['name']) == false) {
                $filename = $familiar_id . $_FILES['file']['name'];
                $location = '../assets/img/album/';

                $status = $this->addOrUpdateImagenFamiliar($filename, $location, $familiar_id);
            } else {
                $status["status"] = "OK";
                $status["status_description"] = "";
            }
        } else {
            $status["status"] = "Error";
            $status["status_description"] = "Familiar_id es nulo";
        }

        $response["status"] = $status["status"];
        $response["status_description"] = $status["status_description"];
        $response["familiar_id"] = $familiar_id;

        return $response;
    }

    public function modifyFamiliarConImagen($nombres, $apellidos, $notas, $familiar_id) {
        $response = array();
        $status = null;
        $familiar_response = $this->modifyFamiliar($nombres, $apellidos, $notas, $familiar_id);

        if ($familiar_response["status"] == "OK") {

            //Verifica si trae un archivo para subir
            if (empty($_FILES['file']['name']) == false) {
                $filename = $familiar_id . $_FILES['file']['name'];
                $location = '../assets/img/album/';

                $status = $this->addOrUpdateImagenFamiliar($filename, $location, $familiar_id);
            } else {
                $status["status"] = "OK";
                $status["status_description"] = "";
            }
        } else {
            $status["status"] = "Error";
            $status["status_description"] = "Error al actualizar el registro con la informacion dada";
        }
        $response["status"] = $status["status"];
        $response["status_description"] = $status["status_description"];
        return $response;
    }

    public function deleteFamiliarConImagen($familiar_id) {
        $response = array();
//        error_log(print_r($familiar_id, TRUE));
        $familiar_response = $this->deleteImagenFamiliar($familiar_id);
        
        if ($familiar_response["status"] == "OK") {
            $response = $this->deleteFamiliar($familiar_id);
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "Error al actualizar el registro con la informacion dada";
        }
        
        return $response;
    }

    public function addNuevoFamiliar($nombres, $apellidos, $notas) {
        $response = null;

        $connectionManager = new ConnectionManager();
        //Inserta registro en tabla
        $sql_familiar = "INSERT INTO familiar (nombres, apellidos, notas) VALUES" .
                " ( '" . $nombres . "', '" . $apellidos . "', '" . $notas . "');";

        if ($connectionManager->connection->query($sql_familiar)) {
            $familiar_id = $connectionManager->connection->insert_id;
            $response = array("familiar_id" => $familiar_id);
        } else {
            $response = array("familiar_id" => null);
        }
        $connectionManager->connection->close();

        return $response;
    }

    public function modifyFamiliar($nombres, $apellidos, $notas, $familiar_id) {
        $response = array();

        $connectionManager = new ConnectionManager();

        $sql_familiar = "UPDATE familiar SET " .
                " nombres = '" . $nombres . "', apellidos = '" . $apellidos . "', notas = '" . $notas . "'" .
                " WHERE familiar_id = " . $familiar_id;

        if ($connectionManager->connection->query($sql_familiar)) {
            $response["status"] = "OK";
            $response["status_description"] = "";
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "Error al actualizar el registro con la informacion dada";
        }
        $connectionManager->connection->close();

        return $response;
    }

    public function deleteFamiliar($familiar_id) {
        $response = array();

        $connectionManager = new ConnectionManager();

        $sql_delete_familiar = "DELETE FROM familiar 
                                WHERE familiar_id = " . $familiar_id . "";

        if ($connectionManager->connection->query($sql_delete_familiar)) {
            $response["status"] = "OK";
            $response["status_description"] = "";
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "Error al eliminar el familiar";
        }
        $connectionManager->connection->close();

        return $response;
    }

    /* 	Método usado por creacion y actualizacion de familiar_info y su imagen
     */

    public function addOrUpdateImagenFamiliar($filename, $location, $familiar_id) {

        $fileUtil = new FileUtil();
        $connectionManager = new ConnectionManager();
        $response = array();

        //Intenta subir archivo a servidor, de tener exito, inserta información en base de datos
        if ($fileUtil->addImage($filename, $location)) {
            $familiarService = new FamiliarService();
            //Verifica si hay informacion relacionada al familiar en la tabla famliar_info
            $familiar_info = $familiarService->getFamiliarInfo($familiar_id);
            $sql_familiar_info = null;

            //Si hay información se actualiza, de lo contrario se inserta
            if (count($familiar_info) > 0) {
                $sql_familiar_info = "UPDATE familiar_info SET " .
                        " ruta_img ='" . $filename . "' " .
                        " WHERE familiar_id_fk = " . $familiar_id;

                $deleteFilename = $familiar_info[0]["ruta_img"];
                if ($fileUtil->deleteImage($deleteFilename, $location)) {
                    $response["status"] = "OK";
                    $response["status_description"] = "";
                } else {
                    $response["status"] = "Error";
                    $response["status_description"] = "No se pudo eliminar la imagen antigua";
                }
            } else {
                $sql_familiar_info = "INSERT INTO familiar_info (ruta_img, familiar_id_fk) VALUES" .
                        " ('" . $filename . "', " . $familiar_id . ");";
            }

            $query_result = $connectionManager->connection->query($sql_familiar_info);

            if ($query_result == TRUE) {
                $response["status"] = "OK";
                $response["status_description"] = "";
            } else {
                $response["status"] = "Error";
                $response["status_description"] = "No se pudo ejecutar la insercion / actualizacion de la informacion familiar";
            }
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "No se pudo subir la imagen al servidor";
        }

        return $response;
    }

    /* 	Método usado para la eliminacion de familiar_info y su imagen
     */

    public function deleteImagenFamiliar($familiar_id) {
        $familiar_info = $this->getFamiliarInfo($familiar_id);
        $response = array();

        if (count($familiar_info) > 0) {
            $connectionManager = new ConnectionManager();

            $sql_delete_familiar_info = " DELETE FROM familiar_info 
						WHERE familiar_id_fk = " . $familiar_id . "";
            $result_delete_familiar_info = $connectionManager->connection->query($sql_delete_familiar_info);

            $fileUtil = new FileUtil();

            $filename = $familiar_info[0]["ruta_img"];
            $location = '../assets/img/album/';

            if ($result_delete_familiar_info == TRUE && $fileUtil->deleteImage($filename, $location)) {
                $response["status"] = "OK";
                $response["status_description"] = "";
            } else {
                $response["status"] = "Error";
                $response["status_description"] = "No se pudo eliminar la información adicional de este familiar";
            }
        } else {
            $response["status"] = "OK";
            $response["status_description"] = "NO_INFO_RECORDS";
        }

        return $response;
    }

}

?>