<?php 
require_once dirname(__FILE__)."/../config.php";

    class BaseDao {
        protected $connection;
        public function __construct() {
            try {
                $this->connection = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                throw $e;
            }
        }

        public function insert($table, $params) {
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
        }

        public function update($table, $field, $field_value, $params) {
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

        public function query($query, $params) {
            try {
                $stmt = $this->connection->prepare($query);
                $stmt->execute($params); 
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public function query_unique($query, $params) {
            $result = $this->query($query, $params);
            return reset($result);
        }
    }
