<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 10-Jul-20
 * Time: 5:06 PM
 */

    require_once ("database-connection.php");
    session_start();

if (!isset($_COOKIE['username'])){
    header("location:login.php");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}

date_default_timezone_set("Asia/Kabul");

    $username=$_SESSION['username'];

    $doc=$con->query("select * from users where user_username='$username'")->fetch_array();
    $doc_id=$doc['doc_id'];
    $doc_user_id=$doc['user_id'];
    $doctorDetails=$con->query("select * from doctor where doc_id='$doc_id'")->fetch_array();
    $doctorProfile=$con->query("select * from doctorprofile where user_id='$doc_user_id'")->fetch_array();
    $doctorImage=$con->query("select file_name from pictures where user_id='$doc_user_id'")->fetch_array()['file_name'];

    $appointments=$con->query("select * from appointments where doc_user_id='$doc_user_id' and (status='approved' or status='unapproved')");
    $msgModal=false;


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



if (isset($_REQUEST['patientid'])){
        $id=$_REQUEST['patientid'];



        if (mysqli_query($con,"update appointments set status='deleted' where id='$id'")){
            header("location:doctor-appointments.php?deleted");
            return;
        }else{
            header("location:doctor-appointments.php?notdeleted");
            return;
        }

    }
if (isset($_REQUEST['visitorid'])){
    $id=$_REQUEST['visitorid'];



    if (mysqli_query($con,"delete from appointments where visitor_id='$id'")){
        header("location:doctor-appointments.php?deleted");
        return;
    }else{
        header("location:doctor-appointments.php?notdeleted");
        return;
    }

}

if ((isset($_REQUEST['message'])) && (isset($_REQUEST['touser']))){
    $msgModal=true;
}
if (isset($_REQUEST['sendmessage'])){
    $touser=$_REQUEST['touser'];
    $message=$_REQUEST['message'];
    $from=$doc_user_id;

    $date=date("Y-m-d h:i:s");

    if ($con->query("insert into chat_message values ('','$touser','$from','$message','$date','not seen')")){
        header("location:doctor-appointments.php?send");
        return;
    }else{
        header("location:doctor-appointments.php?notsend");
        return;
    }

}

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Doctor Appointments - Health Guide</title>


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
<!-- Main Wrapper -->
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
									<img class="rounded-circle" src="assets/img/doctors/<?=$doctorImage?>" width="31" alt="<?=$doctorDetails['doc_firstName']?>">
								</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="user-header">
                                <div class="avatar avatar-sm">
                                    <img src="assets/img/doctors/<?=$doctorImage?>" alt="User Image" class="avatar-img rounded-circle">
                                </div>
                                <div class="user-text">
                                    <h6>Dr. <?php echo $doctorDetails['doc_firstName'] ?></h6>
                                    <p class="text-muted mb-0">Doctor</p>
                                </div>
                            </div>
                            <a class="dropdown-item" href="doctor-dashboard.php">Dashboard</a>
                            <a class="dropdown-item" href="doctor-profile-setting.php" >Profile Settings</a>
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
                    <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                        <!-- Dashboard Sidebar -->
                        <div class="profile-sidebar">
                            <div class="widget-profile pro-widget-content">
                                <div class="profile-info-widget">
                                    <a href="#" class="booking-doc-img">
                                        <img src="assets/img/doctors/<?=$doctorImage?>" alt="Doctor Image">
                                    </a>
                                    <div class="profile-det-info">
                                        <h3>Dr. <?php echo $doctorDetails['doc_firstName'].' '.$doctorDetails['doc_lastName']; ?></h3>

                                        <div class="patient-details">
                                            <h5 class="mb-0"><?php echo $doctorDetails['doc_specialization'];?> - <?=$doctorDetails['doc_qualification']?> </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-widget">
                                <nav class="dashboard-menu">
                                    <ul>
                                        <li>
                                            <a href="doctor-dashboard.php">
                                                <i class="fas fa-columns"></i>
                                                <span>Dashboard</span>
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="doctor-appointments.php">
                                                <i class="fas fa-calendar-check"></i>
                                                <span>Appointments</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="doctor-patients.php" >
                                                <i class="fas fa-user-injured"></i>
                                                <span>My Patients</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="schedule-timings.php">
                                                <i class="fas fa-hourglass-start"></i>
                                                <span>Schedule Timings</span>
                                            </a>
                                        </li>

                                        <li id="profile">
                                            <a href="doctor-profile-setting.php">
                                                <i class="fas fa-user-cog"></i>
                                                <span>Profile Settings</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="doctor-chats.php">
                                                <i class="fas fa-comments"></i>
                                                <span>Message</span>
                                                <small class="unread-msg"><?=$counter?></small>
                                            </a>
                                        </li>
                                        <li id="changePass">
                                            <a href="doctor-change-password.php">
                                                <i class="fas fa-lock"></i>
                                                <span>Change Password</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="delete-doctor-account.php">
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
                        <!-- /Dashboard Sidebar -->

                    </div>
                    <!--Dashboard-->

                    <!--Dashboard-->
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

                        <!--Appointment Tab-->
                        <div class="row" id="appointmentTab">
                            <div class="col-md-12" >
                                <h4 class="mb-4">Patient Appointments<small class=" btn btn-sm bg-success-light float-right <?php if (!isset($_REQUEST['deleted'])){echo "d-none";} ?>">Appointment Deleted Successfully</small><small class="btn btn-sm bg-danger-light float-right <?php if (!isset($_REQUEST['notdeleted'])){echo "d-none";} ?>">Appointment Not Deleted</small>
                                    <small class=" btn btn-sm bg-success-light float-right <?php if (!isset($_REQUEST['send'])){echo "d-none";} ?>">Message sent</small>
                                    <small class=" btn btn-sm bg-danger-light float-right <?php if (!isset($_REQUEST['notsend'])){echo "d-none";} ?>">Message not send!</small>

                                </h4>
                                <?php
                                    while ($row=$appointments->fetch_array()) {
                                        $user_id = null;
                                        $patientDetails = null;
                                        $patientImage = null;
                                        if (!$row['visitor_id'] == '') {
                                            $user_id = $row['visitor_id'];
                                            $patientDetails = $con->query("select * from visitors where id='$user_id'")->fetch_array();


                                            ?>
                                            <!--Appointment Tab Contents Area-->
                                            <div class="appointments" style="margin-top: 30px">
                                                <!-- Appointment List -->
                                                <div class="appointment-list">
                                                    <div class="profile-info-widget">
                                                        <a class="booking-doc-img">
                                                            <img src="assets/img/patients/visitor.png" alt="Visitor">
                                                        </a>
                                                        <div class="profile-det-info">
                                                            <h3>
                                                                <a>Mr. <?= $patientDetails['name'] ?> <small>(Visitor)</small></a>
                                                            </h3>
                                                            <div class="patient-details">
                                                                <h5><i class="far fa-clock"></i> <?= $row['date'] ?>
                                                                    , <?= $row['time'] ?></h5>
                                                                <h5><i class="fas fa-map-marker-alt"></i> Afghanistan
                                                                </h5>

                                                                <h5 class="mb-0"><i
                                                                        class="fas fa-phone"></i> <?= $patientDetails['contact'] ?>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="appointment-action">

                                                        <a href="doctor-appointments.php?visitorid=<?= $patientDetails['id'] ?>"
                                                           class="btn btn-sm bg-danger-light">
                                                            <i class="fas fa-times"></i> Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- /Appointment List -->

                                            </div>

                                            <?php
                                        } else {
                                            $user_id = $row['user_id'];

                                            $patientDetails = $con->query("select * from users where user_id='$user_id'")->fetch_array();
                                            $patientImage = $con->query("select file_name from pictures where user_id='$user_id'")->fetch_array()['file_name'];


                                            ?>
                                            <!--Appointment Tab Contents Area-->
                                            <div class="appointments">
                                                <!-- Appointment List -->
                                                <div class="appointment-list">
                                                    <div class="profile-info-widget">
                                                        <a class="booking-doc-img">
                                                            <img src="assets/img/patients/<?=$patientImage?>"
                                                                 alt="User Image">
                                                        </a>
                                                        <div class="profile-det-info">
                                                            <h3><a>Mr. <?=$patientDetails['user_name']?></a></h3>
                                                            <div class="patient-details">
                                                                <h5><i class="far fa-clock"></i> <?=$row['date']?>, <?=$row['time']?>
                                                                </h5>
                                                                <h5><i class="fas fa-map-marker-alt"></i> <?=$patientDetails['user_address']?>,
                                                                    Afghanistan
                                                                </h5>

                                                                <h5 class="mb-0"><i class="fas fa-phone"></i> <?=$patientDetails['user_contact']?>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="appointment-action">
                                                        <a href="doctor-appointments.php?message&touser=<?=$patientDetails['user_id']?>"
                                                           class="btn btn-sm bg-primary-light">
                                                            <i class="fas fa-envelope"></i> Message
                                                        </a>
                                                        <a href="doctor-appointments.php?patientid=<?=$row['id']?>"
                                                           class="btn btn-sm bg-danger-light">
                                                            <i class="fas fa-times"></i> Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- /Appointment List -->

                                            </div>

                                            <?php
                                        }
                                    }
                                ?>


                                <!---/Appointment Tab Contents Area-->
                            </div>
                        </div>
                        <!--/Appointment Tab-->

                    </div>

                </div>
            </div>
        </div>


    </div>


