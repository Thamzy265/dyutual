<?php
require_once '../vendor/autoload.php';

require_once '../model/emergency.php';
require_once '../model/Blood.php';

class report
{
    public function generateReport($m){
        $mpdf = new \Mpdf\Mpdf();

        $emergency = new emergency();

        $Blood = new Blood();
        $blood = json_decode($Blood->fetchBlood(),true);
        if ($m=="current"){
            $month =  date('M Y', strtotime("this month"));
            $emer = json_decode($emergency->fetchEmergency('current'),true);
        }else{
            $month =  date('M Y', strtotime("last month"));
            $emer = json_decode($emergency->fetchEmergency('last'),true);
        }

        $data = "<h1>REPORT FOR THE MONTH OF {$month} </h1>";

        //emergencies for the month
        $data.="<h4>Emergencies</h4>";
        $data.= " <table class=\"table\">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Region</th>
            <th>Blood Group</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>";

        $i= 1;
        foreach ($emer as $user) {

            $data .= "<tr>";
            $data .= "<td>$i</td>";
            $data .= "<td> {$user['name']}</td>";
            $data .= "<td> {$user['blood']}</td>";
            $data .= "<td>{$user['region']}</td>";
            $data .= "<td>{$user['time']}</td>";

            $data .= "</tr>";
            $i++;
        }
        $data.= " </tbody> </table>";
        //blood count for the month
        $data.="<h4>Blood Inventory</h4>";
        $data.= " <table class=\"table\">
        <thead>
        <tr>
            <th>#</th>
             <th>Blood Type</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>";

        $i= 1;
        foreach ($blood as $bg) {

            $data .= "<tr>";
            $data .= "<td>$i</td>";
            $data .= "<td> {$bg['blood']}</td>";
            $data .= "<td> {$bg['quantity']}</td>";

            $data .= "</tr>";
            $i++;
        }
        $data.= " </tbody> </table>";

        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }

}