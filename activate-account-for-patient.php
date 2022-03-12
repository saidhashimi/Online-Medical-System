<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 14-Aug-20
 * Time: 1:15 PM
 */

    require_once ("database-connection.php");
    session_start();


    if (isset($_REQUEST['username'])){

        $username=$_REQUEST['username'];
        $getDetails=$con->query("select * from users where user_username='$username'")->fetch_array();

        if ($getDetails['user_status']=='unapproved') {
            $updateUserDetails = $con->query("update users set user_status='approved' where user_username='$username'");
            setcookie("username",$username);
            header("location:patient-dashboard.php?autologin");
            return;
        }else{
            setcookie("username",$username);
            header("location:patient-dashboard.php");
            return;
        }



    }else{
        header("location: index.php");
        return;
    }

?>