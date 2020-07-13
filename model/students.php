<?php
require_once "lecturer.php";

class student extends lecturer
{
    public function getStudent($id){

        $sql = "select * from `student` WHERE `StudentID`='{$id}'";
        if ($query = self::$mysqli->query($sql)){
            $result_data = array();
            // $results = $query->fetch_assoc();
            while ($row = $query->fetch_array()){
                $result_data[] = array(
                    'id' => $row["StudentID"],
                    'fname' => $row["Fname"],
                    'lname' => $row["Sname"],
                    'email' => $row["EmailAddress"],
                    'gender' => $row["Gender"],
                    'username' => $row["Username"],
                    'course'=> $row["CourseID"],
                );
            }
            return $result_data;
        }else{
            //failed to fetch profiles table
        }
    }

    public function getStudents(){
        $sql = "select * from `student`";
        if ($query = self::$mysqli->query($sql)){
            $result_data = array();
            // $results = $query->fetch_assoc();
            while ($row = $query->fetch_array()){

                $Sql = "select * from `course` where `CourseID`='{$row["CourseID"]}'";
                $couseQuery = self::$mysqli->query($Sql);
                $course = $couseQuery->fetch_assoc();

                $result_data[] = array(
                    'id' => $row["StudentID"],
                    'fname' => $row["Fname"],
                    'lname' => $row["Sname"],
                    'email' => $row["EmailAddress"],
                    'gender' => $row["Gender"],
                    'course' => $course["CourseTitle"],
                    
                );
            }
            return json_encode($result_data);
        }else{
            //failed to fetch profiles table
        }
    }

    public function searchStudents($id,$name,$email){
        $sql = "select * from `student` WHERE";
        if($id != null){
            $sql.=" `StudentID`='{$id}' ";
        }
        if($id != null && $name != null){
            $sql.=" AND ";
        }

        if($name != null){
            $sql.=" `Fname`='{$name}'";
        }
        if($email != null && $name != null){
            $sql.=" AND ";
        }

        if($email != null){
            $sql.=" `EmailAddress`='{$email}'";
        }

        if ($query = self::$mysqli->query($sql)){
            $result_data = array();
            // $results = $query->fetch_assoc();
            while ($row = $query->fetch_array()){
                $sql = "select * from `course` where `CourseID`={$row["CourseID"]}";
                $couseQuery = self::$mysqli->query($sql);
                $course = $couseQuery->fetch_assoc();
                $result_data[] = array(
                    'id' => $row["LecturerID"],
                    'fname' => $row["Fname"],
                    'lname' => $row["Sname"],
                    'email' => $row["EmailAddress"],
                    'gender' => $row["Gender"],
                    'course' => $course["CourseTitle"],
                );
            }
            return json_encode($result_data);
        }else{
            //failed to fetch profiles table
        }
     }
    

   
     public function getStudentClasses(){
      return  $this->getClasses();
    }

    public function updateStudent(){

          //removing space and sql injection possible characters
          $isAdmin = false;
          $name = htmlentities(trim($_POST['fname']));
          $username = htmlentities(trim($_POST['username']));
          $lname = htmlentities(trim($_POST['sname']));
          $email = htmlentities(trim($_POST['email']));
          $gender = htmlentities(trim($_POST['gender']));
          $classID = htmlentities(trim($_POST['class']));

          if(isset($_SESSION['admin']) && $_SESSION['admin']==1){
            $CourseID = htmlentities(trim($_POST['schedule']));
            $isAdmin = true;
          }
         
         
          $user_id = htmlentities(trim($_POST['id']));
         
        
        $sql = "UPDATE `student` SET 
        `Fname`='{$name}',`Sname`='{$lname}',`EmailAddress`='{$email}',`Username`='{$username}',`Gender`='{$gender}' ";
        if($isAdmin){
            $sql.=" ,`CourseID`='{$CourseID}' ";
        }
        $sql.=" WHERE `StudentID`='{$user_id}'";

        if (self::$mysqli->query($sql)){
          if($isAdmin){
            header("location: /dyuni/views/?page=admin_students&&success=Student record has been updated succesfully");
          }else{
            header("location: /dyuni/views/?page=account&&success=Your account has been updated succesfully");
          }
           
        }else{
            //when updating fails
            if($isAdmin){
                header("location: /dyuni/views/?page=admin_students&&msg= failed to update student");
              }else{
                header("location: /dyuni/views/?page=account&&msg= failed to update your account");
              }
           
        }
    }

    public function enterClass(){
        $vclass_id = $_GET['vclass_id'];
        $sql ="Select * from virtual_class where `virtualClassID`='{$vclass_id}'";
        if ($query = self::$mysqli->query($sql)){

            $row =$query->fetch_assoc();
            $_SESSION['virtual_id'] = $row['virtualClassID']; 
            $virtualClass = $row['virtualClassID'];
            $username = $_SESSION['dyunilog'];

            $sql = "select * from participants where `username`='{$username}' AND `virtualClassID`='{$virtualClass}'";
            $result = self::$mysqli->query($sql);
            if($result->num_rows == '0'){
                
                $sql = "INSERT INTO `participants` (`virtualClassID`, `username`) VALUES ('{$virtualClass}','{$username}')";
                if (self::$mysqli->query($sql)){
                    header("location: /dyuni/views/pages/virtual_student.php?file={$row['files']}#21fae7");
                }else {
                    echo"didnti";
                }
            }else {
                header("location: /dyuni/views/pages/virtual_student.php?file={$row['files']}#21fae7");
            }
        }else{
            //failed to fetch profiles table
        }

    }

    public function selectClass($id){
        $sql ="Select * from virtual_class where `classID`='{$id}'";
        if ($query = self::$mysqli->query($sql)){
    
            $result_data = array();
            while ($row = $query->fetch_array()){
                $result_data[] = array(
                    'id' => $row["virtualClassID"],
                    'class' => $row["classID"],
                    'time' => $row["time"],
                );
            }
    
            return json_encode($result_data);
        }else{
            //when it fails
            echo "failed to fetch data";
        }
    }

    public function deleteStudent(){
        $id = $_GET['id'];
        $sql = "DELETE FROM `student` WHERE `StudentID`='{$id}'";
      if (self::$mysqli->query($sql)){
        
        header("location: /dyuni/views/?page=admin_students&&success=Student has been deleted succesfully");
      }else{
          //when updating fails
          header("location: /dyuni/views/?page=admin_students&&msg= failed to delete student");
      }
    }

    public function upadtePassword($id,$pass){
        $hash_pass = md5($pass);
        $res = false;
        $sql = "UPDATE `student` SET `Password`='{$hash_pass}' Where `StudentID`='{$id}'";
        if ($query = self::$mysqli->query($sql)) {
            if(isset($_SESSION['admin']) && $_SESSION['admin']==1){
                header("location: /dyuni/views/?page=admin_students&&success= Password has been updated");
            }else{
                header("location: /dyuni/views/?page=account&&success= Password has been updated");
            }
           
        }else{
            if(isset($_SESSION['admin']) && $_SESSION['admin']==1){
                header("location: /dyuni/views/?page=admin_students&&msg= failed to update Password");
            }else{
                header("location: /dyuni/views/?page=laccount&&msg= failed to update Password");
            }
        }
    }
}