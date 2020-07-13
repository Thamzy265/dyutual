<?php

require('db.php');

class RegisterUser extends model
{
    public function adminRegister(){

            //removing space and sql injection possible characters
            $name = htmlentities(trim($_POST['fname']));
            $username = htmlentities(trim($_POST['username']));
            $lname = htmlentities(trim($_POST['lname']));
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
                           header("location: /dyuni/register.php?msg= failed to register user");
                        }else{
                            //When user is registered
                            header("location: /dyuni/views/?page=home");
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
      die("here");
      $query = self::$mysqli->query($sql);
      $rows = $this->getRows($query);
      if ($rows == 0){
          //adding the user to the db
          $sql = "INSERT INTO `admin` (`Fname`,`Sname`,`password`,`gender`,`username`,`EmailAddress`) VALUES ('{$fname}','{$sname}','{$pass}','{$gender}','{$username}','{$email}')";
          if (self::$mysqli->query($sql)){
                  //if user is registered succesfully
                  //setting session variables
                  /*
                  $user_id = self::$mysqli->insert_id;
                  $fullName = $fname.' '.$sname;
                  $sesHelper = new sessionHelper();
                  $sesHelper->setSession('Dyunilog',$username);
                  $sesHelper->setSession('user_id',$user_id);
                  $sesHelper->setSession('username',$fullName); 
                  */
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

    protected function getRows($query){
        $rows = $query->num_rows;
        return $rows;
    }
}

