 <?php
	require_once '../db/ConnectionManager.php';
	require '../util/FileUtil.php';
	require 'FamiliarService.php';

	class DescendienteService{
		
		public function getDetalleDescendientes($pareja_id){
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
					where d.pareja_id_fk = ". $pareja_id ."
					order by numero_hermano;";
			$result_descendientes = $connectionManager->connection->query($sql_descendientes);
			
			$connectionManager->connection->close();
			
			if ($result_descendientes->num_rows > 0){
				while($row_descendientes = $result_descendientes->fetch_assoc()){
					$descendientes[] = $row_descendientes;
				}
			}
			return $descendientes;
		}
		
		public function getDescendienteById($descendiente_id){
			$connectionManager = new ConnectionManager();
			$descendiente = array();			
			
			$sql_descendiente_info = "SELECT *
					FROM descendiente d
					WHERE d.descendiente_id = ". $descendiente_id .";";
			$result_descendiente_info = $connectionManager->connection->query($sql_descendiente_info);
			
			$connectionManager->connection->close();
			
			if ($result_descendiente_info->num_rows > 0){
				while($row_descendiente = $result_descendiente_info->fetch_assoc()){
					$descendiente[] = $row_descendiente;
				}
			}
			return $descendiente;
		}
		
		public function addNuevoDescendiente($nombres, $apellidos, $notas, $pareja_id, $numero_hijo){
			$response = array();
			
			$familiarService = new FamiliarService();
			$familiar_response = $familiarService->addNuevoFamiliarConImagen($nombres, $apellidos, $notas);
			error_log(print_r("Desc Serv ", TRUE)); 
			error_log(print_r($familiar_response, TRUE)); 

			if($familiar_response["status"] == "OK"){
				$familiar_id = $familiar_response["familiar_id"];
				
				$connectionManager = new ConnectionManager();
				//Inserta registro en tabla
				$sql_descendiente = "INSERT INTO descendiente (pareja_id_fk, familiar_id_fk, numero_hermano) VALUES" .
				" (".$pareja_id.", ". $familiar_id .", ".$numero_hijo.");";
			
				if($connectionManager->connection->query($sql_descendiente)){
					$status["status"] = "OK";
					$status["status_description"] = "";				
				} else{
					$response["status"] = "Error";
					$response["status_description"] = "Ocurrio un error con la creacion del descendiente ";
				}
				$connectionManager->connection->close();
			} else{
				$response["status"] = "Error";
				$response["status_description"] = "Ocurrio un error con la creacion del familiar ";
			}			
			
			return $response;
		}
		
		public function modifyDescendiente($nombres, $apellidos, $notas, $descendiente_id, $numero_hijo){

			$descendiente = $this->getDescendienteById($descendiente_id);
			$response = array();
			
			if(count($descendiente) > 0){
				$familiar_id_fk = $descendiente[0]["familiar_id_fk"];
				$connectionManager = new ConnectionManager();
				$familiarService = new FamiliarService();
				//Actualiza registro en tabla familiar
				$familiar_response = $familiarService->modifyFamiliar($nombres, $apellidos, $notas, $familiar_id_fk);
				
				//Actualiza descendiente
				$sql_descendiente = "UPDATE descendiente SET ".
				" numero_hermano = ".$numero_hijo.
				" WHERE descendiente_id = " . $descendiente_id;
				$connectionManager->connection->query($sql_descendiente);
				$connectionManager->connection->close();
				
				//Verifica si trae un archivo para subir
				if(empty($_FILES['file']['name']) == false){
					//Verifica si hay informacion relacionada al familiar en la tabla famliar_info
					
					$filename = $familiar_id_fk . $_FILES['file']['name'];
					$location = '../assets/img/album/';
					
					$response = $familiarService->addImageDescendiente($filename, $location, $familiar_id_fk);
				}  else{
					$status["status"] = "OK";
					$status["status_description"] = "";
				}
			}
			else{
				$response["status"] = "Error";
				$response["status_description"] = "El registro que se desea actualizar no existe ";
			}			
			
			return $response;
		}
		
		public function deleteDescendiente($descendiente_id){
			$familiarService = new FamiliarService();
			$descendiente = $this->getDescendienteById($descendiente_id);
			$result = array();
			
			if(count($descendiente) > 0){
				$connectionManager = new ConnectionManager();				
				
				$familiar_id_fk = $descendiente[0]["familiar_id_fk"];
				
				//Verifica si hay informacion relacionada al familiar en la tabla famliar_info
				$familiar_info = $familiarService->getFamiliarInfo($familiar_id_fk);

				if(count($familiar_info) > 0){

					$sql_delete_familiar_info = " DELETE FROM familiar_info 
						WHERE familiar_id_fk = ". $familiar_id_fk ."";
					$result_delete_familiar_info = $connectionManager->connection->query($sql_delete_familiar_info);
					
					$fileUtil = new FileUtil();

					$filename = $familiar_info[0]["ruta_img"];
					$location = '../assets/img/album/';
					
					if($result_delete_familiar_info == TRUE && $fileUtil->deleteImage($filename, $location)){
						$result["status_file"] = "OK";
					} else{
						$result["status_file"] = "Error";
					}
				}
				
				$sql_delete_descendiente = " DELETE FROM descendiente 
						WHERE descendiente_id = ". $descendiente_id ."";
				$result_delete_descendiente = $connectionManager->connection->query($sql_delete_descendiente);
				//error_log(print_r($sql_delete_descendiente, TRUE)); 
					
				$sql_delete_familiar = " DELETE FROM familiar 
						WHERE familiar_id = ". $familiar_id_fk ."";
				$result_delete_familiar = $connectionManager->connection->query($sql_delete_familiar);
				
				$connectionManager->connection->close();
				
				if ($result_delete_descendiente == TRUE && $result_delete_familiar == TRUE){
					$result["status"] = "OK";
				} else{
					$result["status"] = "Error";
				}	
			} else{
				$result = array("status" => "Error");
				//throw new InvalidArgumentException('Please enter a valid username');
			}
			
			return $result;
		}		
		

	}

?> 
