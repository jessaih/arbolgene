<?php

	class FileUtil{
		
		public function addImage($filename, $location){
			$result = false;
			
			/* Location */


			$response = array();
			/* Upload file */
			if(move_uploaded_file($_FILES['file']['tmp_name'],$location.$filename)){
				$response['filename'] = $filename;
				$result = true;
			} else{
				$response['name'] = $_FILES["file"]["error"];
			}
			return $result;
		}
	}

?>