<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname){
        $this->db = new mysqli($servername, $username, $password, $dbname);
        if ($this->db->connect_error) {
            die("Connection failed: " .$this->db->connect_error);
        } else {
            $this->db->set_charset("utf8");
        }
    }


    public function get_account($username){
        $stmt = $this->db->prepare("SELECT * FROM ACCOUNT WHERE username = ?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function get_password($username){
        $stmt = $this->db->prepare("SELECT password FROM ACCOUNT WHERE username = ?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createAccount($username, $password){
        $query = "INSERT INTO ACCOUNT (username, password) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss',$username, $password);
        $stmt->execute();
        return $stmt->insert_id;
    }






}
?>