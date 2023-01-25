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


//PROFILO
    public function create_account($username, $password){
        $query = "INSERT INTO ACCOUNT (username, password) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss',$username, $password);
        $stmt->execute();
        return $stmt->insert_id;
    }

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


//POST
    //Return id if post created, else -1
    public function create_post($username, $description, $device, $location){
        //Create new device if not exists
        if (empty($device)) {
            $device = NULL;
        } else {
            $query = "INSERT INTO DEVICE (name) VALUES (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $device);
            $stmt->execute();
        }
        //Create new location if not exists
        if (empty($location)) {
            $location = NULL;
        } else {
            $query = "INSERT INTO LOCATION (name) VALUES (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $location);
            $stmt->execute();
        }
        //Calculate id
        $query = "SELECT MAX(id) FROM POST WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $id = $result->fetch_row()[0];
        if($id == null){
            $id = 1;
        } else {
            $id++;
        }
        //Insert post with calculated id
        $query = "INSERT INTO POST (username, id, description, device, location) VALUES (?,?,?,?,?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sisss', $username, $id, $description, $device, $location);
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

    //Return n last post from i (not included), n>0 and i=>0
    public function get_last_n_posts_from($username, $n, $i){
        $query = "SELECT * FROM POST WHERE username = ? ORDER BY date DESC LIMIT ? OFFSET ?";//ritornare solo id?
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sii', $username, $n, $i);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Return post specified by username and id
    public function get_post($username, $id){
        $query = "SELECT * FROM POST WHERE username = ? AND id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $username, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Return post's loves
    public function get_love_post($username_post, $id_post){
        $query = "SELECT * FROM LOVE_POST  WHERE username_post = ? AND id_post = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $username_post, $id_post);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


//COMMENT
    //DA TESTARE
    //Return id comment or -1 if error
    public function create_comment1($user_post, $id_post, $user_comm, $comm){
        //Calculate id
        $query = "SELECT MAX(id) FROM COMMENT1 WHERE username_post = ? AND id_post = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $user_post, $id_post);
        $stmt->execute();
        $result = $stmt->get_result();
        $id = $result->fetch_row()[0];
        if($id == null){
            $id = 1;
        } else {
            $id++;
        }
        //Insert comment with calculated id
        $query = "INSERT INTO COMMENT1 (username_post, id_post, username, comment, id) VALUES (?, ?, ?, ?, ? )";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sissi', $user_post, $id_post, $user_comm, $comm, $id);
        if (!$stmt->execute()){
            return -1;
        }
        //Increment n comments in post
        $query = "UPDATE POST SET n_comments = n_comments + 1 WHERE username = ? AND id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $user_post, $id_post);
        return $id;
    }

    //DA TESTARE
    //Return n last comment1 from i (not included), n>0 and i=>0
    public function get_last_n_comments1_from($username, $id, $n, $i){
        $query = "SELECT * FROM COMMENT1 WHERE username = ? AND id_post = ? ORDER BY date DESC LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('siii', $username, $id, $n, $i);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //DA TESTARE
    //Add love in the comment and return true, if already love, remove love and return false
    public function love_comment1($username_post, $id_post, $id_comment, $username){
        //Check if there is already love
        $query = "SELECT COUNT(*) FROM LOVE_COMMENT1 WHERE username_post = ? AND id_post = ? AND id_comment1 = ? AND username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('siis', $username_post, $id_post, $id_comment, $username);
        $stmt->execute();
        if ($stmt->get_result()->fetch_row()[0] == 0){
            //Add the love
            $query = "INSERT INTO LOVE_COMMENT1 VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('siis', $username_post, $id_post, $id_comment, $username);
            $stmt->execute();
            return true;
        } else {
            //Remove the love
            $query = "DELETE FROM LOVE_COMMENT1 WHERE username_post = ? AND ? AND ? AND username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('siis', $username_post, $id_post, $id_comment, $username);
            $stmt->execute();
            return false;
        }
    }


//FOLLOW
    //DA TESTARE
    //Username1 follows username2
    public function follow($username1, $username2){
        //Do follow
        $query = "INSERT INTO FOLLOWER (follower, username) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $username1, $username2);
        if (!$stmt->execute()){
            return false;
        }
        //Increment user1 following
        $query = "UPDATE ACCOUNT SET n_following = n_following + 1 WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username1);
        $stmt->execute();
        //Increment user2 followers
        $query = "UPDATE ACCOUNT SET n_followers = n_followers + 1 WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username2);
        $stmt->execute();
        return true;
    }
    
    //DA TESTARE
    //Username1 unfollows username2
    public function unfollow($username1, $username2){
        //Do unfollow
        $query = "DELETE FROM FOLLOWER WHERE follower = ? AND username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $username1, $username2);
        if (!$stmt->execute()){
            return false;
        }
        //Decrement user1 following
        $query = "UPDATE ACCOUNT SET n_following = n_following - 1 WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username1);
        $stmt->execute();
        //Decrement user2 followers
        $query = "UPDATE ACCOUNT SET n_followers = n_followers - 1 WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username2);
        $stmt->execute();
        return true;
    }

    //DA TESTARE
    //Return true if username1 is following username2
    public function is_following($username1, $username2){
        $query = "SELECT COUNT(*) FROM FOLLOWER WHERE follower = ? AND username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $username1, $username2);
        $stmt->execute();
        if ($stmt->get_result()->fetch_row()[0] == 0){
            return false;
        }
        return true;
    }



}
?>
