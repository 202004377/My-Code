<?php
//ini_set('display_errors', 1);
//session_start();

class Action{
    private $conn;

    public function __construct()
    {
        ob_start();
        include './dbconnect.php';

        $this->conn = $conn;
    }
    function __destruct()
    {
        $this->conn->close();
        ob_end_flush();
    }

    //function for processing logins
    public function signin(){
        extract($_POST);

        $password = md5($password);
        $email = mysqli_real_escape_string($this->conn, $email);
        $sql = "SELECT fullname FROM users WHERE email='{$email}' AND password='{$password}'";
        $check = $this->conn->query($sql);

        if($check->num_rows>0){
            $details = $check->fetch_assoc();
            
            $_SESSION['username'] = $details['fullname'];
            $_SESSION['email'] = $email;
            $_SESSION['signed'] = true;

            return 1;           
        }else{
            return 0;
        }
    }  //end  
    
    //function for creating user profile
    public function signup(){
        extract($_POST);
        
        $data = "";
        foreach($_POST as $key=>$value){
            if(!empty($value)){
                $value = mysqli_real_escape_string($this->conn, $value);
                if($key === "password"){
                    $value = md5($value);
                }

                if(!empty($data)){
                    $data .= ",$key = '$value'";
                }
                else{
                    $data .= "$key = '$value'";
                }
            }
        }

        // check if account already exists
        $sql = "SELECT id FROM users WHERE email='{$email}'";
        $check = $this->conn->query($sql);

        if($check->num_rows > 0){
            return 2;
        }else{
            // query for creating the user account
            $sql = "INSERT INTO users SET $data";
            $query = $this->conn->query($sql);

            if($query){
                // Upon successful creation of account, create a financial account
               return 1;
            }
            else{
                return 0;
            } 
        }
    } //end

    //function for processing logins
    public function verify(){
        extract($_POST);

        $code = mysqli_real_escape_string($this->conn, $code);

        if($code){
            return 1;           
        }else{
            return 0;
        }
    }  //end  

    //function for checking out during reservation
    public function checkout(){
        $email = $_SESSION['email'];
        $data = "user='$email'";

        extract($_POST);

        $accepted_keys = array("init_duration","payment_method", "vehicle_registration");

        foreach($_POST as $key=>$value){
            if(!empty($value) && in_array($key, $accepted_keys)){
                $value = mysqli_real_escape_string($this->conn, $value);

                if(!empty($data)){
                    $data .= ",$key = '$value'";
                }
                else{
                    $data .= "$key = '$value'";
                }
            }
        }

        // get parkings and check for available parking slot
        $sql = "SELECT parking_code, price FROM parkings WHERE status=1 LIMIT 1";
        $check = $this->conn->query($sql);
        if($check->num_rows > 0){
            $details = $check->fetch_assoc();
            $parking_code = $details['parking_code'];
            $price = $details['price'];

            // update the parking slot to reserved
            $sql = "UPDATE parkings SET status=0 WHERE parking_code='{$parking_code}'";
            $this->conn->query($sql);

            // add the parking code and price to the data
            $price = $price * $init_duration;
            $data .= ",parking_code='$parking_code',amount_paid='$price'";
        }
        $sql = "INSERT INTO reservations SET $data";
        $query = $this->conn->query($sql);

        if($query){
            return 1;
        }
        else{
            return 0;
        }
    } //end

    //function for updating the user profile
    public function update_user(){
        $email = $_SESSION['email'];
        $data = "";

        $accepted_keys = array("email","fullname", "phone");

        foreach($_POST as $key=>$value){
            if(!empty($value) && in_array($key, $accepted_keys)){
                $value = mysqli_real_escape_string($this->conn, $value);

                if(!empty($data)){
                    $data .= ",$key = '$value'";
                }
                else{
                    $data .= "$key = '$value'";
                }
            }
        }

        $sql = "UPDATE users SET $data WHERE email='{$email}'";
        $query = $this->conn->query($sql);

        if($query){
            return 1;
        }
        else{
            return 0;
        }
    } //end

    //function for updating the user profile
    public function manage_vehicle(){
        $email = $_SESSION['email'];
        $data = "owner='$email'";

        $accepted_keys = array("vehicle_reg");

        foreach($_POST as $key=>$value){
            if(!empty($value) && in_array($key, $accepted_keys)){
                $value = mysqli_real_escape_string($this->conn, $value);

                if(!empty($data)){
                    $data .= ",$key = '$value'";
                }
                else{
                    $data .= "$key = '$value'";
                }
            }
        }

        $sql = "INSERT INTO vehicles SET $data";
        $query = $this->conn->query($sql);

        if($query){
            return 1;
        }
        else{
            return 0;
        }
    } //end

}