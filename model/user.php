<?php
require_once "db.php";
//require_once "Admin.php";

class user extends model
{


    public function Login($usertype){

        $username = $_POST['username'];
        $password = $_POST['password'];

        if($usertype=="admin"){
            $admin = new Admin();
            $admin->log($username,$password);
        }elseif($usertype=="lecturer"){
            $this->lecturerLog($username,$password);
        }else {
            $this->studentLog($username,$password);
        }
    }
    public function changePassword($current,$newPass,$accType){
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $cuPass = md5($current);
            $pass = md5($newPass);
            if($accType == 'student'){
                $tbl = "student";
                $page = "account";
                $tblID = "StudentID";
            }elseif($accType == "lecturer"){
                $tbl = "lecturer";
                $page = "lecturer_account";
                $tblID = "LecturerID";
            }else {
                $tbl = "admin";
                $page = "admin_account";
                $tblID = "AdminID";
            }
            $sql = "Select * from `{$tbl}` WHERE  `{$tblID}`='{$user_id}' AND  `password`='{$cuPass}'";
            if ($query = self::$mysqli->query($sql)){
                $rows = $this->getRows($query);
                if ($rows >= 1) {
                    $sql = "Update `{$tbl}` SET `password`='{$pass}' WHERE `{$tblID}`='{$user_id}'";
                    if (self::$mysqli->query($sql)){
                        //when succesful
                        header('location: /dyuni/views/?page='.$page.'&&success=Password has been changed');
                    }else{
                        //when updating fails
                        header('location: /dyuni/views/?page='.$page.'&&msg=A problem occured when updating your password');
                    }
                }
            }else{
                //if password is incorrect
                header('location: /dyuni/views/?page='.$page.'&&msg=Password is incorrect');
            }

        }else{
            //if user id is not set

        }
    }
   
    public function studentLog($username,$password){
        $name = $username;
        $password = $password;

        if (isset($name)&&!empty($name) && isset($password) && !empty($password)){
            $pass = md5($password);
            $result = $this->studentLogTbl($name,$pass);
            if ($result==false){
                header("location: /dyuni/index.php?msg= Name or password is incorrect");
            }else{
                header("location: /dyuni/views/?page=home");
            }

        }

    }

    public function studentLogTbl($name,$pass){
        
        $sql = "SELECT * FROM `student` WHERE `Username`='{$name}' AND `password`='{$pass}'";
        if ($query = self::$mysqli->query($sql)){
            $rows = $this->getRows($query);
            if ($rows >= 1){
                $result = $query->fetch_assoc();
                
                // setting sessions if log in is succesful
                $sesHelper = new sessionHelper();
                $sesHelper->setSession('dyunilog',$result['Username']);
                $sesHelper->setSession('user_id',$result['StudentID']);
                $fullName = $result['Fname']." ".$result['Sname'];
                $sesHelper->setSession('fullname',$fullName);
                $sesHelper->setSession('student','1');
                $sesHelper->setSession('schedule_id',$result['CourseID']);
                
                return true;

            }else{
                //when credentials are incorrect
                return false;
            }
        }else{
            //db error failed to log user
            return false;
        }
    }
    public function lecturerLog($username,$password){
        $name = $username;
        $password = $password;

        if (isset($name)&&!empty($name) && isset($password) && !empty($password)){
            $pass = md5($password);
            $result = $this->lecturerLogTbl($name,$pass);
            if ($result==false){
                header("location: /dyuni/lecturerLogin.php?msg= Name or password is incorrect");
            }else{
                header("location: /dyuni/views/?page=lecturer_home");
            }

        }

    }

    public function lecturerLogTbl($name,$pass){
        $sql = "SELECT * FROM `lecturer` WHERE `Username`='{$name}' AND `Password`='{$pass}'";
        if ($query = self::$mysqli->query($sql)){
            $rows = $this->getRows($query);
            if ($rows >= 1){
                $result = $query->fetch_assoc();

                // setting sessions if log in is succesful
                $sesHelper = new sessionHelper();
                $sesHelper->setSession('dyunilog',$result['Username']);
                $sesHelper->setSession('user_id',$result['LecturerID']);
                $fullName = $result['Fname']." ".$result['Sname'];
                $sesHelper->setSession('fullname',$fullName);
                $sesHelper->setSession('lecturer','1');
                $sesHelper->setSession('class_id',$result['ClassID']);
                return true;

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