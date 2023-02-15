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