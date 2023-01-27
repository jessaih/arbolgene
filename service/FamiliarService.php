<?php

	require_once '../db/ConnectionManager.php';

	class FamiliarService{
		
		//public function __construct(){}
		
		public function getDescendiente($descendiente_id){
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
	}

?>