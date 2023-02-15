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
		
		public function addNuevoDescendiente(){
			$response = null;

			$connectionManager = new ConnectionManager();
			//Inserta registro en tabla
			$sql_familiar = "INSERT INTO familiar (nombres, apellidos, notas) VALUES" .
			" ( '".$_POST["nombres"]."', '".$_POST["apellidos"]."', '".$_POST["notas"]."');";
			
			if($connectionManager->connection->query($sql_familiar)){
				$familiar_id = $connectionManager->connection->insert_id;
				
				//Inserta registro en tabla
				$sql_descendiente = "INSERT INTO descendiente (pareja_id_fk, familiar_id_fk, numero_hermano) VALUES" .
				" (".$_POST["pareja_id"].", ". $familiar_id .", ".$_POST["numero"].");";
			
				$connectionManager->connection->query($sql_descendiente);
				
				//Verifica si trae un archivo para subir
				if(empty($_FILES['file']['name']) == false){
					$filename = $familiar_id . $_FILES['file']['name'];
					$location = '../assets/img/album/';
					
					//Estableciendo ultimo valor en falso ya que la llamada es desde una actualizacion
					$response = $this->addImageDescendiente($filename, $location, $familiar_id, false);
				} else{
					$response = array("status" => "OK");
				}
			} else{
				$response = array("status" => "Error");
			}			
			
			return $response;
		}
		
		public function modifyNuevoDescendiente(){
			
			$descendiente_id = $_POST['descendiente_id'];
			$descendiente = $this->getDescendienteById($descendiente_id);
			$response = array();
			
			if(count($descendiente) > 0){
				$familiar_id_fk = $descendiente[0]["familiar_id_fk"];
				$connectionManager = new ConnectionManager();
				
				//Actualiza registro en tabla familiar
				$sql_familiar = "UPDATE familiar SET ".
				" nombres = '".$_POST["nombres"]."', apellidos = '".$_POST["apellidos"]."', notas = '".$_POST["notas"]."'" .
				" WHERE familiar_id = " . $familiar_id_fk;
				$connectionManager->connection->query($sql_familiar);
				
				//Actualiza descendiente
				$sql_descendiente = "UPDATE descendiente SET ".
				" numero_hermano = ".$_POST["numero"].
				" WHERE descendiente_id = " . $descendiente_id;
				$connectionManager->connection->query($sql_descendiente);
				
				
				//Verifica si trae un archivo para subir
				if(empty($_FILES['file']['name']) == false){
					//Verifica si hay informacion relacionada al familiar en la tabla famliar_info
					
					$filename = $familiar_id_fk . $_FILES['file']['name'];
					$location = '../assets/img/album/';
					
					//Estableciendo ultimo valor en falso ya que la llamada es desde una actualizacion
					$response = $this->addImageDescendiente($filename, $location, $familiar_id_fk, false);
				}  else{
					$response = array("status" => "OK");
				}
			}
			else{
				$response = array("status" => "Error");
			}			
			
			return $response;
		}
		
		public function deleteDescendiente(){
			$familiarService = new FamiliarService();
			$descendiente_id = $_GET['descendiente_id'];
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
		
		/* 	Método usado por creacion y actualizacion de descendiente, el ultimo parametro es para diferenciar
			Si se hace una consulta a la tabla de familiar_info
		*/
		
		private function addImageDescendiente($filename, $location, $familiar_id, $callFromInsert){
			
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
						$result["status_file"] = "OK";
					} else{
						$result["status_file"] = "Error";
					}
				} else{
					$sql_familiar_info = "INSERT INTO familiar_info (ruta_img, familiar_id_fk) VALUES" .
					" ('".$filename."', ". $familiar_id .");";	
				}
				
				$query_result = $connectionManager->connection->query($sql_familiar_info);
				
				if($query_result == TRUE){
					$response = array("status" => "OK");
				} else{
					$response = array("status" => "Error");
				}
			} else{
				$response = array("status" => "Error");
			}
			
			return $response;
		}		
	}

?> 
