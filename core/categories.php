<?php

class Categories{
       //db stuff
    private $conn;
    private $table = 'categories';


    //proprities
    public $id;
    public $name;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        $query = 'SELECT * From '.$this->table;
        
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute statement
        $stmt->execute();

        return $stmt;
    }
    public function read_single(){
        $query = 'SELECT name,created_at FROM '.$this->table.
        ' c where c.id= ? LIMIT 1';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //binding param
        $stmt->bindParam(1, $this->id);
        //execute statement
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->created_at = $row['created_at'];

    }
    public function create(){
        $query = 'INSERT INTO '.$this->table.' SET name= :name';

        $stmt = $this->conn->prepare($query);
        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        //binding param
        $stmt->bindParam(':name', $this->name);
        //execute statement
        if($stmt->execute()){
            return true;
        }else{
            printf("ERROR %s \n",$stmt->error);
        }

    }
    public function update(){
        $query = 'UPDATE '.$this->table.
        ' c SET name= :name
        where c.id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        //binding param
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':id',$this->id);
        //execute statement
        if($stmt->execute()){
            return true;
        }else{
            printf("ERROR %s \n",$stmt->error);
            return false;
        }
    }
    public function delete(){
        $query = 'DELETE FROM '.$this->table.' where id= :id';
        //prepare statement
        $stmt = $this->conn->prepare($query);
        //binding param
        $stmt->bindParam(":id",$this->id);
        //execute statement
        if($stmt->execute()){
            return true;
        }else{
            printf("ERROR %s \n",$stmt->error);
            return false;
        }
    }
}
?>