<?php

	class ConnectionManager {
		
		public $connection;
		
		private $servername = "localhost";
		private $username = "root";
		private $password = "admin";
		private $dbname = "arbolgene";
		
		public function __construct(){		
			$this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			mysqli_set_charset($this->connection, "utf8");
			// Check connection
			if ($this->connection->connect_error) {
				die("Connection failed: " . $connection->connect_error);
			}		
		}
	}
?>