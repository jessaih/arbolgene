<?php

require_once '../db/ConnectionManager.php';
require_once '../util/FileUtil.php';
require_once 'FamiliarService.php';

class DescendienteService {

    public function getDetalleDescendientes($pareja_id) {
        $connectionManager = new ConnectionManager();
        $descendientes = array();

        $sql_descendientes = "SELECT d.descendiente_id, d.familiar_id_fk, d.numero_hermano, f.nombres, f.apellidos, f.notas,
					(
					SELECT fi.ruta_img
						FROM familiar_info fi
						where f.familiar_id = fi.familiar_id_fk
						GROUP BY fi.familiar_id_fk
					) as ruta_img,
                    (
					SELECT count(p.pareja_id)
						FROM pareja p
						where f.familiar_id = p.esposo_id_fk or f.familiar_id = p.esposa_id_fk
					) as numero_parejas
					FROM descendiente d
					inner join familiar f on d.familiar_id_fk = f.familiar_id
					where d.pareja_id_fk = " . $pareja_id . "
					order by numero_hermano;";
        $result_descendientes = $connectionManager->connection->query($sql_descendientes);

        $connectionManager->connection->close();

        if ($result_descendientes->num_rows > 0) {
            while ($row_descendientes = $result_descendientes->fetch_assoc()) {
                $descendientes[] = $row_descendientes;
            }
        }
        return $descendientes;
    }

    public function getDescendienteById($descendiente_id) {
        $connectionManager = new ConnectionManager();
        $descendiente = array();

        $sql_descendiente_info = "SELECT *
					FROM descendiente d
					WHERE d.descendiente_id = " . $descendiente_id . ";";
        $result_descendiente_info = $connectionManager->connection->query($sql_descendiente_info);

        $connectionManager->connection->close();

        if ($result_descendiente_info->num_rows > 0) {
            while ($row_descendiente = $result_descendiente_info->fetch_assoc()) {
                $descendiente[] = $row_descendiente;
            }
        }
        return $descendiente;
    }

    public function addNuevoDescendiente($nombres, $apellidos, $notas, $pareja_id, $numero_hijo) {
        $response = array();

        $familiarService = new FamiliarService();
        $familiar_response = $familiarService->addNuevoFamiliarConImagen($nombres, $apellidos, $notas);

        if ($familiar_response["status"] == "OK") {
            $familiar_id = $familiar_response["familiar_id"];

            $connectionManager = new ConnectionManager();
            //Inserta registro en tabla
            $sql_descendiente = "INSERT INTO descendiente (pareja_id_fk, familiar_id_fk, numero_hermano) VALUES" .
                    " (" . $pareja_id . ", " . $familiar_id . ", " . $numero_hijo . ");";

            if ($connectionManager->connection->query($sql_descendiente)) {
                $response["status"] = "OK";
                $response["status_description"] = "";
            } else {
                $response["status"] = "Error";
                $response["status_description"] = "Ocurrio un error con la creacion del descendiente ";
            }
            $connectionManager->connection->close();
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "Ocurrio un error con la creacion del familiar ";
        }

        return $response;
    }

    public function modifyDescendiente($nombres, $apellidos, $notas, $descendiente_id, $numero_hijo) {

        $descendiente = $this->getDescendienteById($descendiente_id);
        $response = array();

        if (count($descendiente) > 0) {
            $familiar_id = $descendiente[0]["familiar_id_fk"];
            $familiarService = new FamiliarService();
            //Actualiza registro en tabla familiar
            $familiar_response = $familiarService->modifyFamiliarConImagen($nombres, $apellidos, $notas, $familiar_id);

            if ($familiar_response["status"] == "OK") {
                $connectionManager = new ConnectionManager();

                //Actualiza descendiente
                $sql_descendiente = "UPDATE descendiente SET " .
                        " numero_hermano = " . $numero_hijo .
                        " WHERE descendiente_id = " . $descendiente_id;
                if ($connectionManager->connection->query($sql_descendiente)) {
                    $response["status"] = "OK";
                    $response["status_description"] = "";
                } else {
                    $response["status"] = "Error";
                    $response["status_description"] = "Ocurrio un error con la actualizacion del descendiente ";
                }
                $connectionManager->connection->close();
            } else {
                $response["status"] = "Error";
                $response["status_description"] = "Ocurrio un error con la actualizacion del familiar ";
            }
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "El registro que se desea actualizar no existe ";
        }

        return $response;
    }

    public function deleteDescendiente($descendiente_id) {
        $familiarService = new FamiliarService();
        $descendiente = $this->getDescendienteById($descendiente_id);
        $response = array();

        if (count($descendiente) > 0) {
            $connectionManager = new ConnectionManager();
            $sql_delete_descendiente = " DELETE FROM descendiente 
						WHERE descendiente_id = " . $descendiente_id . "";
            $result_delete_descendiente = $connectionManager->connection->query($sql_delete_descendiente);
            $connectionManager->connection->close();

            if ($result_delete_descendiente == TRUE) {
                $familiar_id_fk = $descendiente[0]["familiar_id_fk"];

                //Verifica y elimina registro del familiar y su informacion adicional
                $familiar_response = $familiarService->deleteFamiliarConImagen($familiar_id_fk);

                if ($familiar_response["status"] == "OK") {
                    $response["status"] = "OK";
                    $response["status_description"] = "";
                } else {
                    $response["status"] = "Error";
                    $response["status_description"] = "Ocurrio un error con la eliminacion del familiar ";
                }
            } else {
                $response["status"] = "Error";
                $response["status_description"] = "Ocurrio un error con la eliminacion del descendiente";
            }
        } else {
            $response["status"] = "Error";
            $response["status_description"] = "El registro que se desea eliminar no existe ";
        }

        return $response;
    }

}
?> 
