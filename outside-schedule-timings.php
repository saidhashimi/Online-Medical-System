<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 27-May-20
 * Time: 8:42 PM
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
$doctorID=$con->query("select user_id from users where user_username='$username'")->fetch_array()['user_id'];

if (isset($_REQUEST['save'])){
    $startTime=$_REQUEST['startTime'];
    $endTime=$_REQUEST['endTime'];


    if ($_REQUEST['day']=='sat'){

        $checkingslot=mysqli_num_rows($con->query("select * from doctorslots where user_id='$doctorID' and start_time='$startTime' and end_time='$endTime' and saturday='yes'"));

        if ($checkingslot>0){
            header("location:outside-schedule-timings.php?avaliable");
            return;
        }elseif (!$result=mysqli_query($con,"insert into doctorslots values ('$doctorID','$startTime','$endTime','yes',null ,null ,null ,null ,null ,null)")){
            header("location: outside-schedule-timings.php?fail");
            return;
        }else{
            header("location: outside-schedule-timings.php?success");
            return;
        }
    }elseif ($_REQUEST['day']=='sun'){
        $checkingslot=mysqli_num_rows($con->query("select * from doctorslots where user_id='$doctorID' and start_time='$startTime' and end_time='$endTime' and sunday='yes'"));

        if ($checkingslot>0){
            header("location:outside-schedule-timings.php?day=sun&avaliable");
            return;
        } elseif (!$result=mysqli_query($con,"insert into doctorslots values ('$doctorID','$startTime','$endTime',null ,'yes' ,null ,null ,null ,null ,null)")){
            header("loction: outside-schedule-timings.php?fail");
            return;
        }else{ header("location: outside-schedule-timings.php?day=sun&success");
            return;
        }
    }elseif ($_REQUEST['day']=='mon'){
        $checkingslot=mysqli_num_rows($con->query("select * from doctorslots where user_id='$doctorID' and start_time='$startTime' and end_time='$endTime' and monday='yes'"));

        if ($checkingslot>0){
            header("location:outside-schedule-timings.php?day=mon&avaliable");
            return;
        } elseif (!$result=mysqli_query($con,"insert into doctorslots values ('$doctorID','$startTime','$endTime',null ,null ,'yes' ,null ,null ,null ,null)")){
            header("location: outside-schedule-timings.php?fail");
            return;
        }else{ header("location: outside-schedule-timings.php?day=mon&success");
            return;
        }
    }elseif ($_REQUEST['day']=='tue'){
        $checkingslot=mysqli_num_rows($con->query("select * from doctorslots where user_id='$doctorID' and start_time='$startTime' and end_time='$endTime' and tuesday='yes'"));

        if ($checkingslot>0){
            header("location:outside-schedule-timings.php?day=tue&avaliable");
            return;
        } elseif (!$result=mysqli_query($con,"insert into doctorslots values ('$doctorID','$startTime','$endTime',null ,null ,null ,'yes' ,null ,null ,null)")){
            header("location: outside-schedule-timings.php?fail");
            return;
        }else{ header("location: outside-schedule-timings.php?day=tue&success");
            return;
        }
    }elseif ($_REQUEST['day']=='wed'){
        $checkingslot=mysqli_num_rows($con->query("select * from doctorslots where user_id='$doctorID' and start_time='$startTime' and end_time='$endTime' and wednesday='yes'"));

        if ($checkingslot>0){
            header("location:outside-schedule-timings.php?day=wed&avaliable");
            return;
        } elseif (!$result=mysqli_query($con,"insert into doctorslots values ('$doctorID','$startTime','$endTime',null ,null ,null ,null ,'yes' ,null ,null)")){
            header("location: outside-schedule-timings.php?fail");
            return;
        }else{ header("location: outside-schedule-timings.php?day=wed&success");
            return;
        }
    }elseif ($_REQUEST['day']=='thr'){
        $checkingslot=mysqli_num_rows($con->query("select * from doctorslots where user_id='$doctorID' and start_time='$startTime' and end_time='$endTime' and thursday='yes'"));

        if ($checkingslot>0){
            header("location:outside-schedule-timings.php?day=thr&avaliable");
            return;
        } elseif (!$result=mysqli_query($con,"insert into doctorslots values ('$doctorID','$startTime','$endTime',null ,null ,null ,null ,null ,'yes' ,null)")){
            header("location: outside-schedule-timings.php?fail");
            return;
        }else{ header("location: outside-schedule-timings.php?day=thr&success");
            return;
        }
    }elseif ($_REQUEST['day']=='fri'){
        if (!$result=mysqli_query($con,"insert into doctorslots values ('$doctorID','$startTime','$endTime',null ,null ,null ,null ,null ,null ,'yes')")){
            header("location: outside-schedule-timings.php?fail");
            return;
        }else{ header("location: outside-schedule-timings.php?day=fri&success");
            return;
        }
    }

}

