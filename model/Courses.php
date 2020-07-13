<?php

class Courses extends model{

    public function getCourses(){
        $sql = "Select * from course";
        if ($query = self::$mysqli->query($sql)){

            $result_data = array();
            while ($row = $query->fetch_array()){
                
                $result_data[] = array(
                    'id' => $row["CourseID"],
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

    public function getCourse($id){
        $sql = "Select * from course WHERE `CourseID`='{$id}'";
        if ($query = self::$mysqli->query($sql)){

            $result_data = array();
            while ($row = $query->fetch_array()){
                
                $result_data[] = array(
                    'id' => $row["CourseID"],
                    'title' => $row["CourseTitle"],
                    'code' => $row["CourseCode"],
                );
            }

            return $result_data;
        }else{
            //when it fails
            echo "failed to fetch data";
        }
    }

    public function getStudentClasses(){
        
    }

    public function geStudentCourses(){
        $sql = "Select * from schedule WHERE `ScheduleID`='{$_SESSION['schedule_id']}'";
        if ($query = self::$mysqli->query($sql)){

            $result_data = array();
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
        $sql = "Select * from `course` WHERE ";
        if($id != null){
            $sql.=" `CourseCode`= '{$id}' ";
        }
        if($id != null && $name != null){
            $sql.=" AND ";
        }

        if($name != null){
            $sql.=" `CourseTitle`= '{$name}'";
        }

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
    public function updateCourse(){
       
        //removing space and sql injection possible characters
        $courseTitle = $_POST['courseTitle'];
        $courseCode = $_POST['courseCode'];
        
        $course_id = htmlentities(trim($_POST['id']));
        echo $course_id;
      $sql = "UPDATE `course` SET  `CourseTitle`='{$courseTitle}',`CourseCode`='{$courseCode}' WHERE `CourseID`='{$course_id}' ";

      if (self::$mysqli->query($sql)){
        
        header("location: /dyuni/views/?page=admin_courses&&success=Course has been updated succesfully");
      }else{
          //when updating fails
          header("location: /dyuni/views/?page=admin_courses&&msg= failed to update course");
      }
    }

    public function deleteCourse(){
        $id = $_GET['id'];
        $sql = "DELETE FROM `course` WHERE `CourseID`='{$id}'";
      if (self::$mysqli->query($sql)){
        
        header("location: /dyuni/views/?page=admin_courses&&success=Course has been deleted succesfully");
      }else{
          //when updating fails
          header("location: /dyuni/views/?page=admin_courses&&msg= failed to delete user");
      }
    }
}