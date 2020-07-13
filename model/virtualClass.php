<?php
require_once "db.php";

class virtualClass extends model{

    public function createMessages(){
        $username = $_SESSION['username'];
        $virtualClass = $_SESSION['virtualClass'];
        $message = $_POST['message'];

        $sql = "INSERT INTO `virtual_clas` (`classID`, `files`,) VALUES ('{$classID}','{$files}')";
        if (self::$mysqli->query($sql)){
            return true;
        }
    }

    public function displayText(){
        $sql = "Select * from chat";
        if ($query = self::$mysqli->query($sql)){
    
            $result_data = array();
            while ($row = $query->fetch_array()){
                $result_data[] = array(
                    'id' => $row["id"],
                    'class' => $row["virtualClassID"],
                    'username' => $row["username"],
                    'message' => $row["messages"],
                );
            }
    
            return json_encode($result_data);
        }else{
            //when it fails
            echo "failed to fetch data";
        }
    }

   


}