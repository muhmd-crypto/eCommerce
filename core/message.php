<?php
class MESSAGE{

    private $conn;
    private $table='contact_us';

    public $Name;
    public $Email;
    public $Message;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function create()
    {
        $query = 'Insert INTO '.$this->table.' SET Name=:Name, Email=:Email, Message=:Message';
        $stmt = $this->conn->prepare($query);

        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Message = htmlspecialchars(strip_tags($this->Message));

        $stmt->bindParam(":Name",$this->Name);
        $stmt->bindParam(":Email",$this->Email);
        $stmt->bindParam(":Message",$this->Message);

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