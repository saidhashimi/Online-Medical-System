<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 20-Aug-20
 * Time: 3:53 PM
 */

    require_once "database-connection.php";


    $date=$_REQUEST['date'];
    $doc_id=$_REQUEST['doc_id'];

    $date=date("D",strtotime($date));
    $slots=null;
    $return_arr=array();
    if ($date=="Sat"){
        $slots=$con->query("select * from doctorslots where saturday='yes' and user_id='$doc_id'");
    }elseif ($date=="Sun"){
    $slots=$con->query("select * from doctorslots where sunday='yes' and user_id='$doc_id'");
}elseif ($date=="Mon"){
        $slots=$con->query("select * from doctorslots where monday='yes' and user_id='$doc_id'");
    }elseif ($date=="Tue"){
        $slots=$con->query("select * from doctorslots where tuesday='yes' and user_id='$doc_id'");
    }elseif ($date=="Wed"){
        $slots=$con->query("select * from doctorslots where wednesday='yes' and user_id='$doc_id'");
    }elseif ($date=="Thu"){
        $slots=$con->query("select * from doctorslots where thursday='yes' and user_id='$doc_id'");
    }


    while ($row=$slots->fetch_array()){

        echo $row['start_time']."-".$row['end_time'].",";

    }






?>