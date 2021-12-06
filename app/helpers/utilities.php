<?php

namespace App\helpers;

class Utilities
{
    public static function checklicense()
    {
        //include('licensekey.php');
        $licensekey = 'd5d1fe31a316eb8e499a3f87072be63c';
        $data = array('k' => $licensekey);
        $url = "http://www.mydistance-learning-college.com/control/checklicense.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $response = json_decode($output);
        if ($response->code != 'SITE_ACTIVE') {
            //	echo $response->message;
            //		exit();
        }
    }

    public static function getannouncements()
    {
        //include('licensekey.php');
        $licensekey = 'd5d1fe31a316eb8e499a3f87072be63c';
        $data = array('k' => $licensekey);
        $url = "http://www.mydistance-learning-college.com/control/getannouncements.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $response = json_decode($output);
        return $response;
    }

    public static function getexpiry()
    {
        //include('licensekey.php');
        $licensekey = 'd5d1fe31a316eb8e499a3f87072be63c';
        $data = array('k' => $licensekey);
        $url = "http://www.mydistance-learning-college.com/control/getexpiry.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $output;
    }

    //misc setting records from table
    public static function get_settings($key)
    {
        global $db;
        $setting = false;
        $sql = "select * from settings where Name = '$key'";
        $myrs = mysql_query($sql);
        if ($row = mysql_fetch_array($myrs)) {
            $setting = $row['Value'];
        }
        return $setting;
    }


}
