<?php 
require_once dirname(__FILE__)."/../config.php";

    class BaseDao {

        protected $connection;
        private $_table;

        protected function __construct($_table) {
            $this->_table = $_table;
            try {
                $this->connection = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                throw $e;
            }
        }

        protected function insert($table, $params) {
            try {
                $query = "INSERT INTO ${table} (";
                foreach($params as $name => $values) {
                    $query .= " " .$name .",";
                }
                $query = substr($query, 0, -1);
                $query .= ") VALUES (";
                foreach($params as $name => $values) {
                    $query .= " :" .$name .",";
                }
                $query = substr($query, 0, -1);
                $query .= ")";
                echo $query;
                echo "</br>";

                $this->connection->prepare($query)->execute($params);
                $params['id'] = $this->connection->lastInsertId();
                return $params;
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public function add($params) {
            return insert($this->_table, $params);
        }

        protected function update($table, $field, $field_value, $params) {
            $query = "UPDATE ${table} SET ";
            foreach($params as $name => $value) {
                $query .= " " .$name ." = :". $name .", ";
            }
            $query = substr($query, 0, -2);
            $query .= " WHERE ${field} = :${field}";
            $params["${field}"] = $field_value;
            $stmt= $this->connection->prepare($query);
            $stmt->execute($params);
        }

        protected function query($query, $params) {
            try {
                $stmt = $this->connection->prepare($query);
                $stmt->execute($params); 
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            echo $query;
        }

        protected function query_unique($query, $params) {
            $result = $this->query($query, $params);
            return reset($result);
        }

        protected function get_all($offset = 0, $limit = 25) {
            return $this->query("SELECT * FROM ". $this->_table . " LIMIT ${limit} OFFSET ${offset}", []);
        }
    }
