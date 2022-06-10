<?php

class CART{
    private $conn;
    private $table='cart';

    public $cart_id;
    public $session_id;
    public $product_id;
    public $product_name;
    public $product_image;
    public $product_l_image;
    public $P_Now;
    public $model_nb;
    public $quantity;
    public $Total;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = 'SELECT * from '.$this->table.' c where c.session_id=?';
        $stmt = $this->conn->prepare($query);

        $this->session_id = htmlspecialchars(strip_tags($this->session_id));

        $stmt->bindParam(1,$this->session_id);

        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        $query = 'SELECT quantity,Total,P_Now FROM '.$this->table.' c where c.session_id=:session_id AND c.product_id=:product_id';
        $stmt = $this->conn->prepare($query);

        $this->session_id = htmlspecialchars(strip_tags($this->session_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));

        $stmt->bindParam(":session_id",$this->session_id);
        $stmt->bindParam(":product_id",$this->product_id);

        $stmt->execute();
        $num = $stmt->rowCount();

        if($num>0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->quantity += $row['quantity'];
            $this->Total = ($this->quantity)*($this->P_Now);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function quantity_read_single()
    {
        $query = 'SELECT P_Now FROM '.$this->table.' c where c.session_id= :session_id AND c.product_id= :product_id LIMIT 1';
        $stmt = $this->conn->prepare($query);

        $this->session_id = htmlspecialchars(strip_tags($this->session_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));

        $stmt->bindParam(":session_id",$this->session_id);
        $stmt->bindParam(":product_id",$this->product_id);

        $stmt->execute();
        $num = $stmt->rowCount();

        if($num>0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->P_Now = $row['P_Now'];
            return true;
        }
        else
        {
            //print_r($stmt->errorInfo());
            return false;
        }
    }


    public function create()
    {
        $query = 'INSERT INTO '.$this->table.' SET session_id=:session_id,
        product_id=:product_id,product_name=:product_name,
        product_image=:product_image,product_l_image=:product_l_image,
        P_Now=:P_Now,model_nb=:model_nb, quantity=:quantity, Total=:Total';

        $stmt = $this->conn->prepare($query);

        $this->session_id = htmlspecialchars(strip_tags($this->session_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->product_image = htmlspecialchars(strip_tags($this->product_image));
        $this->product_l_image = htmlspecialchars(strip_tags($this->product_l_image));
        $this->P_Now = htmlspecialchars(strip_tags($this->P_Now));
        $this->model_nb = htmlspecialchars(strip_tags($this->model_nb));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->Total = htmlspecialchars(strip_tags($this->Total));

        $stmt->bindParam(":session_id",$this->session_id);
        $stmt->bindParam(":product_name",$this->product_name);
        $stmt->bindParam(":product_id",$this->product_id);
        $stmt->bindParam(":product_image",$this->product_image);
        $stmt->bindParam(":product_l_image",$this->product_l_image);
        $stmt->bindParam(":P_Now",$this->P_Now);
        $stmt->bindParam(":model_nb",$this->model_nb);
        $stmt->bindParam(":quantity",$this->quantity);
        $stmt->bindParam(":Total",$this->Total);

        if($stmt->execute())
        {
            return true;
        }
        else
        {
            printf("ERROR %s /n",$stmt->error);
            return false;
        }
    }

    public function update_quantity()
    {
        $query = 'UPDATE '.$this->table.' c SET c.quantity=:quantity,c.Total=:Total where c.session_id=:session_id AND c.product_id=:product_id';
        
        $stmt = $this->conn->prepare($query);

        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->Total = htmlspecialchars(strip_tags($this->Total));
        $this->session_id = htmlspecialchars(strip_tags($this->session_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));

        $stmt->bindParam(":quantity",$this->quantity);
        $stmt->bindParam(":Total",$this->Total);
        $stmt->bindParam(":session_id",$this->session_id);
        $stmt->bindParam(":product_id",$this->product_id);

        if($stmt->execute())
        {
            return true;
        }
        else
        {
            //printf("ERROR %s /n",$stmt->error);
            return false;
        }

    }
    public function delete()
    {
        $query = 'DELETE FROM '.$this->table.' where session_id=:session_id AND product_id=:product_id';

        $stmt = $this->conn->prepare($query);

        $this->session_id = htmlspecialchars(strip_tags($this->session_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));

        $stmt->bindParam(":session_id",$this->session_id);
        $stmt->bindParam(":product_id",$this->product_id);

        if($stmt->execute())
        {
            return true;
        }
        else
        {
            printf("ERROR %s /n",$stmt->error);
            return false;
        }
    }
}