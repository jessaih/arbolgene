<?php

	class FileUtil{
		
		public function addImage($filename, $location){
			$result = false;
			
			$response = array();
			/* Upload file */
			if(move_uploaded_file($_FILES['file']['tmp_name'], $location.$filename)){
				$response['filename'] = $filename;
				$result = true;
			} else{
				$response['name'] = $_FILES["file"]["error"];
			}
			return $result;
		}
		
		public function deleteImage($filename, $location){
			$result = false;
			
			// Use unlink() function to delete a file
			if (!unlink($location.$filename)) {
				error_log(print_r("$filename cannot be deleted due to an error", TRUE)); 
			}
			else {
				$result = true;
			}
			return $result;
		}		
	}

?>