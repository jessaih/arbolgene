<?php

	require_once '../db/ConnectionManager.php';
	require_once 'DescendienteService.php';
	require 'ParejaService.php';

	class ArbolGenealogicoService{
		
		public function getDetalleFamilia($pareja_id){

			$parejaService = new ParejaService();
			$descendienteService = new DescendienteService();
			
			$pareja = $parejaService->getPareja($pareja_id);
			$pareja_info = $parejaService->getParejaInfo($pareja_id);
			$descendientes = $descendienteService->getDetalleDescendientes($pareja_id);
			
			$response = array(
				"pareja" => $pareja,
				"pareja_info" => $pareja_info,
				"descendientes" => $descendientes
			);
			
			return $response; 
		}

		public function getParejasOrigen(){
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
			while($row = mysqli_fetch_assoc($result))
			{
				$response[] = $row;
			}
		
			return json_encode($response); 
		}		
	}

?>