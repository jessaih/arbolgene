<?php

	require_once '../db/ConnectionManager.php';

	class FamiliarService{
		
		public function getFamiliarInfo($familiar_id_fk){
			$connectionManager = new ConnectionManager();
			$familiar_info = array();			
			
			$sql_familiar_info = "SELECT *
					FROM familiar_info fi
					WHERE fi.familiar_id_fk = ". $familiar_id_fk .";";
			$result_familiar_info = $connectionManager->connection->query($sql_familiar_info);
			
			$connectionManager->connection->close();
			
			if ($result_familiar_info->num_rows > 0){
				while($row_familiar_info = $result_familiar_info->fetch_assoc()){
					$familiar_info[] = $row_familiar_info;
				}
			}
			return $familiar_info;
		}	

		public function getFamiliar($familiar_id){
			$connectionManager = new ConnectionManager();
			$familiar_info = array();			
			
			$sql_familiar_info = "SELECT *
					FROM familiar f
					WHERE f.familiar_id = ". $familiar_id .";";
			$result_familiar_info = $connectionManager->connection->query($sql_familiar_info);
			
			$connectionManager->connection->close();
			
			if ($result_familiar_info->num_rows > 0){
				while($row_familiar_info = $result_familiar_info->fetch_assoc()){
					$familiar_info[] = $row_familiar_info;
				}
			}
			return $familiar_info;
		}
		public function getDetalleFamiliar($familiar_id){
			
			$familiar = $this->getFamiliar($familiar_id);
			$familiar_info = $this->getFamiliarInfo($familiar_id);
			
			$response = array(
				"familiar" => $familiar,
				"familiar_info" => $familiar_info,
			);
			
			return $response; 
		}
		
		public function addNuevoFamiliarConImagen($nombres, $apellidos, $notas){
			$response = array();
			$status = null;
			
			$familiar_response = $this->addNuevoFamiliar($nombres, $apellidos, $notas);

			$familiar_id = $familiar_response["familiar_id"];
			
			if($familiar_id != null){
				$response["familiar_id"] = $familiar_id;
				//Verifica si trae un archivo para subir
				if(empty($_FILES['file']['name']) == false){
					$filename = $familiar_id . $_FILES['file']['name'];
					$location = '../assets/img/album/';
					
					$status = $this->addImageDescendiente($filename, $location, $familiar_id);
				} else{
					$status["status"] = "OK";
					$status["status_description"] = "";
				}
			} else{
				$status["status"] = "Error";
				$status["status_description"] = "Familiar_id es nulo";
			}
			
			$response["status"] = $status["status"];
			$response["status_description"] = $status["status_description"];
			$response["familiar_id"] = $familiar_id;
			
			/*error_log(print_r("Fam Serv ", TRUE)); 
			error_log(print_r($response, TRUE)); */
			return $response;
		}		
		
		public function addNuevoFamiliar($nombres, $apellidos, $notas){
			$response = null;

			$connectionManager = new ConnectionManager();
			//Inserta registro en tabla
			$sql_familiar = "INSERT INTO familiar (nombres, apellidos, notas) VALUES" .
			" ( '".$nombres."', '".$apellidos."', '".$notas."');";
			
			if($connectionManager->connection->query($sql_familiar)){
				$familiar_id = $connectionManager->connection->insert_id;
				$response = array("familiar_id" => $familiar_id);
			} else{
				$response = array("familiar_id" => null);
			}
			$connectionManager->connection->close();
			
			return $response;
		}
		
		/* 	Método usado por creacion y actualizacion de descendiente
		*/
		
		public function addImageDescendiente($filename, $location, $familiar_id){
			
			$fileUtil = new FileUtil();
			$connectionManager = new ConnectionManager();	
			$response = array();
			
			//Intenta subir archivo a servidor, de tener exito, inserta información en base de datos
			if($fileUtil->addImage($filename, $location)){
				$familiarService = new FamiliarService();
				//Verifica si hay informacion relacionada al familiar en la tabla famliar_info
				$familiar_info = $familiarService->getFamiliarInfo($familiar_id);
				$sql_familiar_info = null;
				
				//Si hay información se actualiza, de lo contrario se inserta
				if(count($familiar_info) > 0){
					$sql_familiar_info = "UPDATE familiar_info SET ".
					" ruta_img ='".$filename."' " .
					" WHERE familiar_id_fk = ". $familiar_id ;

					$deleteFilename = $familiar_info[0]["ruta_img"];
					if($fileUtil->deleteImage($deleteFilename, $location)){
						$response["status"] = "OK";
						$response["status_description"] = "";
					} else{
						$response["status"] = "Error";
						$response["status_description"] = "No se pudo eliminar la imagen antigua";
					}
				} else{
					$sql_familiar_info = "INSERT INTO familiar_info (ruta_img, familiar_id_fk) VALUES" .
					" ('".$filename."', ". $familiar_id .");";	
				}
				
				$query_result = $connectionManager->connection->query($sql_familiar_info);
				
				if($query_result == TRUE){
					$response["status"] = "OK";
					$response["status_description"] = "";
				} else{
					$response["status"] = "Error";
					$response["status_description"] = "No se pudo ejecutar la insercion / actualizacion de la informacion familiar";
				}					
			} else{
				$response["status"] = "Error";
				$response["status_description"] = "No se pudo subir la imagen al servidor";
			}
			
			return $response;
		}
		
		public function modifyFamiliarConImagen($nombres, $apellidos, $notas){
			$response = array();
			
			$familiar_response = $this->addNuevoFamiliar($nombres, $apellidos, $notas);
			$familiar_id = $familiar_response["familiar_id"];
			
			if($familiar_id != null){
				array_push($response, "familiar_id", $familiar_id);

				//Verifica si trae un archivo para subir
				if(empty($_FILES['file']['name']) == false){
					$filename = $familiar_id . $_FILES['file']['name'];
					$location = '../assets/img/album/';
					
					$response = $familiarService->addImageDescendiente($filename, $location, $familiar_id);
				} else{
					$response = array("status" => "OK");
				}
			} else{
				$response = array("status" => "Error");
			}			
			
			return $response;
		}
		
		
		public function modifyFamiliar($nombres, $apellidos, $notas, $familiar_id){
			$response = null;

			$connectionManager = new ConnectionManager();

			$sql_familiar = "UPDATE familiar SET ".
				" nombres = '".$nombres."', apellidos = '".$apellidos."', notas = '".$notas."'" .
				" WHERE familiar_id = " . $familiar_id;
			

			if($connectionManager->connection->query($sql_familiar)){
				$response = array("status" => "OK");
			} else{
				$response = array("status" => "Error");
			}
			$connectionManager->connection->close();
			
			return $response;
		}		
	}

?>