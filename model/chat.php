<?php
require_once "db.php";

class chat extends model{

    public function createMessages(){
       
        $username = $_SESSION['dyunilog'];
        $virtualClass = $_SESSION['virtual_id'];
        $message = $_POST['message'];

        $sql = "INSERT INTO `chat` (`virtualClassID`, `username`, `message`) VALUES ('{$virtualClass}','{$username}','{$message}')";
        if (self::$mysqli->query($sql)){
            echo"worked";
        }else {
            echo"didnti";
        }
    }

    public function displayText(){
        //where virtualClassID is equal to virtualClassID
        $virtualClass = $_SESSION['virtual_id'];
        $sql = "Select * from chat where virtualClassID = '{$virtualClass}'";
        if ($query = self::$mysqli->query($sql)){
    
            $result_data = array();
            while ($row = $query->fetch_array()){
                
                    echo $row['username']." : ".$row['message'] ."&#13;";
                    
                
            }
        }else{
            //when it fails
            echo "failed to fetch data";
        }
    }

    public function getParticipantList(){
        $virtualClass = $_SESSION['virtual_id'];
        $sql = "Select * from participants where virtualClassID = '{$virtualClass}'";
        if ($query = self::$mysqli->query($sql)){

            $count= $query->num_rows;

            echo "<h5 class='text-info'>Participants[{$count}]</h5>";
            echo " <div class='participants'>";

            while ($row = $query->fetch_array()){
                 echo  $row['username']." </br>";       
                
            }
            echo "</div>";
        }else{
            //when it fails
            echo "failed to fetch data";
        }
    }




}