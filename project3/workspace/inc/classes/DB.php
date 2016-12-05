<?php
	class DB {
		private static $_instance =  null;
		private $_pdo, $_query, $_error = false, $_count=0;
		public $_results;


		private function __construct() {

			try{
				$this->_pdo = new PDO('mysql:host='. Config::get('mysql/host') .';dbname='. Config::get('mysql/db'),Config::get('mysql/username'), Config::get('mysql/password'));
			}
			catch(PDOExecption $e){
				echo 'Something was wrong with the connection';
				die($e->getMessage());
			}
		}


		public static function getInstance() {
			if(!isset(self::$_instance)) {
				self::$_instance = new DB();
			}
			return self::$_instance;
		}

		public function query($sql, $params = array()) {
			$this->_error = false;

			if(empty($params)) {
				$sql .= ' ORDER BY `date_sent` DESC LIMIT 10';
			}

			if ($this->_query = $this->_pdo->prepare($sql)) {
				$x = 1;
				if (count($params)) {
					foreach ($params as $param) {
						$this->_query->bindValue($x, $param);
						$x++;
					}
				}
				echo $sql;
				if($this->_query->execute()) {
					$this->_results = $this->_query->fetchAll();
					$this->_count = $this->_query->rowCount();
				}
				else {
					$this->_error = true;
				}
			}

			return $this;
		}

		public function action($action, $table, $where = array()) {
			if(count($where)) {
				if(count($where) === 3) {
					$operators = array('=', '>', '<', '>=', '<=');

					$field = $where[0];
					$operator = $where[1];
					$value = $where[2];

					if(in_array($operator, $operators))
					{
						$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
						if (!$this->query($sql, array($value))->error()) {
							return $this;
						}
						else {
							return false;
						}
					}
				}
			}
			else {
				$sql = "{$action} FROM {$table}";
				if (!$this->query($sql)->error()) {
					return $this;
				}
				else {
					return false;
				}
			}
		}

		public function get($table, $where = array()) {
			if(count($where)) {
				return $this->action('SELECT *', $table, $where);
			}
			else {
				return $this->action('SELECT *', $table);
			}
		}



		public function insert($table, $fields = array()) {
			if(count($fields)) {
				$keys = array_keys($fields);
				$values = '';
				$x = 1;

				foreach ($fields as $field) {
					$values .= "'" . $field . "'";

					if($x < count($fields)) {
						$values .= ', ';
					}
					$x++;
				}


				$sql = "INSERT INTO {$table} (`". implode('`, `', $keys) ."`) VALUES ({$values})";

				if(!$this->query($sql, $fields)->error()) {
					return true;
				}
			}
			return false;
		}

		

		public function results() {
			return $this->_results;
		}

		public function first() {
			return $this->results()[0];
		}

		public function error() {
			return $this->_error;
		}

		public function count() {
			return $this->_count;
		}
	}
?>
