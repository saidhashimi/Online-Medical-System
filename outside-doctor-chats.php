<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 03-Aug-20
 * Time: 10:46 PM
 */

require_once ("database-connection.php");
session_start();

if (!isset($_COOKIE['username'])){
    header("location:login.php");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}


$username=$_SESSION['username'];
date_default_timezone_set("Asia/Kabul");
$doc=$con->query("select * from users where user_username='$username'")->fetch_array();

$doc_user_id=$doc['user_id'];
$doctorDetails=$con->query("select * from outsidedoctor where email='$username'")->fetch_array();
$doctorProfile=$con->query("select * from doctorprofile where user_id='$doc_user_id'")->fetch_array();
$doctorImage=$con->query("select file_name from pictures where user_id='$doc_user_id'")->fetch_array()['file_name'];

/*
  Chat Section
 */

$noSelect=true;
$msg=null;
$fromList=$con->query("select * from chat_message where to_user_id='$doc_user_id' and status='not seen'");

if (isset($_REQUEST['msg'])){
    $noSelect=false;
    $msg=$_REQUEST['msg'];

    $con->query("update chat_message set status='seen' where from_user_id='$msg'");

}

$msgHistory=$con->query("select * from chat_message where from_user_id='$msg' and to_user_id='$doc_user_id' or to_user_id='$msg' and from_user_id='$doc_user_id'");
$fromListSeen=$con->query("select * from chat_message where to_user_id='$doc_user_id' and status='seen'");


$listOfID=array();
$listOfMessages=array();

if (isset($_REQUEST['send'])){
    $message=$_REQUEST['newMessage'];
    $date=date("Y-m-d h:i:s");
    $mm=$_REQUEST['msg'];
    $con->query("insert into chat_message values ('','$mm','$doc_user_id','$message','$date','not seen')");
    header("location:outside-doctor-chats.php?msg=$msg");
    return;
}


?>



<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Doctor Chat Box - Health Guide</title>

    <link href="assets/img/favicon.png" rel="icon">



    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/chat.css">

