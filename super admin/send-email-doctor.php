<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 11-Jul-20
 * Time: 1:35 PM
 */

require_once "database-connection.php";
if (isset($_REQUEST['email'])){
    $to=$_REQUEST['email'];
    $subject="Approve Your Health Guide Account";


// Message
    $message = "
<html>
<head>
  <title>Approve Your Health Guide Account</title>
</head>
<body>
  <h3>Here is the link to activate your health guide account:</h3>
   <a href='http://localhost/fyp%20project/activate-account-outside-doctor.php?username=$to'>Click Here To Activate Account</a>
   <p>Thanks</p>
</body>
</html>
";

    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers

    $headers[] = 'From: Health Guide <saidmuqeemhashimi@gmail.com>';


    if(mail($to,$subject,$message,implode("\r\n", $headers))){
        header("location:register-outside-doctor.php?success");
        return;
    }else{
        header("location:register-outside-doctor.php?notsuccess");
        return;
    }




}


?>