elseif (isset($_REQUEST['dd'])){
    $start_time=$_REQUEST['start_time'];
    $end_time=$_REQUEST['end_time'];
    $dd=$_REQUEST['dd'];

    if(!$result=mysqli_query($con,"delete from doctorslots where start_time='$start_time' and end_time='$end_time' and ".$dd."='yes'")){
        header("location: outside-schedule-timings.php?deletefail");
        return;
    }else{
        $day=$_REQUEST['day'];
        header("location:outside-schedule-timings.php?day=$day&deleted");
        return;
    }
}






$username=$_SESSION['username'];

$doc=$con->query("select * from users where user_username='$username'")->fetch_array();

$doc_user_id=$doc['user_id'];
$doctorDetails=$con->query("select * from outsidedoctor where email='$username'")->fetch_array();
$doctorProfile=$con->query("select * from doctorprofile where user_id='$doc_user_id'")->fetch_array();
$doctorImage=$con->query("select file_name from pictures where user_id='$doc_user_id'")->fetch_array()['file_name'];



/*
 * Messages Counter
 */
$counterMessages=$con->query("select * from chat_message where to_user_id='$doc_user_id' and status='not seen'");
$counter=mysqli_num_rows($counterMessages);


//Counter Area
$countTotalPatient=mysqli_num_rows($con->query("select distinct user_id,visitor_id from appointments where doc_user_id='$doc_user_id'"));


//Today Appointments

$today=date("d M Y");
$todayAppointments=$con->query("select * from appointments where doc_user_id='$doc_user_id' and date='$today' and (status='unapproved' or status='approved')");

$counterTodayPatient=mysqli_num_rows($todayAppointments);
$counterAppointments=mysqli_num_rows($con->query("select * from appointments where doc_user_id='$doc_user_id' and (status='unapproved' or status='approved')"));






?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Outside Doctor Timings - Health Guide</title>

    <link href="assets/img/favicon.png" rel="icon">



    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">





    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<!------------------------------------------------>
