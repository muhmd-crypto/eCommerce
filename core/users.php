<?php

class USER{
    private $conn;
    private $table = 'users';

    public $user_id;
    public $fullName;
    public $email;
    public $username;
    public $password;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){

        $query = 'SELECT * FROM '.$this->table.' ORDER BY user_id DESC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;

    }
    public function read_by_id(){

        $query = 'SELECT * FROM '.$this->table.' u where u.user_id=?';

        $stmt = $this->conn->prepare($query);
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $stmt->bindParam(1,$this->user_id);

        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function read_single(){

        $query = ' SELECT * FROM '.$this->table.'
        where email= :email and password= :password';

        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':password',$this->password);

        $stmt->execute();

        $num = $stmt->rowCount();
        if($num > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->user_id = $row['user_id'];
            $this->username = $row['username'];
            return true;
        }
        else{
            return false;
        }

    }

    public function create(){

        $query = 'INSERT INTO '.$this->table.' SET fullName=:fullName,
        email=:email, username=:username, 
        password=:password';

        $stmt = $this->conn->prepare($query);

        $this->fullName = htmlspecialchars(strip_tags($this->fullName));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':fullName',$this->fullName);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':username',$this->username);
        $stmt->bindParam(':password',$this->password);

        if($stmt->execute()){
            return true;
        }    
        else{
            printf("FAILED %s \n", $stmt->error);
            return false;
        }
    }

    public function update(){

        $query = 'UPDATE '.$this->table.' u SET fullName=:fullName,
        email=:email, username=:username,
        password=:password
        where c.user_id=:user_id';

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->fullName = htmlspecialchars(strip_tags($this->fullName));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':user_id',$this->user_id);
        $stmt->bindParam(':fullName',$this->fullName);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':username',$this->username);
        $stmt->bindParam(':password',$this->password);
        

        if($stmt->execute()){
            return true;
        }
        else{
            printf("FAILED %s \n", $stmt->error);
            return false;
        }
    }

    public function delete(){

        $query = 'DELETE FROM '.$this->table.' u where u.user_id=:user_id';
        
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->$user_id));

        $stmt->bindParam(':user_id', $this->user_id);

        if($stmt->execute()){
            return true;
        }
        else{
            printf("FAILED %s \n", $stmt->error);
            return false;
        }
    }
}
?>