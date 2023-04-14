<?php

require_once '../db/ConnectionManager.php';
require_once 'DescendienteService.php';
require_once 'ParejaService.php';
require_once 'FamiliarService.php';

class ArbolGenealogicoService {

    public function getDetalleFamilia($pareja_id) {

        $parejaService = new ParejaService();
        $descendienteService = new DescendienteService();
        $familiarService = new FamiliarService();

        $pareja = $parejaService->getParejaById($pareja_id);
        $pareja_info = $parejaService->getParejaInfo($pareja_id);
        $descendientes = $descendienteService->getDetalleDescendientes($pareja_id);
        $pareja_info_ea = null;
        $pareja_info_eo = null;
        $ancestros_id = null;
        
        if (count($pareja) > 0 && $pareja[0]["eo_id"] != null && $pareja[0]["ea_id"] != null) {
            $pareja_info_eo = $familiarService->getFamiliarInfo($pareja[0]["eo_id"]);
            $pareja_info_ea = $familiarService->getFamiliarInfo($pareja[0]["ea_id"]);
        }
        
        /**Funcion que recibe el esposo_id para obtener sus ancestros, esto siempre funcionará
        * ya que el sistema esta diseñado a que el esposo_id o eo_id siempre contendrá
        * el Id del familiar directo y no de la pareja que viene de otra familia externa
        */
        if($pareja[0]["nivel"] > 1){
            $descendiente_familiar_info = $descendienteService->getDescendienteByFamiliarId($pareja[0]["eo_id"]);
            $ancestros_id = $descendiente_familiar_info[0]["pareja_id_fk"];
        }

        $response = array(
            "pareja" => $pareja,
            "pareja_info" => $pareja_info,
            "descendientes" => $descendientes,
            "pareja_info_eo" => $pareja_info_eo,
            "pareja_info_ea" => $pareja_info_ea,
            "ancestros_id" => $ancestros_id,
        );

        return $response;
    }

    public function getParejasOrigen() {
        $connectionManager = new ConnectionManager();

        $sql = "SELECT p.pareja_id as pareja_id,
			f_esposa.familiar_id as ea_id, f_esposa.nombres as nom_ea, f_esposa.apellidos as ape_ea, f_esposa.notas as notas_ea,
			f_esposo.familiar_id as eo_id, f_esposo.nombres as nom_eo, f_esposo.apellidos as ape_eo, f_esposo.notas as notas_eo,
			pi.ruta_img as pi_img
			FROM `pareja` p 
			inner join familiar f_esposa on f_esposa.familiar_id = p.esposa_id_fk
			inner join familiar f_esposo on f_esposo.familiar_id = p.esposo_id_fk
			left join (
				SELECT pi.pareja_id_fk, pi.ruta_img
					FROM pareja_info pi
					GROUP BY pi.pareja_id_fk
			) as pi on p.pareja_id = pi.pareja_id_fk
			where p.nivel = (SELECT MIN(pmin.nivel) from pareja as pmin);";

        $result = $connectionManager->connection->query($sql);
        $connectionManager->connection->close();
        //create an array
        $response = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }

        return json_encode($response);
    }

}

?>