<!----------------  MAIN WRAPPER   --------------->
<!------------------------------------------------>

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
                                <img src="assets/img/doctors/<?=$doctorImage?>" alt="DoctorImage" class="avatar-img rounded-circle">
                            </div>
                            <div class="user-text">
                                <h6>Dr. <?php echo $doctorDetails['firstname'];?></h6>
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

    <!---Page Content-->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3">
                    <!-- Dashboard Sidebar -->
                    <div class="profile-sidebar">
                        <div class="widget-profile pro-widget-content">
                            <div class="profile-info-widget">
                                <a href="#" class="booking-doc-img">
                                    <img src="assets/img/doctors/<?=$doctorImage?>" alt="User Image">
                                </a>
                                <div class="profile-det-info">
                                    <h3>Dr. <?php echo $doctorDetails['firstname'].' '.$doctorDetails['lastname']; ?></h3>

                                    <div class="patient-details">
                                        <h5 class="mb-0"><?=$doctorDetails['specialization']?> </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-widget">
                            <nav class="dashboard-menu">
                                <ul>
                                    <li>
                                        <a href="outside-doctor-dashboard.php">
                                            <i class="fas fa-columns"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li id="apptTab">
                                        <a href="outside-doctor-appointments.php">
                                            <i class="fas fa-calendar-check"></i>
                                            <span>Appointments</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-doctor-patients.php">
                                            <i class="fas fa-user-injured"></i>
                                            <span>My Patients</span>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="outside-schedule-timings.php">
                                            <i class="fas fa-hourglass-start"></i>
                                            <span>Schedule Timings</span>
                                        </a>
                                    </li>

                                    <li id="profile">
                                        <a href="outside-doctor-profile-setting.php">
                                            <i class="fas fa-user-cog"></i>
                                            <span>Profile Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-doctor-chats.php">
                                            <i class="fas fa-comments"></i>
                                            <span>Message</span>
                                            <small class="unread-msg"><?=$counter?></small>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-doctor-change-password.php">
                                            <i class="fas fa-lock"></i>
                                            <span>Change Password</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-delete-doctor-account.php">
                                            <i class="fas fa-trash"></i>
                                            <span>Delete Account</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="logout.php?doctor">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>


                </div>
                <!-- /Dashboard Sidebar -->


                <!-- Schedule Timings -->
                <div class="col-md-7 col-lg-8 col-xl-9">

                    <!--Dashboard Counter Area-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card dash-card">
                                <div class="card-body">
                                    <div class="row">

                                        <!--Total Patient Area-->
                                        <div class="col-md-12 col-lg-4">
                                            <div class="dash-widget dct-border-rht">
                                                <div class="circle-bar circle-bar1">
                                                    <div class="circle-graph1" data-percent="75">
                                                        <img src="assets/img/icon-01.png" class="img-fluid" alt="patient">
                                                    </div>
                                                </div>
                                                <div class="dash-widget-info">
                                                    <h6>Total Patient</h6>
                                                    <h3><?=$countTotalPatient?></h3>
                                                    <p class="text-muted">Till Today</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/Total Patient Area-->

                                        <!-- Today Patient Area-->
                                        <div class="col-md-12 col-lg-4">
                                            <div class="dash-widget dct-border-rht">
                                                <div class="circle-bar circle-bar2">
                                                    <div class="circle-graph2" data-percent="65">
                                                        <img src="assets/img/icon-02.png" class="img-fluid" alt="Patient">
                                                    </div>
                                                </div>
                                                <div class="dash-widget-info">
                                                    <h6>Today Patient</h6>
                                                    <h3><?=$counterTodayPatient?></h3>
                                                    <p class="text-muted">Till Today</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/Today Patient Area-->
                                        <!--Appointment Area-->
                                        <div class="col-md-12 col-lg-4">
                                            <div class="dash-widget">
                                                <div class="circle-bar circle-bar3">
                                                    <div class="circle-graph3" data-percent="50">
                                                        <img src="assets/img/icon-03.png" class="img-fluid" alt="Patient">
                                                    </div>
                                                </div>
                                                <div class="dash-widget-info">
                                                    <h6>Appoinments</h6>
                                                    <h3><?=$counterAppointments?></h3>
                                                    <p class="text-muted">Till Today</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/Appointment Area-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/Dashboard Counter Area-->



                    <!--Schedule Timings-->
                    <div class="row" id="scheduleTiming">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Schedule Timings </h4>
                                            <div class="profile-box">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3 <?php if (!isset($_REQUEST['success'])){echo 'd-none'; }  ?>">
                                                        <span class="btn btn-success btn-sm bg-success-light"> <i class="fa fa-check" style="margin-right: 3px;">   Successfully added</i></span>
                                                    </div>
                                                    <div class="col-md-12 mb-3 <?php if (!isset($_REQUEST['deleted'])){echo 'd-none'; }  ?>">
                                                        <span class="btn btn-success btn-sm bg-success-light"> <i class="fa fa-check" style="margin-right: 3px;">   Successfully deleted</i></span>
                                                    </div>
                                                    <div class="col-md-12 mb-3 <?php if (!isset($_REQUEST['fail'])){echo 'd-none'; } ?>">
                                                        <span class="btn btn-danger btn-sm bg-danger-light"> <i class="fa fa-window-close" style="margin-right: 3px;">   Not added, try again !</i></span>
                                                    </div>
                                                    <div class="col-md-12 mb-3 <?php if (!isset($_REQUEST['avaliable'])){echo 'd-none'; } ?>">
                                                        <span class="btn btn-danger btn-sm bg-danger-light"> <i class="fa fa-window-close" style="margin-right: 3px;">   Sorry this slot already exist !</i></span>
                                                    </div>
                                                    <div class="col-md-12 mb-3 <?php if (!isset($_REQUEST['deletefail'])){echo 'd-none'; } ?>">
                                                        <span class="btn btn-danger btn-sm bg-danger-light"> <i class="fa fa-window-close" style="margin-right: 3px;">   Not deleted, try again !</i></span>
                                                    </div>



                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card schedule-widget mb-0">

                                                            <!-- Schedule Header -->
                                                            <div class="schedule-header">

                                                                <!-- Schedule Nav -->
                                                                <div class="schedule-nav">
                                                                    <ul class="nav nav-tabs nav-justified">
                                                                        <li class="nav-item">
                                                                            <a class="nav-link  <?php  if (!isset($_REQUEST['day'])){  ?> active <?php }elseif ($_REQUEST['day']=='sat'){ ?>  active <?php  } ?> " data-toggle="tab"  href="#slot_saturday">Saturday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link <?php if ((isset($_REQUEST['day'])) && ($_REQUEST['day']=='sun')){ ?>  active <?php  } ?> " data-toggle="tab" href="#slot_sunday">Sunday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link <?php if ((isset($_REQUEST['day'])) &&($_REQUEST['day']=='mon')){ ?>  active <?php  } ?>" data-toggle="tab" href="#slot_monday">Monday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link <?php if ((isset($_REQUEST['day'])) &&($_REQUEST['day']=='tue')){ ?>  active <?php  } ?>" data-toggle="tab" href="#slot_tuesday">Tuesday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link <?php if ((isset($_REQUEST['day'])) &&($_REQUEST['day']=='wed')){ ?>  active <?php  } ?>" data-toggle="tab" href="#slot_wednesday">Wednesday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link <?php if ((isset($_REQUEST['day'])) &&($_REQUEST['day']=='thr')){ ?>  active <?php  } ?>" data-toggle="tab" href="#slot_thursday">Thursday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link <?php if ((isset($_REQUEST['day'])) &&($_REQUEST['day']=='fri')){ ?>  active <?php  } ?>" data-toggle="tab" href="#slot_friday">Friday</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /Schedule Nav -->

                                                            </div>
                                                            <!-- /Schedule Header -->

                                                            <!-- Schedule Content -->
                                                            <div class="tab-content schedule-cont">

                                                                <!-- Saturday Slot -->
                                                                <div id="slot_saturday" class="tab-pane fade <?php  if (!isset($_REQUEST['day'])){  ?> show active <?php }elseif ($_REQUEST['day']=='sat'){ ?> show active <?php  } ?> ">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link"  href="outside-schedule-timings.php?day=sat&show" ><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>

                                                                    <!-- Slot List -->
                                                                    <div class="doc-times">
                                                                        <?php
                                                                        $saturdaySlots=$con->query("select start_time,end_time from doctorslots where user_id='$doctorID' and saturday='yes'");

                                                                        while($row=$saturdaySlots->fetch_array()) {

                                                                            ?>
                                                                            <div class="doc-slot-list">
                                                                                <?php echo $row['start_time']." - ".$row['end_time']; ?>                                                                                    <a href="outside-schedule-timings.php?start_time=<?=$row['start_time']?>&end_time=<?=$row['end_time']?>&dd=saturday&day=sat"
                                                                                                                                                                                                                               class="delete_schedule">
                                                                                    <i class="fa fa-times"></i>
                                                                                </a>
                                                                            </div>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                    <p class="text-muted mb-0" style="display: <?php if (mysqli_num_rows($saturdaySlots)>0){ ?> none <?php } ?> ">Not Available</p>

                                                                </div>
                                                                <!-- /Saturday Slot -->

                                                                <!-- Sunday Slot -->
                                                                <div id="slot_sunday" class="tab-pane fade <?php if ((isset($_REQUEST['day'])) &&($_REQUEST['day']=='sun')){ ?> show active <?php  } ?>">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link"  href="outside-schedule-timings.php?day=sun&show" ><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>

                                                                    <!-- Slot List -->
                                                                    <div class="doc-times">
                                                                        <?php
                                                                        $sundaySlots=$con->query("select start_time,end_time from doctorslots where user_id='$doctorID' and sunday='yes'");

                                                                        while($row=$sundaySlots->fetch_array()) {

                                                                            ?>
                                                                            <div class="doc-slot-list">
                                                                                <?php echo $row['start_time']." - ".$row['end_time']; ?>                                                                                  <a href="outside-schedule-timings.php?start_time=<?=$row['start_time']?>&end_time=<?=$row['end_time']?>&dd=sunday&day=sun"
                                                                                                                                                                                                                             class="delete_schedule">
                                                                                    <i class="fa fa-times"></i>
                                                                                </a>
                                                                            </div>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                    <p class="text-muted mb-0" style="display: <?php if (mysqli_num_rows($sundaySlots)>0){ ?> none <?php } ?> ">Not Available</p>


                                                                </div>
                                                                <!-- /Sunday Slot -->

                                                                <!-- Monday Slot -->
                                                                <div id="slot_monday" class="tab-pane fade <?php if ((isset($_REQUEST['day'])) && ($_REQUEST['day']=='mon')){ ?> show active <?php  } ?>">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link"  href="outside-schedule-timings.php?day=mon&show" ><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>

                                                                    <!-- Slot List -->
                                                                    <div class="doc-times">
                                                                        <?php
                                                                        $mondaySlots=$con->query("select start_time,end_time from doctorslots where user_id='$doctorID' and monday='yes'");

                                                                        while($row=$mondaySlots->fetch_array()) {

                                                                            ?>
                                                                            <div class="doc-slot-list">
                                                                                <?php echo $row['start_time']." - ".$row['end_time']; ?>                                                                                 <a href="outside-schedule-timings.php?start_time=<?=$row['start_time']?>&end_time=<?=$row['end_time']?>&dd=monday&day=mon"
                                                                                                                                                                                                                            class="delete_schedule">
                                                                                    <i class="fa fa-times"></i>
                                                                                </a>
                                                                            </div>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                    <p class="text-muted mb-0" style="display: <?php if (mysqli_num_rows($mondaySlots)>0){ ?> none <?php } ?> ">Not Available</p>

                                                                </div>
                                                                <!-- /Monday Slot -->

                                                                <!-- Tuesday Slot -->
                                                                <div id="slot_tuesday" class="tab-pane fade <?php if ((isset($_REQUEST['day'])) && ($_REQUEST['day']=='tue')){ ?> show active <?php  } ?>">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link"  href="outside-schedule-timings.php?day=tue&show" ><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>

                                                                    <!-- Slot List -->
                                                                    <div class="doc-times">
                                                                        <?php
                                                                        $tuesdaySlots=$con->query("select start_time,end_time from doctorslots where user_id='$doctorID' and tuesday='yes'");

                                                                        while($row=$tuesdaySlots->fetch_array()) {

                                                                            ?>
                                                                            <div class="doc-slot-list">
                                                                                <?php echo $row['start_time']." - ".$row['end_time']; ?>                                                                                <a href="outside-schedule-timings.php?start_time=<?=$row['start_time']?>&end_time=<?=$row['end_time']?>&dd=tuesday&day=tue"
                                                                                                                                                                                                                           class="delete_schedule">
                                                                                    <i class="fa fa-times"></i>
                                                                                </a>
                                                                            </div>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                    <p class="text-muted mb-0" style="display: <?php if (mysqli_num_rows($tuesdaySlots)>0){ ?> none <?php } ?> ">Not Available</p>

                                                                </div>
                                                                <!-- /Tuesday Slot -->

                                                                <!-- Wednesday Slot -->
                                                                <div id="slot_wednesday" class="tab-pane fade <?php if ((isset($_REQUEST['day'])) && ($_REQUEST['day']=='wed')){ ?> show active <?php  } ?>">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link"  href="outside-schedule-timings.php?day=wed&show" ><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>

                                                                    <!-- Slot List -->
                                                                    <div class="doc-times">
                                                                        <?php
                                                                        $wednesdaySlots=$con->query("select start_time,end_time from doctorslots where user_id='$doctorID' and wednesday='yes'");

                                                                        while($row=$wednesdaySlots->fetch_array()) {

                                                                            ?>
                                                                            <div class="doc-slot-list">
                                                                                <?php echo $row['start_time']." - ".$row['end_time']; ?>                                                                                 <a href="outside-schedule-timings.php?start_time=<?=$row['start_time']?>&end_time=<?=$row['end_time']?>&dd=wednesday&day=wed"
                                                                                                                                                                                                                            class="delete_schedule">
                                                                                    <i class="fa fa-times"></i>
                                                                                </a>
                                                                            </div>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                    <p class="text-muted mb-0" style="display: <?php if (mysqli_num_rows($wednesdaySlots)>0){ ?> none <?php } ?> ">Not Available</p>

                                                                </div>
                                                                <!-- /Wednesday Slot -->

                                                                <!-- Thursday Slot -->
                                                                <div id="slot_thursday" class="tab-pane fade <?php if ((isset($_REQUEST['day'])) && ($_REQUEST['day']=='thr')){ ?> show active <?php  } ?> ">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link"  href="outside-schedule-timings.php?day=thr&show" ><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>

                                                                    <!-- Slot List -->
                                                                    <div class="doc-times">
                                                                        <?php
                                                                        $thursdaySlots=$con->query("select start_time,end_time from doctorslots where user_id='$doctorID' and thursday='yes'");

                                                                        while($row=$thursdaySlots->fetch_array()) {

                                                                            ?>
                                                                            <div class="doc-slot-list">
                                                                                <?php echo $row['start_time']." - ".$row['end_time']; ?>                                                                                <a href="outside-schedule-timings.php?start_time=<?=$row['start_time']?>&end_time=<?=$row['end_time']?>&dd=thursday&day=thr"
                                                                                                                                                                                                                           class="delete_schedule">
                                                                                    <i class="fa fa-times"></i>
                                                                                </a>
                                                                            </div>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                    <p class="text-muted mb-0" style="display: <?php if (mysqli_num_rows($thursdaySlots)>0){ ?> none <?php } ?> ">Not Available</p>

                                                                </div>
                                                                <!-- /Thursday Slot -->

                                                                <!-- Friday Slot -->
                                                                <div id="slot_friday" class="tab-pane fade <?php if ((isset($_REQUEST['day'])) && ($_REQUEST['day']=='fri')){ ?> show active <?php  } ?>">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link"  href="outside-schedule-timings.php?day=fri&show" ><i class="fa fa-plus-circle"></i> Add Slot</a>

                                                                    </h4>

                                                                    <!-- Slot List -->
                                                                    <div class="doc-times">
                                                                        <?php
                                                                        $fridaySlots=$con->query("select start_time,end_time from doctorslots where user_id='$doctorID' and friday='yes'");

                                                                        while($row=$fridaySlots->fetch_array()) {

                                                                            ?>
                                                                            <div class="doc-slot-list">
                                                                                <?php echo $row['start_time']." - ".$row['end_time']; ?>                                                                                <a href="outside-schedule-timings.php?start_time=<?=$row['start_time']?>&end_time=<?=$row['end_time']?>&dd=friday&day=fri"
                                                                                                                                                                                                                           class="delete_schedule">
                                                                                    <i class="fa fa-times"></i>
                                                                                </a>
                                                                            </div>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                    <p class="text-muted mb-0" style="display: <?php if (mysqli_num_rows($fridaySlots)>0){ ?> none <?php } ?> ">Not Available</p>

                                                                </div>
                                                                <!-- /Friday Slot -->

                                                            </div>
                                                            <!-- /Schedule Content -->

                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--/Schedule Timings-->
                </div>
            </div>
        </div>
    </div>
</div>


<!------------------------------------------------>
<!---------------   MODALS ------------->
<!------------------------------------------------>
<!-- Add Time Slot Modal -->
<div class="modal fade custom-modal" id="add_time_slot">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Time Slots</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="outside-schedule-timings.php">
                    <div class="hours-info">
                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10">
                                <div class="row form-row">
                                    <div class="col-12 col-md-12">


                                        <div class="form-group">
                                            <input type="hidden" name="day" value="<?php echo $_REQUEST['day']; ?>">
                                            <label>Set Slots Duration</label>
                                            <select class="form-control select" id="durationslots">
                                                <option value="15">15 min (deafult)</option>
                                                <option value="30">30 min</option>
                                                <option value="45">45 min</option>
                                                <option value="60">60 min</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-12 col-md-6">


                                        <div class="form-group">
                                            <input type="hidden" name="day" value="<?php echo $_REQUEST['day']; ?>">
                                            <label>Start Time</label>
                                            <input class="form-control" name="startTime" id="startTime" type="hidden" required>

                                            <input class="form-control" id="start" onchange="onStartTimeChange()" type="time" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <input class="form-control" name="endTime" id="endTime" readonly type="text">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="submit-section text-center">
                        <button type="submit" name="save"  class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Time Slot Modal -->




<!------------------------------------------------>
<!---------------   EXTERNAL SOURCES ------------->
<!------------------------------------------------>



<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Sticky Sidebar JS -->

<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

<!-- Circle Progress JS -->
<script src="assets/js/circle-progress.min.js"></script>

<!-- Select2 JS -->
<script src="assets/plugins/select2/js/select2.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>



<!-- Profile Settings JS -->
<script src="assets/js/profile-settings.js"></script>


<script type="text/javascript">

    function onStartTimeChange() {
        var slotduration=document.getElementById("durationslots");
        var inputEle=document.getElementById("start");
        var endTime=document.getElementById("endTime");

        var timeSplit=inputEle.value.split(':'),hours,minutes,meridian;

        hours=timeSplit[0];
        minutes=timeSplit[1];

        if (hours>12){
            meridian='PM';
            hours-=12;
        } else if (hours<12){
            meridian='AM';

            if (hours==0){
                hours=12;
            }
        } else{
            meridian='PM';
        }


        var duration=slotduration.value;
        var endhours=parseInt(hours);
        var endminutes=parseInt(minutes);
        var endmeridian=meridian;


        if (duration=="15") {
            endminutes += 15;

        }if (duration=="30") {
            endminutes += 30;

        }
        if (duration=="45") {
            endminutes += 45;

        }if (duration=="60") {
            endminutes += 60;

        }


        if (endminutes>=60) {

            endminutes-=60;
            endhours++;

            if ((endhours>=12) && (meridian=="PM")){
                endmeridian='AM';

                if (endminutes==60){
                    endminutes=0;
                }

            }else if ((endhours<12) && (meridian=="AM")){
                endmeridian='AM';
                if (endminutes==60){
                    endminutes=0;
                }

            }else if ((endhours<12) && (meridian=="PM")){
                endmeridian='PM';
                if (endminutes==60){
                    endminutes=0;
                }

            }else{
                endmeridian='PM';
            }

        }







        if (endhours<10){
            endhours="0"+''+endhours;
        }
        if (endminutes<10){
            endminutes="0"+''+endminutes;
        }   if ((hours<10)&& (hours!=0)){
            hours="0"+hours;
        } if ((minutes<10)&& (minutes!=0)){
            minutes="0"+minutes;
        }






        endTime.value=endhours+":"+endminutes+" "+endmeridian;
        document.getElementById("startTime").value=hours+":"+minutes+" "+meridian;

    }



</script>

<?php
if ((isset($_REQUEST['day'])) && (isset($_REQUEST['show']))) {
    echo "<script>
        $( '#add_time_slot' ).modal('show');
       
      </script> ";

}


?>

</body>

</html>
