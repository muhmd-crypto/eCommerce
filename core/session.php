<?php
class SESSION{
    private $conn;
    private $table='session';

    public $session_id;
    public $user_ip;
    public $logged_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_single()
    {
        $query = 'SELECT * FROM '.$this->table.' s where s.session_id=? LIMIT 1';

        $stmt = $this->conn->prepare($query);

        $this->session_id = htmlspecialchars(strip_tags($this->session_id));

        $stmt->bindParam(1,$this->session_id);

        $stmt->execute();

        $num = $stmt->rowCount();
        if($num>0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->session_id = $row['session_id'];
            $this->user_ip = $row['user_ip'];
            $this->logged_at = $row['logged_at'];
            
            return true;
        }
        else
        {
            // printf("ERROR %s /n",$stmt->errorInfo);
            return false;
        }
    }


    public function create()
    {
        $query = 'INSERT INTO '.$this->table.' SET session_id=:session_id, user_ip=:user_ip';

        $stmt = $this->conn->prepare($query);

        $this->session_id = htmlspecialchars(strip_tags($this->session_id));
        $this->user_ip = htmlspecialchars(strip_tags($this->user_ip));

        $stmt->bindParam(':session_id',$this->session_id);
        $stmt->bindParam(':user_ip',$this->user_ip);

        if($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>