<!--Message Modal Body-->
<div class="modal fade"  id="messageModal">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content loginModal">
            <div class="login-close">
                <button type="button" class="close"  data-dismiss="modal" onclick="loginBody();"><span>&times;</span></button>
            </div>
            <div class="modal-body">


                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">


                                <div class="account-content">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="col-md-7 col-lg-6 login-left">
                                            <img src="assets/img/login-banner.png" class="img-fluid" alt="Login Banner">
                                        </div>
                                        <div class="col-md-12 col-lg-6 login-right">
                                            <div class="login-header">
                                                <h3>Message</h3>
                                                <p class="small text-muted">Your message here</p>
                                            </div>

                                            <!-- Forgot Password Form -->
                                            <form action="doctor-appointments.php" method="post">

                                                <input type="hidden" name="touser" value="<?=$_REQUEST['touser']?>">

                                                <div class="form-group">
                                                    <textarea id="review_desc" rows="5" placeholder="type message here" name="message" maxlength="500" class="form-control"></textarea>

                                                    <div class="d-flex justify-content-between mt-3"><small class="text-muted"><span id="chars">500</span> characters only</small></div>
                                                </div>

                                                <button class="btn btn-primary btn-block btn-lg login-btn" type="submit" name="sendmessage">Send Message</button>
                                            </form>
                                            <!-- /Forgot Password Form -->

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                </div>
                <!-- /Forgot Password Content -->
            </div>

            <!---Message Modal Body-->
        </div>

    </div>

</div>

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


<?php
    if ($msgModal==true){


    echo "<script>
        $( '#messageModal').modal('show');
      </script> ";
}


?>


</body>
</html>
