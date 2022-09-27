<?php
include 'database.php';
include_once 'session.php';
class user{
    private $db;
    public function __construct(){
        $this->db = new Database();
        
    }
    public function userRegistration($data){
        $name       = $data['name'];
        $username   = $data['username'];
        $email      = $data['email'];
        $password   = md5($data['password']);

        $chk_email   = $this->emailCheck($email);

        if($name =='' || $username ==''|| $email =='' || $password =='' ){
             $msg = "<div class='alert alert-danger'>ERROR!!! <strong>File must not be empty...</strong></div>"; 
             return $msg;
        }
        if(strlen($username) < 3){
             $msg = "<div class='alert alert-danger'><strong>ERROR!!!</strong>Uaser Name is Too Short</div>";
             return $msg;
        }elseif(preg_match('/[^a-z0-9_-]+/i',$username)){
             $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>Invalid User Name</div>"; 
             return $msg;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>Invalid Email Address</div>"; 
            return $msg;
        }
        if($chk_email == true){
            $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>Already Taken</div>"; 
            return $msg;
        }

        $sql = "INSERT INTO tbl_user( name , username, email, password)
            VALUES(:name , :username, :email, :password)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindvalue(':name',$name);
        $query->bindvalue(':username',$username);
        $query->bindvalue(':email',$email);
        $query->bindvalue(':password',$password);
        $result = $query->execute();

        if($result){
            
            $msg = "<div class='alert alert-success'><strong>Success ! </strong>
                Thank YOU! You Have Been Register.</div>"; 
                return $msg;

        }else{
            $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>
                Something Wrong</div>"; 
                return $msg;

        }
    }
    public function emailCheck($email){
        $sql = "SELECT email FROM tbl_user WHERE email = :email";
        $query = $this->db->pdo->prepare($sql);
        $query->bindvalue(':email',$email);
        $query->execute();

        if($query->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function getLoginUser($email, $password){
        $sql = "SELECT * FROM tbl_user WHERE email = :email AND 
                password = :password LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindvalue(':email', $email);
        $query->bindvalue(':password', $password);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function userLogin($data){

        $email      = $data['email'];
        $password   = md5($data['password']);

        $chk_email   = $this->emailCheck($email);

        if($email =='' || $password =='' ){
             $msg = "<div class='alert alert-danger'>ERROR!!! <strong>File must not be empty...</strong></div>"; 
             return $msg;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>Invalid Email Address</div>"; 
            return $msg;
        }
        if($chk_email == false){
            $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>Email is Not Exist</div>"; 
            return $msg;
        }

        $result = $this->getLoginUser($email, $password);
        if($result){
            Session::init();
            Session:: set("login", true);
            Session:: set("id", $result->id);
            Session:: set("name", $result->name);
            Session:: set("username", $result->username);
            Session:: set("loginmsg", "<div class='alert alert-succsess'>
                        <strong>succsess ! </strong>You are Logged in</div>");
            header("Location: index.php");

        }else{
            $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>Data Not Found</div>"; 
            return $msg;
        }
        
    }
    public function getUserData(){
        $sql = "SELECT * FROM tbl_user ORDER BY id DESC";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function getUserById($id){
        $sql = "SELECT * FROM tbl_user WHERE id= :id LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindvalue(':id', $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    
    
    
    
    
    
    public function updateUserData($id, $data){
        $name       = $data['name'];
        $username   = $data['username'];
        $email      = $data['email'];

        if($name =='' || $username ==''|| $email ==''){
             $msg = "<div class='alert alert-danger'>ERROR!!! <strong>File must not be empty...</strong></div>"; 
             return $msg;
        }
        
        

        $sql = "UPDATE tbl_user set
                    name     = :name,
                    username = :username,
                    email    = :email
                    WHERE id =  :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindvalue(':name',$name);
        $query->bindvalue(':username',$username);
        $query->bindvalue(':email',$email);
        $query->bindvalue(':id',$id);
        $result = $query->execute();

        if($result){
            
            $msg = "<div class='alert alert-success'><strong>Success ! </strong>
                </div>"; 
                return $msg;

        }else{
            $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>
                Something Wrong</div>"; 
                return $msg;
        }
    }

    public function checkPassword($id, $old_pass){
        $password = md5($old_pass);
        $sql = "SELECT password FROM tbl_user 
                WHERE id = :id AND password = :password";
        $query = $this->db->pdo->prepare($sql);
        $query->bindvalue(':id',$id);
        $query->bindvalue(':password',$password);
        $query->execute();

        if($query->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function updatepassword($id, $data){
        $old_pass = $data['old_password'];
        $new_pass = $data['password'];
        $chk_pass = $this->checkPassword($id, $old_pass);

        if ($old_pass == "" || $new_pass == ""){
            $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>
                Filed must not be empty</div>"; 
                return $msg;
        }

        if($chk_pass == false){
            $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>
            Old Password does not match</div>"; 
            return $msg;
         }
         
         if(strlen($new_pass)< 4){
            $msg = "<div class='alert alert-danger'><strong>ERROR ! </strong>
            Password length must be more than three..</div>"; 
            return $msg;
         }

         $password = md5($new_pass);

         $sql = "UPDATE tbl_user set
                    password     = :password
                    WHERE id =  :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindvalue(':password',$password);
        $query->bindvalue(':id',$id);
        $result = $query->execute();

        if($result){
            
            $msg = "<div class='alert alert-success'><strong>Yeaaaa! It's updated... </strong>
                    </div>"; 
            return $msg;

        }else{
            $msg = "<div class='alert alert-danger'><strong>Shit Something Wrong ! </strong>
                   </div>"; 
            return $msg;
        }
    }
}
?>