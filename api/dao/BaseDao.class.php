<?php 
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/../config.php";

    class BaseDao {

        protected $connection;
        private $_table;

        public static function parse_order($order) {
            switch(substr($order, 0, 1)) {
                case '-':
                    $order_direction = "ASC";
                    break;
                case '+':
                    $order_direction = "DESC";
                    break;
                default: 
                    throw new Exception("Invalid order argument. - or + need to be used.");
            }

            $order_column = substr($order, 1);
            // Investigate SQL injection
            //$order_column = $this->connection->quote(substr($order, 1));

            return [$order_column, $order_direction];
        }

        protected function __construct($_table) {
            $this->_table = $_table;
            try {
                $this->connection = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                throw $e;
            }
        }

        // Inserting.
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

                $this->connection->prepare($query)->execute($params);
                $params['id'] = $this->connection->lastInsertId();
                return $params;
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        // Inserting function allowed publicly.
        public function add($params) {
            $this->insert($this->_table, $params);
        }

        // Updating.
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

        // Sending a query with it's parameters.
        protected function query($query, $params) {
            try {
                $stmt = $this->connection->prepare($query);
                $stmt->execute($params); 
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        // Sending a query for unique entries in the database.
        protected function query_unique($query, $params) {
            $result = $this->query($query, $params);
            return reset($result);
        }

        // Getting all data from a table in the database using offset and limit.
        public function get_all($offset = 0, $limit = 25, $order = "-id") {
            list($order_column, $order_direction) = self::parse_order($order);
            
            return $this->query("SELECT * FROM ". $this->_table . " ORDER BY ". $order_column . " " . $order_direction . " LIMIT ${limit} OFFSET ${offset}", []);
        }

        // Getting an entity by an id.
        public function get_by_id($id) {
            return $this->query_unique("SELECT * FROM " . $this->_table . " WHERE id = :id", ["id" => $id]);
        }

        // Searching by name.
        public function search_by_name($search, $offset = 0, $limit = 25, $order = "-id") {
            list($order_column, $order_direction) = self::parse_order($order);
            
            return $this->query("SELECT * FROM ". $this->_table . " 
                                WHERE LOWER(name) LIKE CONCAT('%', :name,'%') 
                                ORDER BY ". $order_column . " " . $order_direction. "
                                LIMIT ${limit} OFFSET ${offset}", ["name" => strtolower($search)]);
        }

        // Updating an entity by an id.
        public function update_by_id($id, $params) {
            $this->update($this->_table, "id", $id, $params);
        }
    }
?>