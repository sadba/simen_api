<?php


class authentification
{
    private $conn;
    private $table_name = "user";

// object properties
    public $user_id;
    public $name;
    public $email;
    public $username;
    public $password;



    public function __construct($db){
        $this->conn = $db;
    }


    function login(){

        try {
            $sql = "SELECT user_id, name, email, username FROM users WHERE (username=:username or email=:username) and password=:password ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("username", $this->username, PDO::PARAM_STR);
            $password = hash('sha256', $this->password);
            $stmt->bindParam("password", $password, PDO::PARAM_STR);
            $stmt->execute();
            $mainCount = $stmt->rowCount();
            $userData = $stmt->fetch(PDO::FETCH_OBJ);

            if(!empty($userData))
            {
                $user_id=$userData->user_id;
                $userData->token = apiToken($user_id);
            }

            if($userData){
                $userData = json_encode($userData);
                echo '{"userData": ' .$userData . '}';
            } else {
                echo '{"error":{"text":"Bad request wrong username and password"}}';
            }

        }catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }

    }

    function signup(){

        $email=$this->email;
        $name=$this->name;
        $username=$this->username;
        $password=$this->password;

        try {

            $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
            $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
            $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

            if (strlen(trim($username))>0 && strlen(trim($password))>0 && strlen(trim($email))>0 && $email_check>0 && $username_check>0 && $password_check>0)
            {
                $db = getDB();
                $userData = '';
                $sql = "SELECT user_id FROM user WHERE username=:username or email=:email";
                $stmt = $db->prepare($sql);
                $stmt->bindParam("username", $username,PDO::PARAM_STR);
                $stmt->bindParam("email", $email,PDO::PARAM_STR);
                $stmt->execute();
                $mainCount=$stmt->rowCount();
                $created=time();
                if($mainCount==0)
                {
                    $sql1="INSERT INTO users(username,password,email,name)VALUES(:username,:password,:email,:name)";
                    $stmt1 = $db->prepare($sql1);
                    $stmt1->bindParam("username", $username,PDO::PARAM_STR);
                    $password=hash('sha256',$this->password);
                    $stmt1->bindParam("password", $password,PDO::PARAM_STR);
                    $stmt1->bindParam("email", $email,PDO::PARAM_STR);
                    $stmt1->bindParam("name", $name,PDO::PARAM_STR);
                    $stmt1->execute();


                }

                if($userData){
                    $userData = json_encode($userData);
                    echo '{"userData": ' .$userData . '}';
                } else {
                    echo '{"error":{"text":"Enter valid data"}}';
                }

            }
            else{
                echo '{"error":{"text":"Enter valid data"}}';
            }
        }
        catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
}