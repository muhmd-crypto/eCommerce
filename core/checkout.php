<?php


class CHECKOUT{

    private $conn;
    private $table = 'checkout';

    public $user_id;
    public $session_id;
    public $firstName;
    public $lastName;
    public $zone;
    public $address;
    public $phone;
    public $addressDetails;
    public $paymentMethod;
    public $cardHolderName;
    public $cardNumber;
    public $expirationDate;
    public $CVC;
    public $Items_Count;
    public $Total_Amount;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){

        $query = 'INSERT INTO '.$this->table.' SET user_id = :user_id, session_id=:session_id,
        firstName = :firstName,
        lastName = :lastName, Zone = :Zone,
        Address = :Address, phone = :phone,
        addressDetails = :addressDetails, paymentMethod= :paymentMethod,
        cardHolderName = :cardHolderName, cardNumber = :cardNumber,
        expirationDate = :expirationDate, CVC = :CVC ,Items_Count = :Items_Count,
        Total_Amount = :Total_Amount';
        
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->session_id = htmlspecialchars(strip_tags($this->session_id));
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->Zone = htmlspecialchars(strip_tags($this->Zone));
        $this->Address = htmlspecialchars(strip_tags($this->Address));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->addressDetails = htmlspecialchars(strip_tags($this->addressDetails));
        $this->paymentMethod = htmlspecialchars(strip_tags($this->paymentMethod));
        $this->cardHolderName = htmlspecialchars(strip_tags($this->cardHolderName));
        $this->cardNumber = htmlspecialchars(strip_tags($this->cardNumber));
        $this->expirationDate = htmlspecialchars(strip_tags($this->expirationDate));
        $this->CVC = htmlspecialchars(strip_tags($this->CVC));
        $this->Items_Count = htmlspecialchars(strip_tags($this->Items_Count));
        $this->Total_Amount = htmlspecialchars(strip_tags($this->Total_Amount));

        $stmt->bindParam(':user_id',$this->user_id);
        $stmt->bindParam(':session_id',$this->session_id);
        $stmt->bindParam(':firstName',$this->firstName);
        $stmt->bindParam(':lastName',$this->lastName);
        $stmt->bindParam(':Zone',$this->Zone);
        $stmt->bindParam(':Address',$this->Address);
        $stmt->bindParam(':phone',$this->phone);
        $stmt->bindParam(':addressDetails',$this->addressDetails);
        $stmt->bindParam(':paymentMethod',$this->paymentMethod);
        $stmt->bindParam(':cardHolderName',$this->cardHolderName);
        $stmt->bindParam(':cardNumber',$this->cardNumber);
        $stmt->bindParam(':expirationDate',$this->expirationDate);
        $stmt->bindParam(':CVC',$this->CVC);
        $stmt->bindParam(':Items_Count',$this->Items_Count);
        $stmt->bindParam(':Total_Amount',$this->Total_Amount);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
}
?>