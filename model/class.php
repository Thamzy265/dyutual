<?php

class classes extends model{

public function getClasses(){
    $sql = "Select * from class";
    if ($query = self::$mysqli->query($sql)){

        $result_data = array();
        while ($row = $query->fetch_array()){

            $Sql = "select * from `course` where `CourseID`='{$row["CourseID"]}'";
            $couseQuery = self::$mysqli->query($Sql);
            $course = $couseQuery->fetch_assoc();

            $result_data[] = array(
                'id' => $row["ClassID"],
                'name' => $row["Classname"],
                'course'=>$course["CourseTitle"],
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
public function getClassesWithLec($id){
    $sql ="select * from `class` where `CourseID`='{$id}'";
    $query = self::$mysqli->query($sql);
    //Getting course
    $course = new Courses();
    $co =  $course->getCourse($id);

    $result_data = array();
    while($row = $query->fetch_array()){

        $id = $row['ClassID'];
      
        $lecSql = "select * from `lecturer` Where `ClassID`= {$id}";
        $lecQuery = self::$mysqli->query($lecSql);
        $lecRow = $lecQuery->fetch_array();
        $lectureName = $lecRow['Fname']." ".$lecRow['Sname'];
      
        $result_data[] =array(
            'id'=>$row['ClassID'],
            'name'=>$row['Classname'],
            'startTime'=>$row['startTime'],
            'endTime'=>$row['endTime'],
            'lecturer'=>$lectureName,
            'course'=>$co[0]['title']
        );
    }
  
    return $result_data;
}

public function getClassesByCourse($id)
{
    $sql = "Select * from class WHERE `CourseID`='{$id}'";
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

        return $result_data;
    }else{
        //when it fails
        echo "failed to fetch data";
    }
}

public function getClass($id){
    $sql = "Select * from class WHERE `ClassID`='{$id}'";
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

public function searchClass($id,$name){
    
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

    
   
   
    if ($query = self::$mysqli->query($sql)){

    
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

public function AddClass(){
    $className = $_GET['classname'];
    $course = $_GET['course'];
    $startTime = $_GET['startTime'];
    $endTime = $_GET['endTime'];
    $adminID = $_SESSION['user_id'];
    $sql = "INSERT INTO `class` (`Classname`,`CourseID`,`startTime`,`endTime`,`AdminID`) VALUES ('{$className}',{$course},'{$startTime}','{$endTime}','{$adminID}')";
    if (self::$mysqli->query($sql)){
          
        header("location: /dyuni/views?page=admin_classes&&success=Class has been added");
 
    }else{
        //if user fails to register to the admin table
        header("location: /dyuni/views?page=admin_classes&&msg=Class was not added");

    }
}

public function updateClass(){

    //removing space and sql injection possible characters
    $className = $_POST['classname'];
  
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $class_id = htmlentities(trim($_POST['id']));
  
  $sql = "UPDATE `class` SET `Classname`='{$className}',`startTime`='{$startTime}',`endTime`='$endTime' WHERE `ClassID`='{$class_id}' ";

  if (self::$mysqli->query($sql)){
    
    header("location: /dyuni/views/?page=admin_classes&&success=Class has been updated");
  }else{
      //when updating fails
      header("location: /dyuni/views/?page=admin_classes&&msg=Class was not updated");
  }
}

public function deleteClass(){
    $id = $_GET['id'];
    $sql = "DELETE FROM `class` WHERE `ClassID`='{$id}'";
  if (self::$mysqli->query($sql)){
    
    header("location: /dyuni/views/?page=admin_classes&&success=Course has been deleted succesfully");
  }else{
      //when updating fails
      header("location: /dyuni/views/?page=admin_classes&&msg= failed to delete course");
  }
}

}
