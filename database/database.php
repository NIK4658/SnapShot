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
    public function create_post($username, $description, $device, $location){
        //Calculed numbers of id
        $query = "SELECT id FROM POST WHERE username = ? ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        //if 0 create new post with id=0 else id=MAX(id)+1
        if($result->num_rows == 0){
            $id = 1;
            $query = "INSERT INTO POST (username, id) VALUES (?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $username, $id);
        } else {
            $query = "INSERT INTO POST (id, username) SELECT MAX(id)+1, ? FROM POST WHERE username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $username, $username);
        }
        $stmt->execute();

        //Return id post created
        $query = "SELECT MAX(id) FROM POST WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_row()[0];
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
