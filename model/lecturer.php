<?php
require_once "db.php";
require_once "../config.php";

class lecturer extends model
{
    public function getLecturer($id){

        $sql = "select * from `lecturer` WHERE `LecturerID`='{$id}'";
        if ($query = self::$mysqli->query($sql)){
            $result_data = array();
            // $results = $query->fetch_assoc();
            while ($row = $query->fetch_array()){
                $result_data[] = array(
                    'id' => $row["LecturerID"],
                    'fname' => $row["Fname"],
                    'lname' => $row["Sname"],
                    'email' => $row["EmailAddress"],
                    'gender' => $row["Gender"],
                    'class' => $row["ClassID"],
                    'username' => $row["Username"],
                );
            }
            return $result_data;
        }else{
            //failed to fetch profiles table
        }
    }

    public function getLecturers(){
        $sql = "select * from `lecturer`";
        if ($query = self::$mysqli->query($sql)){
            $result_data = array();
            
            while ($row = $query->fetch_array()){
               
                $sql = "select * from `class` where `ClassID`='{$row["ClassID"]}'";
                $classQuery = self::$mysqli->query($sql);
                $class = $classQuery->fetch_assoc();
               
                $result_data[] = array(
                    'id' => $row["LecturerID"],
                    'fname' => $row["Fname"],
                    'lname' => $row["Sname"],
                    'email' => $row["EmailAddress"],
                    'gender' => $row["Gender"],
                    'class' => $class["Classname"],
                );
            }
          
            return json_encode($result_data);
        }else{
            //failed to fetch profiles table
        }
    }

    public function updateLecturer(){
        $isAdmin = false;
        //removing space and sql injection possible characters
        $name = htmlentities(trim($_POST['fname']));
        $username = htmlentities(trim($_POST['username']));
        $lname = htmlentities(trim($_POST['sname']));
        $email = htmlentities(trim($_POST['email']));
        $gender = htmlentities(trim($_POST['gender']));

        if(isset($_POST['class']) && !empty($_POST['class'])){
            $classID = htmlentities(trim($_POST['class']));
            $isAdmin = true;
        }
      
       
        $user_id = htmlentities(trim($_POST['id']));
     
       $sql = "UPDATE `lecturer` SET `Fname`='{$name}',`Sname`='{$lname}',`EmailAddress`='{$email}',`Username`='{$username}',`Gender`='{$gender}'";
       if($isAdmin){
        $sql.=" ,`ClassID`='{$classID}' ";
       }
        $sql.=" WHERE `LecturerID`='{$user_id}'";

      if (self::$mysqli->query($sql)){
        if($isAdmin){
            header("location: /dyuni/views/?page=admin_lecturers&&success=Lecturer has been updated succesfully");
        }else{
            header("location: /dyuni/views/?page=lecturer_account&&success=Lecturer has been updated succesfully");
        }
       
      }else{
          //when updating fails
          if($isAdmin){
            header("location: /dyuni/views/?page=admin_lecturers&&msg= failed to update user");
        }else{
            header("location: /dyuni/views/?page=lecturer_account&&msg= failed to update your account");
        }
         
      }
    }

    public function deleteLecturer(){
        $id = $_GET['id'];
        $sql = "DELETE FROM `lecturer` WHERE `LecturerID`='{$id}'";
      if (self::$mysqli->query($sql)){
        
        header("location: /dyuni/views/?page=admin_lecturers&&success=Lecturer has been deleted succesfully");
      }else{
          //when updating fails
          header("location: /dyuni/views/?page=admin_lecturers&&msg= failed to delete user");
      }
    }
    
