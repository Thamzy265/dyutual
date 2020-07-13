<?php

require_once "db.php";

class adminUsers extends model
{
    public function deleteUser($id){
        $user_id = $id;
        //first delete from user table
        $sql = "DELETE FROM  `users` WHERE `id`={$user_id}";
        if (self::$mysqli->query($sql)) {
            //if succesful delete in profiles table
            $sql = "DELETE FROM  `profiles` WHERE `user_id`={$user_id}";
            if (self::$mysqli->query($sql)) {
                //when succesful
                header('location: /blood/views/?page=admin_accounts&&success=User has been deleted');
            }
        } else {
            //if failed in users table
            header('location: /blood/views/?page=admin_accounts&&msg=There is a problem deactivating your account');
        }
    }

    public function fetchUsers(){

            $sql = "select * from  `profiles`";

            if ($query = self::$mysqli->query($sql)){
                $result_data = array();
                // $results = $query->fetch_assoc();
                while ($row = $query->fetch_array()){
                    $result_data[] = array(
                        'id' => $row["id"],
                        'fname' => $row["first_name"],
                        'lname' => $row["last_name"],
                        'email' => $row["email"],
                        'pnumber' => $row["phone_number"],
                    );
                }

                return json_encode($result_data);
            }else{
                //when it fails
                echo "failed to fetch data";
            }
    }

    public function fetchAdmin(){

            $sql = "select * from  `admin`";

            if ($query = self::$mysqli->query($sql)){
                $result_data = array();
                // $results = $query->fetch_assoc();
                while ($row = $query->fetch_array()){
                    $result_data[] = array(
                        'id' => $row["id"],
                        'fname' => $row["first_name"],
                        'lname' => $row["last_name"],
                    );
                }

                return json_encode($result_data);
            }else{
                //when it fails
                echo "failed to fetch data";
            }
    }

    
    public function upadtePassword($id,$pass){
        $hash_pass = md5($pass);
        $res = false;
        $sql = "UPDATE `admin` SET `Password`='{$hash_pass}' Where `AdminID`='{$id}'";
        if ($query = self::$mysqli->query($sql)) {
           $res = true;
        }else{
            $res = false;
        }
    }

}