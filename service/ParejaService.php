<?php

require_once '../db/ConnectionManager.php';
require_once 'FamiliarService.php';

class ParejaService {

    public function getDetallePareja($pareja_id) {
        $response = array();
        $parejaService = new ParejaService();
        $pareja = $parejaService->getParejaById($pareja_id);
        $pareja_info = $parejaService->getParejaInfo($pareja_id);

        if (count($pareja) > 0) {
            $response = array(
                "pareja" => $pareja,
                "pareja_info" => $pareja_info,
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

        $sql_pareja = "SELECT p.pareja_id as pareja_id,
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

    public function addNuevaPareja($nombres, $apellidos, $notas, $familiar_id_pareja_inicial) {
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

            if ($connectionManager->connection->query($sql_pareja)) {
                $pareja_id = $connectionManager->connection->insert_id;
                $response["status"] = "OK";
                $response["pareja_id"] = $pareja_id;
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