    public function searchLecturers($id,$name,$email){
        $sql = "select * from `lecturer` WHERE";
        if($id != null){
            $sql.=" `LecturerID`='{$id}' ";
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
                $result_data[] = array(
                    'id' => $row["LecturerID"],
                    'fname' => $row["Fname"],
                    'lname' => $row["Sname"],
                    'email' => $row["EmailAddress"],
                    'gender' => $row["Gender"],
                    'class' => $row["ClassID"]
                );
            }
            return json_encode($result_data);
        }else{
            //failed to fetch profiles table
        }
     }

  
     public function searchCourse($id,$name,$table){
   
        if($table == 'lecturer'){
            $tableID = 'LecturerID';
        }else{
            $table = 'student';
            $tableID = 'StudentID';
        }
         
         $lectureNameQuery = "select * from `{$table}` WHERE `{$tableID}`='{$_SESSION['user_id']}'";
         $fetchData = self::$mysqli->query($lectureNameQuery);

         $result_data = array();
         while($data = $fetchData->fetch_array()){
          
            $sql = "Select * from `schedule` WHERE ";
            if($id != null){
                $sql.=" `CourseCode`= '{$id}' ";
            }
            if($id != null && $name != null){
                $sql.=" AND ";
            }

            if($name != null){
                $sql.=" `CourseTitle`= '{$name}'";
            }

            $sql.=" AND `ScheduleID`='{$data['ScheduleID']}' ";
           
            if ($query = self::$mysqli->query($sql)){

            
                while ($row = $query->fetch_array()){
                    $lectureNameQuery = "select * from `Lecturer` WHERE `ScheduleID`='{$row['ScheduleID']}'";
                    $fetchData = self::$mysqli->query($lectureNameQuery);
                    $data = $fetchData->fetch_assoc();
                    $name = $data['Fname']." ".$data['Sname'];
                
                    $result_data[] = array(
                        'id' => $row["ScheduleID"],
                        'lecturerName' => $name,
                        'title' => $row["CourseTitle"],
                        'code' => $row["CourseCode"],
                    );
                }

                return json_encode($result_data);
            }else{
                //when it fails
                echo "failed to fetch data";
            }
        }

         
    }
    public function searchClass($id,$name,$table){
   
        if($table == 'lecturer'){
            $tableID = 'LecturerID';
        }else{
            $table = 'student';
            $tableID = 'StudentID';
        }
         
         $lectureNameQuery = "select * from `{$table}` WHERE `{$tableID}`='{$_SESSION['user_id']}'";
         $fetchData = self::$mysqli->query($lectureNameQuery);

         $result_data = array();
         while($data = $fetchData->fetch_array()){
          
            $sql = "Select * from `class` WHERE ";
            if($id != null){
                $sql.=" `ClassID`= '{$id}' ";
            }
            if($id != null && $name != null){
                $sql.=" AND ";
            }

            if($name != null){
                $sql.=" `Classname`= '{$name}'";
            }

            $sql.=" AND `ClassID`='{$data['ClassID']}' ";
           
           
            if ($query = self::$mysqli->query($sql)){

            
                while ($row = $query->fetch_array()){
                
                
                    $result_data[] = array(
                        'id' => $row["ClassID"],
                        'name' => $row["Classname"],
                        'startTime' => $row["startTime"],
                        'endTime' => $row["endTime"],
                    );
                }
                

                return json_encode($result_data);
            }else{
                //when it fails
                echo "failed to fetch data";
            }
        }

         
    }
    public function getCourse(){
      //  $id = $_SESSION['schedule_id'];
        $lectureNameQuery = "select * from `Lecturer` WHERE `LecturerID`='{$_SESSION['user_id']}'";
        $fetchData = self::$mysqli->query($lectureNameQuery);
        $result_data = array();
        while ($data = $fetchData->fetch_array()) {
        $sql = "select * from `course` WHERE `CourseID`='{$data['ScheduleID']}'";
        if ($query = self::$mysqli->query($sql)){
           
            // $results = $query->fetch_assoc();
            while ($row = $query->fetch_array()){
                $result_data[] = array(
                    'id' => $row["ScheduleID"],
                    'title' => $row["CourseTitle"],
                    'code' => $row["CourseCode"],
                );
            }
            return json_encode($result_data);
        }else{
            //failed to fetch profiles table
        }
        }
        
    }
  
    public function getClassDetail(){
        $id = $_SESSION['schedule_id'];
        $lectureNameQuery = "select * from `Lecturer` WHERE `LecturerID`='{$_SESSION['user_id']}'";
        $fetchData = self::$mysqli->query($lectureNameQuery);
        $result_data = array();
        while ($data = $fetchData->fetch_array()) {
        $sql = "select * from `class` WHERE `ClassID`='{$data['ClassID']}'";
        if ($query = self::$mysqli->query($sql)){
           
            // $results = $query->fetch_assoc();
            while ($row = $query->fetch_array()){
                $result_data[] = array(
                    'id' => $row["ClassID"],
                    'title' => $row["Classname"],
                    'course' => $row["ClassID"],
                );
            }
            return json_encode($result_data);
        }else{
            //failed to fetch profiles table
        }
        }
        
    }

    public function getClasses(){
        $sql = "Select * from class WHERE `ClassID`='{$_SESSION['class_id']}'";
        if ($query = self::$mysqli->query($sql)){
    
            $result_data = array();
            while ($row = $query->fetch_array()){
                $result_data[] = array(
                    'id' => $row["ClassID"],
                    'name' => $row["Classname"],
                    'startTime' => $row["startTime"],
                    'endTime' => $row["endTime"]
                );
            }
    
            return json_encode($result_data);
        }else{
            //when it fails
            echo "failed to fetch data";
        }
    }

    public function startClass(){
        $username = $_SESSION['dyunilog'];
        $virtualClass = $_SESSION['class_id'];
        $file = $_FILES['file'];
        $fileName = $_POST['file_name'];
        $file_extension = pathinfo(basename($_FILES['file']['name']),PATHINFO_EXTENSION);
        $fileCompleteName = $fileName.".".$file_extension;

        $path = UPLOAD_PATH;
        $db_path ="../../uploads/".$fileCompleteName;
        $uploadFile = $this->uploadFile($path,$file,$fileCompleteName);
        if($uploadFile){
            $sql = "INSERT INTO `virtual_class` (`ClassID`,`files`) VALUES ('{$virtualClass}','{$db_path}')";
            if (self::$mysqli->query($sql)){
                $_SESSION['virtual_id'] = self::$mysqli->insert_id; 
                header("location: /dyuni/views/pages/lecturer/virtual.php?file={$db_path}#21fae7");
            }
        }else {
            //error code
        }
        
    }
    public function uploadFile($target_dir, $target_file,$name)
    {
        $target_directory = $target_dir;
        $file_target = $target_directory . $name;

            if (move_uploaded_file($target_file['tmp_name'],$file_target)){
                
                return true;
            }else{
               
                return false;
            }
        

    }
    
    public function upadtePassword($id,$pass){
        $hash_pass = md5($pass);
        $res = false;
        $sql = "UPDATE `lecturer` SET `Password`='{$hash_pass}' Where `LecturerID`='{$id}'";
        if ($query = self::$mysqli->query($sql)) {
            if(isset($_SESSION['admin']) && $_SESSION['admin']==1){
                header("location: /dyuni/views/?page=admin_lecturers&&success= Password has been updated");
            }else{
                header("location: /dyuni/views/?page=lecturer_account&&success= Password has been updated");
            }
           
        }else{
            if(isset($_SESSION['admin']) && $_SESSION['admin']==1){
                header("location: /dyuni/views/?page=admin_lecturers&&msg= failed to update Password");
            }else{
                header("location: /dyuni/views/?page=lecturer_account&&msg= failed to update Password");
            }
           
        }
    }

}