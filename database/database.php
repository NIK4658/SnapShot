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

    public function create_account($username, $password){
        $query = "INSERT INTO ACCOUNT (username, password) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss',$username, $password);
        $stmt->execute();
        return $stmt->insert_id;
    }

//PROFILO
    public function get_account($username){
        $stmt = $this->db->prepare("SELECT * FROM ACCOUNT WHERE username = ?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function get_account1(){
        $stmt = $this->db->prepare("SELECT * FROM ACCOUNT");
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

    public function get_icon($username){
        $stmt = $this->db->prepare("SELECT icon FROM ACCOUNT WHERE username = ?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function get_bio($username){
        $stmt = $this->db->prepare("SELECT bio FROM ACCOUNT WHERE username = ?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function get_n_posts($username){
        $stmt = $this->db->prepare("SELECT n_posts FROM ACCOUNT WHERE username = ?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function get_n_followers($username){
        $stmt = $this->db->prepare("SELECT n_followers FROM ACCOUNT WHERE username = ?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function get_n_following($username){
        $stmt = $this->db->prepare("SELECT n_following FROM ACCOUNT WHERE username = ?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    //aggiungere description, device, location
    //Return id if post created, else -1
    public function create_post($username, $description, $device, $location){
        //Calculate id
        $query = "SELECT MAX(id) FROM POST WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $id = $result->fetch_row()[0];
        var_dump($id);//da togliere
        if($id == null){
            $id = 1;
        } else {
            $id++;
        }
        //Insert post with calculated id
        $query = "INSERT INTO POST (username, id) VALUES (?,?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $username, $id);
        if (!$stmt->execute()){
            return -1;
        }
        //Increment n posts in profile
        $query = "UPDATE ACCOUNT SET n_posts = n_posts + 1 WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        if (!$stmt->execute()){
            return -1;
        }
        return $id;
    }

    //NON TESTATA
    //Return true if post deleted, else false
    public function delete_post($username,$id){
        $query = "DELETE FROM `POST` WHERE username = ? AND id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $username, $id);
        $stmt->execute();
        if (!$stmt->execute()){
            return false;
        }
        $query = "UPDATE ACCOUNT SET n_posts = n_posts - 1 WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        return true;
    }








    /*
     //NON TESTATA MA DOVREBBE FUNZIONARE
     public function get_last_n_images_posts($username, $n){
        get_last_n_images_posts_from($username, $n, 1);
    }

    //NON TESTATA MA DOVREBBE FUNZIONARE
    public function get_last_n_images_posts_from($username, $n, $i){
        $query = "SELECT id FROM POST WHERE id BETWEEN ? AND ? ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $i, $i+$n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    */
}
?>