</head>
<body>
<div class="main-wrapper">
    <!--Header Part-->
    <header class="header">
        <nav class="navbar navbar-expand-lg header-nav">
            <!---Logo-->
            <div class="navbar-header">
                <a href="index.php" class="navbar-brand logo"><img src="assets/img/logo1.png"   class="img-fluid" alt="Logo"></a>
            </div>
            <ul class="nav header-navbar-rht">
                <!-- User Menu -->
                <li class="nav-item dropdown has-arrow logged-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
									<img class="rounded-circle" src="assets/img/doctors/<?=$doctorImage?>" width="31" alt="<?=$doctorDetails['firstname']?>">
								</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="assets/img/doctors/<?=$doctorImage?>" alt="User Image" class="avatar-img rounded-circle">
                            </div>
                            <div class="user-text">
                                <h6>Dr. <?php echo $doctorDetails['firstname'] ?></h6>
                                <p class="text-muted mb-0">Outside Doctor</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="outside-doctor-dashboard.php">Dashboard</a>
                        <a class="dropdown-item" href="outside-doctor-profile-setting.php" >Profile Settings</a>
                        <a class="dropdown-item" href="logout.php?doctor">Logout</a>
                    </div>
                </li>
                <!-- /User Menu -->

            </ul>
        </nav>


    </header>
    <!--/Header-->
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar" style="display: <?php if ($breadCumpShow==false){ echo "none"; }  ?> ">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item active" aria-current="page"><a href="outside-doctor-dashboard.php"> Dashboard</a> / chat messenger</li>
                        </ol>
                    </nav>
                    <h3 class="breadcrumb-title">Messenger</h3>

                </div>
            </div>
        </div>
    </div>


    <div class="container mt-3">

        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4>Messages</h4>
                        </div>

                    </div>
                    <div class="inbox_chat">
                        <div class="text-md-center bg-success-light"><small><strong>Not Seen</strong></small></div>
                        <div class="text-md-center mt-1 <?php if (mysqli_num_rows($fromList)>0){echo 'd-none'; } ?>"><small class="bg-info-light">No New Messages</small></div>
                        <?php

                        while ($row=$fromList->fetch_array()) {

                            if (in_array($row['from_user_id'],$listOfID)){
                                continue;
                            }else {
                                $userid = $row['from_user_id'];
                                $userImage = $con->query("select file_name from pictures where user_id='$userid'")->fetch_array()['file_name'];
                                $userDetails = $con->query("select * from users where user_id='$userid'")->fetch_array();

                                /*
                            * Last Time Stamp
                            */
                                $ms=$row['from_user_id'];
                                $selectLastMessage=$con->query("select * from chat_message where from_user_id='$ms' and to_user_id='$doc_user_id' or to_user_id='$ms' and from_user_id='$doc_user_id'");
                                $lastRow=mysqli_num_rows($selectLastMessage);
                                $i=0;

                                while ($rr=$selectLastMessage->fetch_array()){

                                    if (++$i==$lastRow){
                                        $row['timestamp']=$rr['timestamp'];
                                    }
                                }

                                $dd = date("d", strtotime($row['timestamp']));

                                $todayDate = date("d");
                                $yesterday = date("d", strtotime("-1 days"));

                                $dateDetails = null;
                                if ($todayDate == $dd) {
                                    $dateDetails = date("h:i a", strtotime($row['timestamp']));
                                } elseif ($yesterday == $dd) {
                                    $dateDetails = "Yesterday";
                                } else {
                                    $dateDetails = date("M d", strtotime($row['timestamp']));
                                }

                                $from=$row['from_user_id'];

                                $selectCounter=$con->query("select * from chat_message where from_user_id='$from' and status='not seen'");
                                $counter=mysqli_num_rows($selectCounter);
                                ?>
                                <a href="outside-doctor-chats.php?msg=<?= $row['from_user_id'] ?>">
                                    <div class="chat_list <?php if ($row['from_user_id'] == $msg) {
                                        echo 'active_chat';
                                    } ?>">
                                        <div class="chat_people">
                                            <div class="avatar avatar-sm float-left">
                                                <img src="assets/img/patients/<?=$userImage?>" alt="Image" class="avatar-img rounded-circle">
                                            </div>
                                            <div class="chat_ib">
                                                <h5><strong><?= $userDetails['user_name'] ?><small class="ml-4 btn-sm rounded-circle bg-success-light"><strong><?=$counter?></strong></small> <span
                                                            class="chat_date"><?= $dateDetails ?></span></strong>
                                                </h5>
                                                <?php
                                                $ms=$row['from_user_id'];
                                                $selectLastMessage=$con->query("select * from chat_message where from_user_id='$ms' and to_user_id='$doc_user_id' or to_user_id='$ms' and from_user_id='$doc_user_id'");
                                                $lastRow=mysqli_num_rows($selectLastMessage);
                                                $i=0;
                                                $selectMessage=null;
                                                while ($rr=$selectLastMessage->fetch_array()){

                                                    if (++$i==$lastRow){
                                                        if (($rr['to_user_id']==$msg) && ($rr['from_user_id']==$doc_user_id)){
                                                            $selectMessage='You: '.$rr['message'];
                                                        }else{
                                                            $selectMessage=$rr['message'];
                                                        }

                                                    }
                                                }

                                                ?>
                                                <p><strong><?= $selectMessage ?></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <?php
                                array_push($listOfID,$row['from_user_id']);
                            }
                        }
                        ?>

                        <div class="text-md-center bg-primary-light mt-2"><small><strong>Seened</strong></small></div>
                        <?php
                        while ($row=$fromListSeen->fetch_array()) {

                            if (in_array($row['from_user_id'],$listOfID)){

                                continue;
                            }else {
                                $userid = $row['from_user_id'];
                                $userImage = $con->query("select file_name from pictures where user_id='$userid'")->fetch_array()['file_name'];
                                $userDetails = $con->query("select * from users where user_id='$userid'")->fetch_array();

                                /*
                                 * Last Time Stamp
                                 */
                                $ms=$row['from_user_id'];
                                $selectLastMessage=$con->query("select * from chat_message where from_user_id='$ms' and to_user_id='$doc_user_id' or to_user_id='$ms' and from_user_id='$doc_user_id'");
                                $lastRow=mysqli_num_rows($selectLastMessage);
                                $i=0;

                                while ($rr=$selectLastMessage->fetch_array()){

                                    if (++$i==$lastRow){
                                        $row['timestamp']=$rr['timestamp'];
                                    }
                                }

                                $dd = date("d", strtotime($row['timestamp']));

                                $todayDate = date("d");
                                $yesterday = date("d", strtotime("-1 days"));

                                $dateDetails = null;
                                if ($todayDate == $dd) {
                                    $dateDetails = date("h:i a", strtotime($row['timestamp']));
                                } elseif ($yesterday == $dd) {
                                    $dateDetails = "Yesterday";
                                } else {
                                    $dateDetails = date("M d", strtotime($row['timestamp']));
                                }


                                ?>
                                <a href="outside-doctor-chats.php?msg=<?= $row['from_user_id'] ?>">
                                    <div class="chat_list <?php if ($row['from_user_id'] == $msg) {
                                        echo 'active_chat';
                                    } ?>">
                                        <div class="chat_people">
                                            <div class="avatar avatar-sm float-left">
                                                <img src="assets/img/patients/<?=$userImage?>" alt="User Image" class="avatar-img rounded-circle">
                                            </div>
                                            <div class="chat_ib">
                                                <h5><strong><?= $userDetails['user_name'] ?> </strong><span
                                                        class="chat_date"><?= $dateDetails ?></span>
                                                </h5>
                                                <?php
                                                $ms=$row['from_user_id'];
                                                $selectLastMessage=$con->query("select * from chat_message where from_user_id='$ms' and to_user_id='$doc_user_id' or to_user_id='$ms' and from_user_id='$doc_user_id'");
                                                $lastRow=mysqli_num_rows($selectLastMessage);
                                                $i=0;
                                                $selectMessage=null;
                                                while ($rr=$selectLastMessage->fetch_array()){

                                                    if (++$i==$lastRow){
                                                        if (($rr['to_user_id']==$ms) && ($rr['from_user_id']==$doc_user_id)){
                                                            $selectMessage='You: '.$rr['message'];
                                                        }else{
                                                            $selectMessage=$rr['message'];
                                                        }

                                                    }
                                                }

                                                ?>
                                                <p><?= $selectMessage ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <?php
                                array_push($listOfID,$row['from_user_id']);
                            }
                        }
                        ?>

                    </div>
                </div>
                <div class="mesgs <?php if ($noSelect==true){echo 'd-none';} ?>">
                    <div class="msg_history" id="msg_history">
                        <?php
                        while($row=$msgHistory->fetch_array()) {

                            $dd=date( "d", strtotime( $row['timestamp'] ) );
                            $today=date("d");
                            $yesterday=date("d",strtotime("-1 days"));
                            $jj=null;

                            if ($today==$dd){
                                $jj="Today";
                            }elseif ($yesterday==$dd){
                                $jj="yesterday";
                            }else{
                                $jj=date("M d",strtotime($row['timestamp']));
                            }

                            $userImage=$row['from_user_id'];
                            $userImage=$con->query("select file_name from pictures where user_id='$userImage'")->fetch_array()['file_name'];
                            if ($row['from_user_id']==$msg) {
                                ?>
                                <div class="incoming_msg mt-4">
                                    <div class="avatar avatar-sm float-left">
                                        <img src="assets/img/patients/<?=$userImage?>" alt="Image" class="avatar-img rounded-circle">
                                    </div>
                                    <div class="received_msg">
                                        <div class="received_withd_msg">
                                            <p><?=$row['message']?></p>
                                            <span class="time_date"> <?php echo date("h:i a",strtotime($row['timestamp'])); ?>    |    <?=$jj ?></span></div>
                                    </div>
                                </div>
                                <?php
                            }else {
                                ?>


                                <div class="outgoing_msg">
                                    <div class="sent_msg">
                                        <p><?=$row['message']?></p>
                                        <span class="time_date"> <?php echo date("h:i a",strtotime($row['timestamp'])); ?>    |    <?=$jj ?></span></div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <form action="outside-doctor-chats.php" method="post">
                        <div class="type_msg">
                            <div class="input_msg_write">
                                <input type="hidden" name="msg" value="<?=$msg?>">
                                <input type="text" class="write_msg" name="newMessage" placeholder="Type a message" />
                                <button class="msg_send_btn" type="submit" name="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                            </div>
                        </div>
                    </form>
                </div>

            </div>



        </div></div>


</div>




<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script type="text/javascript">
    var objDiv = document.getElementById("msg_history");
    objDiv.scrollTop = objDiv.scrollHeight;
</script>


</body>

</html>



