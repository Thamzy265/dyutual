<?php
/**
 * WARNING: This file is not used.
 *
 * It is a copy from the Blood Bank project. No file in DYUni includes it. It
 * also includes two files that are not in this project:
 * `../vendor/autoload.php` and `../model/group.php`. You can delete this file.
 *
 * The Twilio credentials that were in this file are removed. They are now in
 * the file `.env`.
 */
require "../vendor/autoload.php";
require_once __DIR__ . '/env.php';
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

        // The credentials come from the file `.env` in the root folder.
        $sid   = env('TWILIO_ACCOUNT_SID');  // The Account SID from www.twilio.com/console
        $token = env('TWILIO_AUTH_TOKEN');   // The Auth Token from www.twilio.com/console
        $from  = env('TWILIO_FROM_NUMBER');  // A valid Twilio telephone number

        // Do nothing if the credentials are absent.
        if (empty($sid) || empty($token) || empty($from)) {
            error_log('Twilio is not configured. Set the TWILIO_ keys in the file .env');
            return false;
        }

        try {
            $client = new Twilio\Rest\Client($sid, $token);
            $message = $client->messages->create(
                $numbers, // The telephone number of the receiver
                array(
                    'from' => $from,
                    'body' => $body
                )
            );

            return $message->sid;
        } catch (Exception $e) {
            error_log('Failed to send the SMS message: ' . $e->getMessage());
            return false;
        }
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