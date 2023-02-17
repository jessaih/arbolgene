<?php

	require_once '../db/ConnectionManager.php';

	class ParejaService{
		
		public function getParejaInfo($pareja_id){
			$connectionManager = new ConnectionManager();
			$pareja_info = array();			
			
			$sql_pareja_info = "SELECT pi.pareja_info_id, pi.ruta_img, pi.notas 
					FROM pareja_info pi
					where pi.pareja_id_fk = ". $pareja_id .";";
			$result_pareja_info = $connectionManager->connection->query($sql_pareja_info);
			
			$connectionManager->connection->close();
			
			if ($result_pareja_info->num_rows > 0){
				while($row_pareja_info = $result_pareja_info->fetch_assoc()){
					$pareja_info[] = $row_pareja_info;
				}
			}
			return $pareja_info;
		}	

		public function getPareja($pareja_id){
			$connectionManager = new ConnectionManager();
			$pareja = array();
			
			$sql_pareja = "SELECT p.pareja_id as pareja_id,
					f_esposa.familiar_id as ea_id, f_esposa.nombres as nom_ea, f_esposa.apellidos as ape_ea, f_esposa.notas as notas_ea,
					f_esposo.familiar_id as eo_id, f_esposo.nombres as nom_eo, f_esposo.apellidos as ape_eo, f_esposo.notas as notas_eo
					FROM pareja p 
					inner join familiar f_esposa on f_esposa.familiar_id = p.esposa_id_fk
					inner join familiar f_esposo on f_esposo.familiar_id = p.esposo_id_fk
					where p.pareja_id = ". $pareja_id .";";
			$result_pareja = $connectionManager->connection->query($sql_pareja);

			$connectionManager->connection->close();
			
			if ($result_pareja->num_rows > 0){
				if($row_pareja = $result_pareja->fetch_assoc()){
					$pareja[] = $row_pareja;					
				}
			}
			return $pareja;
		}
		
		public function findParejaByFamiliaId($familia_id){
			$connectionManager = new ConnectionManager();
			$pareja = array();	
			
			$sql_pareja = "SELECT p.pareja_id as pareja_id
					FROM pareja p 
                  	where p.esposo_id_fk = ". $familia_id ." or p.esposa_id_fk = ". $familia_id ." order by pareja_id limit 1;";
			$result_pareja = $connectionManager->connection->query($sql_pareja);

			$connectionManager->connection->close();
			
			if ($result_pareja->num_rows > 0){
				if($row_pareja = $result_pareja->fetch_assoc()){
					$pareja[] = $row_pareja;					
				}
			}
			return $pareja;
		}	
		
		/*public function addNuevaPareja($nombr){
			$response = null;
			
			$familiarService = new FamiliarService();
			$familiar_id = $familiarService->addNuevoFamiliar($_POST["nombres"], $_POST["apellidos"], $_POST["notas"]);
			
			if($familiar_id != null){
				
				//Verifica si trae un archivo para subir
				if(empty($_FILES['file']['name']) == false){
					$filename = $familiar_id . $_FILES['file']['name'];
					$location = '../assets/img/album/';
					
					//Estableciendo ultimo valor en falso ya que la llamada es desde una actualizacion
					$response = $familiarService->addImageDescendiente($filename, $location, $familiar_id);
				} else{
					$response = array("status" => "OK");
				}
			} else{
				$response = array("status" => "Error");
			}			
			
			return $response;
		}*/		
	}

?>