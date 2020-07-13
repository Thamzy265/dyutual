<?php
require_once "../helpers/sessionHelper.php";

class Login extends model
{
    public function log(){
        $name = htmlentities(trim($_POST['username']));
        $password = htmlentities(trim($_POST['password']));
    
        if (isset($name)&&!empty($name) && isset($password) && !empty($password)){
            $pass = md5($password);
            $result = $this->logTbl($name,$pass);
            if ($result==false){
                header("location: /blood/login.php?msg= Name or password is incorrect");
            }else{

                header("location: /blood/views/?page=home");
            }
        
    }
   
    }
    public function logTbl($name,$pass){
        $sql = "SELECT * FROM `users` WHERE `username`='{$name}' OR `phone_number`='{$name}' AND `password`='{$pass}'";
        if ($query = self::$mysqli->query($sql)){
            $rows = $this->getRows($query);
            if ($rows >= 1){
                $result = $query->fetch_assoc();

               // setting sessions if log in is succesful
                $sesHelper = new sessionHelper();
                $sesHelper->setSession('BBlog',$result['phone_number']);
                $sesHelper->setSession('user_id',$result['id']);

                $sql = "SELECT * FROM `profiles` WHERE `user_id`='{$result['id']}'";

                if ($query = self::$mysqli->query($sql)){
                    $rows = $this->getRows($query);
                    if ($rows >=1){
                        $result = $query->fetch_assoc();
                        $fullName = $result['first_name']." ".$result['last_name'];
                        $sesHelper->setSession('username',$fullName);

                      return true;
                    }
                }

            }else{
                //when credentials are incorrect
                return false;
            }
         }else{
           //db error failed to log user
            return false;
        }
    }

    protected function getRows($query){
        $rows = $query->num_rows;
        return $rows;
    }
    
}
