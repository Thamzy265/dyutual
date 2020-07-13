<?php

require_once "../helpers/sessionHelper.php";

class Admin extends model{

    public function log($username,$password){
        $name = $username;
        $password = $password;

        if (isset($name)&&!empty($name) && isset($password) && !empty($password)){
            $pass = md5($password);
            $result = $this->logTbl($name,$pass);
            if ($result==false){
                header("location: /dyuni/adminLogin.php?msg= Name or password is incorrect");
            }else{
                header("location: /dyuni/views/?page=admin");
            }

        }

    }

    public function logTbl($name,$pass){
        $sql = "SELECT * FROM `admin` WHERE `username`='{$name}' AND `password`='{$pass}'";
        if ($query = self::$mysqli->query($sql)){
            $rows = $this->getRows($query);
            if ($rows >= 1){
                $result = $query->fetch_assoc();

                // setting sessions if log in is succesful
                $sesHelper = new sessionHelper();
                $sesHelper->setSession('dyunilog',$result['username']);
                $sesHelper->setSession('user_id',$result['AdminID']);
                $fullName = $result['Fname']." ".$result['Sname'];
                $sesHelper->setSession('fullname',$fullName);
                $sesHelper->setSession('admin','1');
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

    public function fetchAdmin(){
        $sql = "select * from `admin`";
        $query = self::$mysqli->query($sql);

        $result_array = array();
        while($data = $query->fetch_array()){

            $result_array[] = array(
                "id"=>$data['AdminID'],
                "fname"=> $data['Fname'],
                "sname"=> $data['Sname'],
                "Gender"=> $data['gender'],
                "Email"=> $data['EmailAddress'],
            );
        }
        return $result_array;
    }

    public function getAdmin($id){
        $sql = "select * from `admin` Where `AdminID`='{$id}'";
        $query = self::$mysqli->query($sql);
        
       
        $result_array = array();
        while($data = $query->fetch_array()){
           
            $result_array[] = array(
                "id"=>$data['AdminID'],
                "fname"=> $data['Fname'],
                "sname"=> $data['Sname'],
                "Gender"=> $data['gender'],
                "Email"=> $data['EmailAddress'],
                "Username"=> $data['username'],
            );
        }
     
        return $result_array;
    }

    public function updateAdmin(){

        //removing space and sql injection possible characters
        $name = htmlentities(trim($_POST['fname']));
        $username = htmlentities(trim($_POST['username']));
        $lname = htmlentities(trim($_POST['sname']));
        $email = htmlentities(trim($_POST['email']));
        $gender = htmlentities(trim($_POST['gender']));
       
       
        $user_id = htmlentities(trim($_POST['id']));
     
        $sql = "UPDATE `Admin` SET `Fname`='{$name}',`Sname`='{$lname}',`EmailAddress`='{$email}',`Username`='{$username}',`Gender`='{$gender}' WHERE `AdminID`='{$user_id}'";

        if (self::$mysqli->query($sql)){
            
            header("location: /dyuni/views/?page=admin_accounts&&success=Admin user has been updated succesfully");
        }else{
            //when updating fails
            die("messa");
            header("location: /dyuni/views/?page=admin_accounts&&msg= failed to update user");
        }
    }

    public function AddUser(){

        //removing space and sql injection possible characters
        $name = htmlentities(trim($_POST['fname']));
        $username = htmlentities(trim($_POST['username']));
        $lname = htmlentities(trim($_POST['sname']));
        $email = htmlentities(trim($_POST['email']));
        $gender = htmlentities(trim($_POST['gender']));
        $pass = htmlentities(trim($_POST['password']));
        $re_pass = htmlentities(trim($_POST['re_pass']));

        if (isset($name) && isset($lname) && isset($email) && isset($username)  && isset($pass) && isset($re_pass)){
            if (!empty($name) && !empty($lname) && !empty($email) && !empty($username) && !empty($pass) && !empty($re_pass)){
                if ($pass==$re_pass){
                    $hashed_pass = md5($pass);
                    $result = $this->AdminRegisterTbl($username,$name,$lname,$email,$gender,$hashed_pass);
                    if ($result == false){
                       //if failed to register user
                       header("location: /dyuni/views/?page=admin_account&&msg= failed to register user");
                    }else{
                        //When user is registered
                        header("location: /dyuni/views/?page=admin_account&&success=User has been added succesfuly");
                    }
                }else{
                    //password is doesnt match
                    header("location: /dyuni/index.php?msg= passwords dont match");
                }
            }else{
                //if fields are empty
                
                header("location: /dyuni/register.php?msg= all fields much be entered");
            }
        }

    }

    public function AdminRegisterTbl($username,$fname,$sname,$email,$gender,$pass){
        //check if the another username exists
        $sql = "SELECT * FROM `admin` WHERE  `username`='{$username}'";
      
        $query = self::$mysqli->query($sql);
        $rows = $this->getRows($query);
        if ($rows == 0){
            
            //adding the user to the db
            $sql = "INSERT INTO `admin`(`Fname`, `Sname`, `password`, `gender`, `username`, `EmailAddress`) VALUES ('{$fname}','{$sname}','{$pass}','{$gender}','{$username}','{$email}')";
            if (self::$mysqli->query($sql)){
                
                    //if user is registered succesfully
            
                    
                return true;

                
            }else{
                //if user fails to register to the admin table
                return false;

            }
        }else{
            //if user already exists
            header("location: /dyuni/register.php?msg= username already exists");

        }
    }

    public function AddCourse(){
        $courseTitle = $_GET['courseTitle'];
        $courseCode = $_GET['courseCode'];
        $adminID = $_SESSION['user_id'];
        $sql = "INSERT INTO `course` (`CourseTitle`,`CourseCode`,`AdminID`) VALUES ('{$courseTitle}','{$courseCode}','{$adminID}')";
        if (self::$mysqli->query($sql)){
              
            header("location: /dyuni/views/?page=admin_courses&&success=Course has been added");
     
        }else{
            //if user fails to register to the admin table
            header("location: /dyuni/views/?page=admin_courses&&msg=Course was not added");

        }
    }

    public function addLecturer(){

        //removing space and sql injection possible characters
        $name = htmlentities(trim($_POST['fname']));
        $username = htmlentities(trim($_POST['username']));
        $lname = htmlentities(trim($_POST['sname']));
        $email = htmlentities(trim($_POST['email']));
        $gender = htmlentities(trim($_POST['gender']));
        $classID = htmlentities(trim($_POST['class']));
        $pass = htmlentities(trim($_POST['password']));
        $re_pass = htmlentities(trim($_POST['re_pass']));

        if (isset($name) && isset($lname) && isset($email) && isset($username)  && isset($pass) && isset($re_pass)){
            if (!empty($name) && !empty($lname) && !empty($email) && !empty($username) && !empty($pass) && !empty($re_pass)){
                if ($pass==$re_pass){
                    $hashed_pass = md5($pass);
                    $result = $this->lecturerRegisterTbl($username,$name,$lname,$email,$gender,$hashed_pass,$classID);
                    if ($result == false){
                       //if failed to register user
                       header("location: /dyuni/views/?page=admin_lecturer&&msg= failed to register user");
                    }else{
                        //When user is registered
                        header("location: /dyuni/views/?page=admin_lecturers&&success=Lecturer has been added succesfully");
                    }
                }else{
                    //password is doesnt match
                    header("location: /dyuni/views/?page=admin_lecturer&&msg= password does not match");
                }
            }else{
                //if fields are empty
                
                header("location: /dyuni/views/?page=admin_lecturer&&msg= all fields much be entered");
            }
        }

    }

    public function lecturerRegisterTbl($username,$fname,$sname,$email,$gender,$pass,$classID){
        //check if the another username exists
        $sql = "SELECT * FROM `lecturer` WHERE  `username`='{$username}'";
        $adminID = $_SESSION['user_id'];
        $query = self::$mysqli->query($sql);
        $rows = $this->getRows($query);
        if ($rows == 0){
            
            //adding the user to the db
            $sql = "INSERT INTO `lecturer`(`Fname`, `Sname`, `password`, `gender`, `username`, `EmailAddress`,`AdminID`,`ClassID`) 
                    VALUES ('{$fname}','{$sname}','{$pass}','{$gender}','{$username}','{$email}','{$adminID}','{$classID}')";
            if (self::$mysqli->query($sql)){
                
                    //if user is registered succesfully
            
                    
                return true;

                
            }else{
                //if user fails to register to the admin table
                return false;

            }
        }else{
            //if user already exists
            header("location: /dyuni/register.php?msg= username already exists");

        }
    }

    public function addStudent(){

        //removing space and sql injection possible characters
        $name = htmlentities(trim($_POST['fname']));
        $username = htmlentities(trim($_POST['username']));
        $lname = htmlentities(trim($_POST['sname']));
        $email = htmlentities(trim($_POST['email']));
        $gender = htmlentities(trim($_POST['gender']));
        $courseID = htmlentities(trim($_POST['course']));
        $pass = htmlentities(trim($_POST['password']));
        $re_pass = htmlentities(trim($_POST['re_pass']));

        if (isset($name) && isset($lname) && isset($email) && isset($username)  && isset($pass) && isset($re_pass)){
            if (!empty($name) && !empty($lname) && !empty($email) && !empty($username) && !empty($pass) && !empty($re_pass)){
                if ($pass==$re_pass){
                    $hashed_pass = md5($pass);
                    $result = $this->studentRegisterTbl($username,$name,$lname,$email,$gender,$hashed_pass,$courseID);
                    if ($result == false){
                       //if failed to register user
                       header("location: /dyuni/views/?page=admin_student&&msg= failed to register Student");
                    }else{
                        //When user is registered
                        header("location: /dyuni/views/?page=admin_students&&success=Student has been added succesfully");
                    }
                }else{
                    //password is doesnt match
                    header("location: /dyuni/views/?page=admin_student&&msg= password does not match");
                }
            }else{
                //if fields are empty
                
                header("location: /dyuni/views/?page=admin_student&&msg= all fields much be entered");
            }
        }

    }

    public function studentRegisterTbl($username,$fname,$sname,$email,$gender,$pass,$courseID){
        //check if the another username exists
        $sql = "SELECT * FROM `student` WHERE  `username`='{$username}'";
        $adminID = $_SESSION['user_id'];
        $query = self::$mysqli->query($sql);
        $rows = $this->getRows($query);
        if ($rows == 0){
            
            //adding the user to the db
            $sql = "INSERT INTO `student`(`Fname`, `Sname`, `password`, `Gender`, `Username`, `EmailAddress`,`CourseID`,`AdminID`) 
                    VALUES ('{$fname}','{$sname}','{$pass}','{$gender}','{$username}','{$email}','{$courseID}','{$adminID}')";
            if (self::$mysqli->query($sql)){
                
                    //if user is registered succesfully
            
                    
                return true;

                
            }else{
                //if user fails to register to the admin table
                return false;

            }
        }else{
            //if user already exists
            header("location: /dyuni/register.php?msg= username already exists");

        }
    }

    public function deleteAdmin(){
        $user_id = $_GET['id'];
        $sql = "DELETE FROM  `admin` WHERE `AdminID`={$user_id}";
        if (self::$mysqli->query($sql)) {
            //if succesful delete in profiles table
            header('location: /dyuni/views/?page=admin_accounts&&success=User has been deleted');
        } else {
            //if failed in users table
            header('location: /dyuni/views/?page=admin_accounts&&msg=There is a problem deleting the account');
        }
    }

    protected function getRows($query){
        $rows = $query->num_rows;
        return $rows;
    }

    public function upadtePassword($id,$pass){
        $hash_pass = md5($pass);
       
        $sql = "UPDATE `admin` SET `Password`='{$hash_pass}' Where `AdminID`='{$id}'";
        if ($query = self::$mysqli->query($sql)) {
            header("location: /dyuni/views/?page=admin_accounts&&success= Password has been updated");
        }else{
            header("location: /dyuni/views/?page=admin_accounts&&msg= failed to update Password");
        }
    }
}