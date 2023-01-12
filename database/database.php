<?php
class DatabaseHelper
{
    private $db;
    public function __construct($servername, $username, $password, $dbname)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname);
        if ($this->db->connect_error) {
            die("Connection failed: " .$this->db->connect_error);
        } else {
            $this->db->set_charset("utf8");
        }
    }

    public function executeQuery($query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllEntries()
    {
        return $this->executeQuery("SELECT * FROM TABLENAME");
    }
}
?>