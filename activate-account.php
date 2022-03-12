<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 11-Jul-20
 * Time: 2:24 PM
 */

    require_once ("database-connection.php");
    if (isset($_REQUEST['username'])){
        $username=$_REQUEST['username'];
        $doc_id=$con->query("select doc_id from doctor where doc_email='$username'")->fetch_array()['doc_id'];

        mysqli_query($con,"update users set user_status='approved',doc_id='$doc_id' where user_username='$username' and user_type='doctor'");
        setcookie("username",$username);
        header("location:doctor-dashboard.php?autologin");
        return;
    }


?>