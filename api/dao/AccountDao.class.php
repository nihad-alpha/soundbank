<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AccountDao extends BaseDao {
    public function get_account_by_id($id) {
        return $this->query_unique("SELECT * FROM accounts WHERE account_id = :id", ["id" => $id]);
    }

    public function get_account_by_username($username) {
        return $this->query_unique("SELECT * FROM accounts WHERE username = :username", ["username" => $username]);
    }

    public function add_account($params) {
        $insert_query = "INSERT INTO accounts (username, password, account_type_id) VALUES (:username, :password, :account_type_id)";
        $this->connection->prepare($insert_query)->execute($params);
    }

    public function update_account($id, $account) {
        $query = "UPDATE accounts SET ";
        foreach($account as $name => $value) {
            $query .= " " .$name ." = :". $name .", ";
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE account_id = :account_id";
        $account['account_id'] = $id;
        echo $query;
        echo "</br>";
        /*$update_query = "UPDATE accounts SET username=:username, password=:password, account_type_id=:account_type_id WHERE account_id=:account_id";*/
        $stmt= $this->connection->prepare($query);
        $stmt->execute($account);
    }
}

?>