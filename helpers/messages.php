<?php
require "../vendor/autoload.php";
require "../model/group.php";

class messages extends model
{

    public function sendSms(){
        $group = new group();
        $data = json_decode($group->fetchUsers(),true);

        $body = "There is an emergency in your area, A donor with your blood type is needed";

        //after message is sent the emergency table will be filled with details
        $this->emergencyTbl();
        /*
        foreach ($data as $user) {
            $this->twiSms($user['pnumber'],$body);
        }*/
        header('location: /blood/views/?page=home&&success=Emergency sms has been sent');
    }
    public function sendCollectionSms($region,$location){
        $group = new group();
        $data = json_decode($group->region($region),true);

        $body = "There will be blood collection at {$location}";

        /*
        foreach ($data as $user) {
            $this->twiSms($user['pnumber'],$body);
        }*/
        header('location: /blood/views/?page=admin&&success=Blood Collection sms has been sent');
    }

    public function twiSms($numbers,$body){

        $sid = "ACabdc0b044807cfae195afded0d333417"; // Your Account SID from www.twilio.com/console
        $token = "93d6b86c63fb3454522557070dd88b1c"; // Your Auth Token from www.twilio.com/console

        $client = new Twilio\Rest\Client($sid, $token);
        $message = $client->messages->create(
            '+265884106910', // Text this number
            array(
                'from' => '+12078020244', // From a valid Twilio number
                'body' => $body
            )
        );

        print $message->sid;
    }

    public function emergencyTbl(){

        //This updating the emergency table
        $user_id = sessionHelper::getSession('user_id');
        $sql = "select * from `profiles` WHERE `user_id`='{$user_id}'";

        if ($query = self::$mysqli->query($sql)){
            $result = $query->fetch_assoc();
            $sql = "INSERT INTO `emergency` (`user_id`,`region_id`,`blood_group_id`) VALUES ('{$user_id}','{$result['region_id']}','{$result['blood_group_id']}')";
            if (self::$mysqli->query($sql)){
                return true;
            }else{
                return false;
            }
        }else{
            //if failed to query user profile

        }
    }
}