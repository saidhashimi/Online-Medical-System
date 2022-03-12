<?php
    $server="localhost";
    $username="root";
    $password="";
    $db="onlinehealthguide";


    $con=new mysqli($server,$username,$password,$db);

    if($con->connect_error){
        echo("Could not connect: ERROR NO. " . $con->connect_errno . " : " . $con->connect_error . "<br/>");
        die ("Error while connecting to database. Further script processing terminated <br/>");
    }
    

?>