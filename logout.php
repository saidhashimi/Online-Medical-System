<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 10-Jul-20
 * Time: 12:32 PM
 */

    session_start();


    if (isset($_REQUEST['patient'])){
        setcookie("username", "", time() - 10);
        unset($_SESSION['username']);
        header("location:index.php");
        return;
    }elseif (isset($_REQUEST['doctor'])){
        setcookie("username", "", time() - 10);
        unset($_SESSION['username']);
        header("location:login.php");
        return;
    }else{
        setcookie("username", "", time() - 10);
        unset($_SESSION['username']);
        header("location:index.php");
        return;
    }

?>