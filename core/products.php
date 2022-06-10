<?php

class PRODUCT{
    //db stuff
    private $conn;
    private $table='products';

    //post proprties
    public $id;
    public $category_id;
    public $category_name;
    public $product_id;
    public $product_name;
    public $model_nb;
    public $puff;
    public $quantity;
    public $P_Was;
    public $P_Now;
    public $saving_percentage;
    public $description;
    public $l_description;
    public $image;
    public $l_image;
    public $created_at;

    //contructor with db connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        $query = 'SELECT 
        c.name as category_name,
        p.product_id, p.category_id,
        p.product_name,p.model_nb,
        p.puff,p.quantity, p.P_Was,
        p.P_Now, p.saving_percentage,
        p.description,p.l_description,
        p.image,p.l_image,p.created_at
        FROM '.$this->table.' p
        LEFT JOIN
        categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //excute statement
        $stmt->execute();
        
        return $stmt;

      
    }
    public function read_by_puff(){
        $query = 'SELECT 
        c.name as category_name,
        p.product_id, p.category_id,
        p.product_name,p.model_nb,
        p.puff,p.quantity, p.P_Was,
        p.P_Now, p.saving_percentage,
        p.description,p.l_description,
        p.image,p.l_image,p.created_at
        FROM '.$this->table.' p
        LEFT JOIN
        categories c ON p.category_id = c.id
        where p.puff=:puff
        ORDER BY p.created_at DESC';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':puff',$this->puff);

        //excute statement
        $stmt->execute();
        
        return $stmt;

      
    }
    public function read_by_category_id(){
        $query = 'SELECT 
        c.name as category_name,
        p.product_id, p.category_id, 
        p.product_name,p.model_nb,
        p.puff,p.quantity, p.P_Was,
        p.P_Now, p.saving_percentage,
        p.description,p.l_description,
        p.image,p.l_image,p.created_at
        FROM '.$this->table.' p
        LEFT JOIN
        categories c ON p.category_id = c.id
        where p.category_id= ? ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$this->category_id);

        $stmt->execute();

        return $stmt; 
    }

    public function read_single(){
        $query = 'SELECT 
        c.name as category_name,
        p.product_id, p.category_id,
        p.product_name,p.model_nb,
        p.puff,p.quantity, p.P_Was,
        p.P_Now, p.saving_percentage,
        p.description,p.l_description,
        p.image,p.l_image,p.created_at
        FROM '.$this->table.' p
        LEFT JOIN
        categories c ON p.category_id = c.id
        where p.product_id= ? LIMIT 1';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //binding parameter
        $stmt->bindParam(1, $this->product_id);
        //execute statement
        $stmt->execute();

        $num = $stmt->rowCount();

        if($num >0 ){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->product_name = $row['product_name'];
        $this->model_nb = $row['model_nb'];
        $this->quantity = $row['quantity'];
        $this->puff = $row['puff'];
        $this->P_Was = $row['P_Was'];
        $this->P_Now = $row['P_Now'];
        $this->saving_percentage = $row['saving_percentage'];
        $this->description = $row['description'];
        $this->l_description = $row['l_description'];
        $this->image = $row['image'];
        $this->l_image = $row['l_image'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

        return true;
        }
        else{
            return false;
        }

    }
    public function create(){
        $query='INSERT INTO '.$this->table.' SET product_name = :product_name, model_nb= :model_nb,
         ,puff=:puff,quantity=:quantity,P_Was=:P_Was,
         P_Now=:P_Now, saving_percentage=:saving_percentage ,
         description=:description, l_description=:l_description,
         image=:image, l_image=:l_image, category_id=:category_id';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //clean the data
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->model_nb = htmlspecialchars(strip_tags($this->model_nb));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->puff = htmlspecialchars(strip_tags($this->puff));
        $this->P_Was = htmlspecialchars(strip_tags($this->P_Was));
        $this->P_Now = htmlspecialchars(strip_tags($this->P_Now));
        $this->saving_percentage = htmlspecialchars(strip_tags($this->saving_percentage));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->l_description = htmlspecialchars(strip_tags($this->l_description));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->l_image = htmlspecialchars(strip_tags($this->l_image));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //binding of parameters
        $stmt->bindParam(':product_name',$this->product_name);
        $stmt->bindParam(':model_nb',$this->model_nb);
        $stmt->bindParam(':quantity',$this->quantity);
        $stmt->bindParam(':puff',$this->puff);
        $stmt->bindParam(':P_Was',$this->P_Was);
        $stmt->bindParam(':P_Now',$this->P_Now);
        $stmt->bindParam(':saving_percentage',$this->saving_percentage);
        $stmt->bindParam(':description',$this->description);
        $stmt->bindParam(':l_description',$this->l_description);
        $stmt->bindParam(':image',$this->image);
        $stmt->bindParam(':l_image',$this->l_image);
        $stmt->bindParam(':category_id',$this->category_id);

        //execute statement
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
        
    }
    public function update(){

        $query='UPDATE '.$this->table.' p
        SET product_name = :product_name, model_nb= :model_nb,
        puff=:puff,quantity= :quantity, P_Was= :P_Was,
        P_Now= :P_Now,saving_percentage= :saving_percentage,
        description= :description,l_description= :l_description,
        image= :image,l_image= :l_image ,category_id= :category_id
        where p.product_id = :product_id ';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //clean the data
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->model_nb = htmlspecialchars(strip_tags($this->model_nb));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->puff = htmlspecialchars(strip_tags($this->puff));
        $this->P_Was = htmlspecialchars(strip_tags($this->P_Now));
        $this->P_Now = htmlspecialchars(strip_tags($this->P_Now));
        $this->saving_percentage = htmlspecialchars(strip_tags($this->saving_percentage));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->l_description = htmlspecialchars(strip_tags($this->l_description));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->l_image = htmlspecialchars(strip_tags($this->l_image));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));

        //binding of parameters
        $stmt->bindParam(':product_name',$this->product_name);
        $stmt->bindParam(':model_nb',$this->model_nb);
        $stmt->bindParam(':quantity',$this->quantity);
        $stmt->bindParam(':puff',$this->puff);
        $stmt->bindParam(':P_Was',$this->P_Was);
        $stmt->bindParam(':P_Now',$this->P_Now);
        $stmt->bindParam(':saving_percentage',$this->saving_percentage);
        $stmt->bindParam(':description',$this->description);
        $stmt->bindParam(':l_description',$this->l_description);
        $stmt->bindParam(':image',$this->image);
        $stmt->bindParam(':l_image',$this->l_image);
        $stmt->bindParam(':category_id',$this->category_id);
        $stmt->bindParam(':product_id',$this->product_id);

        //execute statement
        if($stmt->execute()){
            return true;
        }
        else{
            printf("ERROR %s /n",$stmt->error);
            return false;
        }
        
    }
    public function delete(){
        $query = 'DELETE FROM '.$this->table.' where product_id= :product_id';

        //prepare the statement 
        $stmt = $this->conn->prepare($query);
        //clean the data
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        //binding the id parameter
        $stmt->bindParam(':product_id', $this->product_id);
        
        if($stmt->execute()){
            return true;
        }else{
            printf("ERROR %s /n",$stmt->error);
            return false;
        }
    }
}
?>