 <?php
 	require '../db/ConnectionManager.php';
	require '../util/FileUtil.php';

	class ArbolGenealogicoService{
		
		//public function __construct(){}
		
		public function getDetalleFamilia($pareja_id){
			$connectionManager = new ConnectionManager();
			
			$sql_pareja = "SELECT p.pareja_id as pareja_id,
					f_esposa.familiar_id as ea_id, f_esposa.nombres as nom_ea, f_esposa.apellidos as ape_ea, f_esposa.notas as notas_ea,
					f_esposo.familiar_id as eo_id, f_esposo.nombres as nom_eo, f_esposo.apellidos as ape_eo, f_esposo.notas as notas_eo
					FROM pareja p 
					inner join familiar f_esposa on f_esposa.familiar_id = p.esposa_id_fk
					inner join familiar f_esposo on f_esposo.familiar_id = p.esposo_id_fk
					where p.pareja_id = ". $pareja_id .";";
			$result_pareja = $connectionManager->connection->query($sql_pareja);


			$sql_pareja_info = "SELECT pi.pareja_info_id, pi.ruta_img, pi.notas 
					FROM pareja_info pi
					where pi.pareja_id_fk = ". $pareja_id .";";
			$result_pareja_info = $connectionManager->connection->query($sql_pareja_info);

			$connectionManager->connection->close();
			//create an array
			
			$pareja_info = array();
			$pareja = array();
			$descendientes = $this->getDescendientes($pareja_id);
			
			if ($result_pareja_info->num_rows > 0){
				while ($row_pareja_info = $result_pareja_info->fetch_assoc()){ 	
					$pareja_info[] = $row_pareja_info;
				}
			}
			
			
			if ($result_pareja->num_rows > 0){
				if($row_pareja = $result_pareja->fetch_assoc()){
					$pareja[] = $row_pareja;					
				}
			}
						
			
			$response = array(
				"pareja" => $pareja,
				"pareja_info" => $pareja_info,
				"descendientes" => $descendientes
			);
			
			return $response; 
		}
		
		public function getDescendientes($pareja_id){
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
				$index = 1;
				while($row_descendientes = $result_descendientes->fetch_assoc()){
					$descendientes[] = $row_descendientes;
				}
			}
			return $descendientes;
		}
		
		public function addNuevoDescendiente(){
			$response = null;

			$fileUtil = new FileUtil();

			$connectionManager = new ConnectionManager();
			$sql_familiar = "INSERT INTO familiar (nombres, apellidos, notas) VALUES" .
			" ( '".$_POST["nombres"]."', '".$_POST["apellidos"]."', '".$_POST["notas"]."');";
			
			if($connectionManager->connection->query($sql_familiar)){
				$familiar_id = $connectionManager->connection->insert_id;
				
				$sql_descendiente = "INSERT INTO descendiente (pareja_id_fk, familiar_id_fk, numero_hermano) VALUES" .
				" (".$_POST["pareja_id"].", ". $familiar_id .", ".$_POST["numero"].");";
			
				$connectionManager->connection->query($sql_descendiente);
				
				$filename = $familiar_id . $_FILES['file']['name'];
				$location = '../assets/img/album/';
				
				if($fileUtil->addImage($filename, $location)){
					$sql_familiar_info = "INSERT INTO familiar_info (ruta_img, familiar_id_fk) VALUES" .
					" ('".$filename."', ". $familiar_id .");";
			
				$connectionManager->connection->query($sql_familiar_info);	
				} else{
					$response = array("result" => "error");
				}
				
				$response = array("result" => "success");
			} else{
				$response = array("result" => "error");
			}					
			

			return $response;
		}
	}

?> 