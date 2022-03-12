<?php

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



//Counter Area
$countTotalPatient=mysqli_num_rows($con->query("select distinct user_id,visitor_id from appointments where doc_user_id='$doc_user_id'"));


//Today Appointments

$today=date("d M Y");
$todayAppointments=$con->query("select * from appointments where doc_user_id='$doc_user_id' and date='$today' and (status='unapproved' or status='approved')");

$counterTodayPatient=mysqli_num_rows($todayAppointments);
$counterAppointments=mysqli_num_rows($con->query("select * from appointments where doc_user_id='$doc_user_id' and (status='unapproved' or status='approved')"));




/*
 * Messages Counter
 */
    $counterMessages=$con->query("select * from chat_message where to_user_id='$doc_user_id' and status='not seen'");
    $counter=mysqli_num_rows($counterMessages);

if ((isset($_REQUEST['id'])) && (isset($_REQUEST['approve']))){
    $id=$_REQUEST['id'];
    if (mysqli_query($con,"update appointments set status='approved' where id='$id'")){
        header("location:doctor-dashboard.php?approved");
        return;
    }else{
        header("location:doctor-dashboard.php?notapproved");
        return;
    }
}

if (isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
    if (mysqli_query($con,"update appointments set status='deleted' where id='$id'")){
        header("location:doctor-dashboard.php?deleted");
        return;
    }else{
        header("location:doctor-dashboard.php?notdeleted");
        return;
    }
}





?>


<html lang="en">
<head>
                        <meta charset="utf-8">
                        <title>Doctor Dashboard - Health Guide</title>

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
                                                        <li class="active">
                                                            <a href="doctor-dashboard.php">
                                                                <i class="fas fa-columns"></i>
                                                                <span>Dashboard</span>
                                                            </a>
                                                        </li>
                                                        <li>
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
                                                        <li>
                                                            <a href="doctor-chats.php">
                                                                <i class="fas fa-comments"></i>
                                                                <span>Message</span>
                                                                <small class="unread-msg"><?=$counter?></small>
                                                            </a>
                                                        </li>

                                                        <li id="profile">
                                                            <a href="doctor-profile-setting.php">
                                                                <i class="fas fa-user-cog"></i>
                                                                <span>Profile Settings</span>
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

                    <!--Patient Appointment Area-->
                    <div class="row" id="dashboardTab">
                        <div class="col-md-12" >
                            <h4 class="mb-4">Patient Appoinment<small class="float-right btn btn-sm bg-success-light <?php if (!isset($_REQUEST['autologin'])){echo "d-none"; } ?>">Welcome, Your account has been approved</small><small class="float-right btn btn-sm bg-success-light <?php if (!isset($_REQUEST['approved'])){echo "d-none"; } ?>">Appointment Approved</small><small class="float-right btn btn-sm bg-success-light <?php if (!isset($_REQUEST['deleted'])){echo "d-none"; } ?>">Appointment Deleted</small></h4>
                            <div class="appointment-tab">

                                <!-- Appointment Tab -->
                                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#today-appointments" data-toggle="tab">Today</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#upcoming-appointments" data-toggle="tab">Upcoming</a>
                                    </li>

                                </ul>
                                <!-- /Appointment Tab -->

                                <div class="tab-content">

                                    <!-- Upcoming Appointment Tab -->
                                    <div class="tab-pane" id="upcoming-appointments">
                                        <div class="card card-table mb-0">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <!--Table For Records-->
                                                    <table class="table table-hover table-center mb-0">
                                                        <thead>
                                                        <tr>
                                                            <th>Patient Name</th>
                                                            <th>Address</th>
                                                            <th>Contact</th>
                                                            <th>Appointment Date</th>
                                                            <th>Appointment Time</th>
                                                            <th>Appointment Status</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            $tom=date("d M Y",strtotime("+1 day"));
                                                            $upcoming=$con->query("select * from appointments where doc_user_id='$doc_user_id' and date='$tom' and status='unapproved'");

                                                            while($row=$upcoming->fetch_array()) {
                                                                $user_id = null;
                                                                $patientDetails = null;
                                                                $patientImage = null;

                                                                if (!$row['visitor_id'] == '') {
                                                                    $user_id = $row['visitor_id'];
                                                                    $patientDetails = $con->query("select * from visitors where id='$user_id'")->fetch_array();

                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <h2 class="table-avatar">
                                                                                <a
                                                                                   class="avatar avatar-sm mr-2"><img
                                                                                            class="avatar-img rounded-circle"
                                                                                            src="assets/img/patients/visitor.png"
                                                                                            alt="No image"></a>
                                                                                <a>Mr. <?= $patientDetails['name'] ?> <small>(Visitor)</small></a>
                                                                            </h2>
                                                                        </td>
                                                                        <td>
                                                                        </td>
                                                                        <td><?= $patientDetails['contact'] ?></td>
                                                                        <td><?= $row['date'] ?></td>
                                                                        <td><?= $row['time'] ?></td>
                                                                        <td>
                                                                    <span class="badge badge-pill
                                                                            <?php
                                                                    if ($row['status']=='unapproved'){
                                                                        echo "bg-primary-light";
                                                                    }elseif ($row['status']=='deleted')   {
                                                                        echo "bg-danger-light";
                                                                    }elseif ($row['status']=='approved')    {
                                                                        echo "bg-success-light";
                                                                    }
                                                                    ?>
                                                                    "> <?php echo $row['status'] ?></span>
                                                                        </td>

                                                                        <td class="text-right">
                                                                            <div class="table-action">
                                                                                <a href="doctor-dashboard.php?id=<?= $row['id'] ?>&approve"
                                                                                   class="btn btn-sm bg-info-light <?php if ($row['status']=='approved'){echo 'disabled';} ?>">
                                                                                    <i class="fas fa-check"></i> Approve
                                                                                </a>
                                                                                <a href="doctor-dashboard.php?id=<?= $row['id'] ?>"
                                                                                   class="btn btn-sm bg-danger-light">
                                                                                    <i class="fas fa-times"></i> Cancel
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                } else {
                                                                    $user_id = $row['user_id'];

                                                                    $patientDetails = $con->query("select * from users where user_id='$user_id'")->fetch_array();
                                                                    $patientImage = $con->query("select file_name from pictures where user_id='$user_id'")->fetch_array()['file_name'];


                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <h2 class="table-avatar">
                                                                                <a
                                                                                   class="avatar avatar-sm mr-2"><img
                                                                                            class="avatar-img rounded-circle"
                                                                                            src="assets/img/patients/<?= $patientImage ?>"
                                                                                            alt="No image"></a>
                                                                                <a >Mr. <?= $patientDetails['user_name'] ?></a>
                                                                            </h2>
                                                                        </td>
                                                                        <td><?= $patientDetails['user_address']; ?>
                                                                        </td>
                                                                        <td><?= $patientDetails['user_contact'] ?></td>
                                                                        <td><?= $row['date'] ?></td>
                                                                        <td><?= $row['time'] ?></td>
                                                                        <td>
                                                                    <span class="badge badge-pill
                                                                            <?php
                                                                    if ($row['status']=='unapproved'){
                                                                        echo "bg-primary-light";
                                                                    }elseif ($row['status']=='deleted')   {
                                                                        echo "bg-danger-light";
                                                                    }elseif ($row['status']=='approved')    {
                                                                        echo "bg-success-light";
                                                                    }
                                                                    ?>
                                                                    "> <?php echo $row['status'] ?></span>
                                                                        </td>

                                                                        <td class="text-right">
                                                                            <div class="table-action">
                                                                                <a href="doctor-dashboard.php?id=<?= $row['id'] ?>&approve"
                                                                                   class="btn btn-sm bg-info-light <?php if ($row['status']=='approved'){echo 'disabled';} ?>">
                                                                                    <i class="fas fa-check"></i> Approve
                                                                                </a>
                                                                                <a href="doctor-dashboard.php?id=<?= $row['id'] ?>"
                                                                                   class="btn btn-sm bg-danger-light">
                                                                                    <i class="fas fa-times"></i> Cancel
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                    <?php
                                                                }
                                                            }
                                                        ?>



                                                        </tbody>
                                                    </table>

                                                    <!--/Table-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Upcoming Appointment Tab -->

                                    <!-- Today Appointment Tab -->
                                    <div class="tab-pane show active" id="today-appointments">
                                        <div class="card card-table mb-0">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-center mb-0">
                                                        <thead>
                                                        <tr>
                                                            <th>Patient Name</th>
                                                            <th>Address</th>
                                                            <th>Contact</th>
                                                            <th>Appointment Date</th>
                                                            <th>Appointment Time</th>
                                                            <th>Appointment Status</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            while($row=$todayAppointments->fetch_array()) {
                                                                $user_id = null;
                                                                $patientDetails = null;
                                                                $patientImage = null;
                                                                if (!$row['visitor_id'] == '') {
                                                                    $user_id = $row['visitor_id'];
                                                                    $patientDetails = $con->query("select * from visitors where id='$user_id'")->fetch_array();
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <h2 class="table-avatar">
                                                                                <a
                                                                                   class="avatar avatar-sm mr-2"><img
                                                                                            class="avatar-img rounded-circle"
                                                                                            src="assets/img/patients/visitor.png"
                                                                                            alt="No image"></a>
                                                                                <a>Mr. <?= $patientDetails['name'] ?> <small>(Visitor)</small></a>
                                                                            </h2>
                                                                        </td>
                                                                        <td>
                                                                        </td>
                                                                        <td><?= $patientDetails['contact'] ?></td>
                                                                        <td><?= $row['date'] ?></td>
                                                                        <td><?= $row['time'] ?></td>
                                                                        <td>
                                                                    <span class="badge badge-pill
                                                                            <?php
                                                                    if ($row['status']=='unapproved'){
                                                                        echo "bg-primary-light";
                                                                    }elseif ($row['status']=='deleted')   {
                                                                        echo "bg-danger-light";
                                                                    }elseif ($row['status']=='approved')    {
                                                                        echo "bg-success-light";
                                                                    }
                                                                    ?>
                                                                    "> <?php echo $row['status'] ?></span>
                                                                        </td>

                                                                        <td class="text-right">
                                                                            <div class="table-action">
                                                                                <a href="doctor-dashboard.php?id=<?= $row['id'] ?>&approve"
                                                                                   class="btn btn-sm bg-info-light <?php if ($row['status']=='approved'){echo 'disabled';} ?>">
                                                                                    <i class="fas fa-check"></i> Approve
                                                                                </a>
                                                                                <a href="doctor-dashboard.php?id=<?= $row['id'] ?>"
                                                                                   class="btn btn-sm bg-danger-light">
                                                                                    <i class="fas fa-times"></i> Cancel
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                } else {
                                                                    $user_id = $row['user_id'];

                                                                    $patientDetails = $con->query("select * from users where user_id='$user_id'")->fetch_array();
                                                                    $patientImage = $con->query("select file_name from pictures where user_id='$user_id'")->fetch_array()['file_name'];


                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <h2 class="table-avatar">
                                                                                <a
                                                                                   class="avatar avatar-sm mr-2"><img
                                                                                            class="avatar-img rounded-circle"
                                                                                            src="assets/img/patients/<?= $patientImage ?>"
                                                                                            alt="No image"></a>
                                                                                <a>Mr. <?= $patientDetails['user_name'] ?></a>
                                                                            </h2>
                                                                        </td>
                                                                        <td><?= $patientDetails['user_address']; ?>
                                                                        </td>
                                                                        <td><?= $patientDetails['user_contact'] ?></td>
                                                                        <td><?= $row['date'] ?></td>
                                                                        <td><?= $row['time'] ?></td>
                                                                        <td>
                                                                    <span class="badge badge-pill
                                                                            <?php
                                                                    if ($row['status']=='unapproved'){
                                                                        echo "bg-primary-light";
                                                                    }elseif ($row['status']=='deleted')   {
                                                                        echo "bg-danger-light";
                                                                    }elseif ($row['status']=='approved')    {
                                                                        echo "bg-success-light";
                                                                    }
                                                                    ?>
                                                                    "> <?php echo $row['status'] ?></span>
                                                                        </td>

                                                                        <td class="text-right">
                                                                            <div class="table-action">
                                                                                <a href="doctor-dashboard.php?id=<?= $row['id'] ?>&approve"
                                                                                   class="btn btn-sm bg-info-light <?php if ($row['status']=='approved'){echo 'disabled';} ?>">
                                                                                    <i class="fas fa-check"></i> Approve
                                                                                </a>
                                                                                <a href="doctor-dashboard.php?id=<?= $row['id'] ?>"
                                                                                   class="btn btn-sm bg-danger-light">
                                                                                    <i class="fas fa-times"></i> Cancel
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Today Appointment Tab -->

                                </div>
                            </div>
                        </div>


                    </div>
                    <!--/Patient Appointment Area-->




                    <!--Schedule Timings-->
                    <div class="row" id="scheduleTiming" style="display: none;">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Schedule Timings</h4>
                                            <div class="profile-box">
                                                <div class="row">

                                                    <!--Timing Slot Duration-->
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Timing Slot Duration</label>
                                                            <select class="select form-control">
                                                                <option>-</option>
                                                                <option>15 mins</option>
                                                                <option selected="selected">30 mins</option>
                                                                <option>45 mins</option>
                                                                <option>1 Hour</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--/Timing Slot Duration-->



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
                                                                            <a class="nav-link" data-toggle="tab" href="#slot_sunday">Sunday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link active" data-toggle="tab" href="#slot_monday">Monday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" data-toggle="tab" href="#slot_tuesday">Tuesday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" data-toggle="tab" href="#slot_wednesday">Wednesday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" data-toggle="tab" href="#slot_thursday">Thursday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" data-toggle="tab" href="#slot_friday">Friday</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" data-toggle="tab" href="#slot_saturday">Saturday</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /Schedule Nav -->

                                                            </div>
                                                            <!-- /Schedule Header -->

                                                            <!-- Schedule Content -->
                                                            <div class="tab-content schedule-cont">

                                                                <!-- Sunday Slot -->
                                                                <div id="slot_sunday" class="tab-pane fade">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link" data-toggle="modal" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>
                                                                    <p class="text-muted mb-0">Not Available</p>
                                                                </div>
                                                                <!-- /Sunday Slot -->

                                                                <!-- Monday Slot -->
                                                                <div id="slot_monday" class="tab-pane fade show active">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link" data-toggle="modal" href="#edit_time_slot"><i class="fa fa-edit mr-1"></i>Edit</a>
                                                                    </h4>

                                                                    <!-- Slot List -->
                                                                    <div class="doc-times">
                                                                        <div class="doc-slot-list">
                                                                            8:00 pm - 11:30 pm
                                                                            <a href="javascript:void(0)" class="delete_schedule">
                                                                                <i class="fa fa-times"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="doc-slot-list">
                                                                            11:30 pm - 1:30 pm
                                                                            <a href="javascript:void(0)" class="delete_schedule">
                                                                                <i class="fa fa-times"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="doc-slot-list">
                                                                            3:00 pm - 5:00 pm
                                                                            <a href="javascript:void(0)" class="delete_schedule">
                                                                                <i class="fa fa-times"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="doc-slot-list">
                                                                            6:00 pm - 11:00 pm
                                                                            <a href="javascript:void(0)" class="delete_schedule">
                                                                                <i class="fa fa-times"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /Slot List -->

                                                                </div>
                                                                <!-- /Monday Slot -->

                                                                <!-- Tuesday Slot -->
                                                                <div id="slot_tuesday" class="tab-pane fade">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link" data-toggle="modal" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>
                                                                    <p class="text-muted mb-0">Not Available</p>
                                                                </div>
                                                                <!-- /Tuesday Slot -->

                                                                <!-- Wednesday Slot -->
                                                                <div id="slot_wednesday" class="tab-pane fade">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link" data-toggle="modal" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>
                                                                    <p class="text-muted mb-0">Not Available</p>
                                                                </div>
                                                                <!-- /Wednesday Slot -->

                                                                <!-- Thursday Slot -->
                                                                <div id="slot_thursday" class="tab-pane fade">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link" data-toggle="modal" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>
                                                                    <p class="text-muted mb-0">Not Available</p>
                                                                </div>
                                                                <!-- /Thursday Slot -->

                                                                <!-- Friday Slot -->
                                                                <div id="slot_friday" class="tab-pane fade">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link" data-toggle="modal" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>
                                                                    <p class="text-muted mb-0">Not Available</p>
                                                                </div>
                                                                <!-- /Friday Slot -->

                                                                <!-- Saturday Slot -->
                                                                <div id="slot_saturday" class="tab-pane fade">
                                                                    <h4 class="card-title d-flex justify-content-between">
                                                                        <span>Time Slots</span>
                                                                        <a class="edit-link" data-toggle="modal" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
                                                                    </h4>
                                                                    <p class="text-muted mb-0">Not Available</p>
                                                                </div>
                                                                <!-- /Saturday Slot -->

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

                    <!---Profile Setting-->
                    <div class="row" id="profileSettingTab" style="display: none;">
                        <div class="col-md-12">
                            <!-- Basic Information -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Basic Information</h4>
                                    <div class="row form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="change-avatar">
                                                    <div class="profile-img">
                                                        <img src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
                                                    </div>
                                                    <div class="upload-img">
                                                        <div class="change-photo-btn">
                                                            <span><i class="fa fa-upload"></i> Upload Photo</span>
                                                            <input type="file" class="upload">
                                                        </div>
                                                        <small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Username <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select class="form-control select">
                                                    <option>Select</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label>Date of Birth</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Basic Information -->

                            <!-- About Me -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">About Me</h4>
                                    <div class="form-group mb-0">
                                        <label>Biography</label>
                                        <textarea class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /About Me -->


                            <!-- Clinic Info -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Clinic Info</h4>
                                    <div class="row form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Clinic Name</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Clinic Address</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Clinic Images</label>
                                                <form action="#" class="dropzone"></form>
                                            </div>
                                            <div class="upload-wrap">
                                                <div class="upload-images">
                                                    <img src="assets/img/features/feature-01.jpg" alt="Upload Image">
                                                    <a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                                </div>
                                                <div class="upload-images">
                                                    <img src="assets/img/features/feature-02.jpg" alt="Upload Image">
                                                    <a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Clinic Info -->

                            <!-- Contact Details -->
                            <div class="card contact-card">
                                <div class="card-body">
                                    <h4 class="card-title">Contact Details</h4>
                                    <div class="row form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address Line 1</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Address Line 2</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">City</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">State / Province</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Country</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Postal Code</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Contact Details -->

                            <!-- Pricing -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Pricing</h4>

                                    <div class="form-group mb-0">
                                        <div id="pricing_select">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="price_free" name="rating_option" class="custom-control-input" value="price_free" checked>
                                                <label class="custom-control-label" for="price_free">Free</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="price_custom" name="rating_option" value="custom_price" class="custom-control-input">
                                                <label class="custom-control-label" for="price_custom">Custom Price (per hour)</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row custom_price_cont" id="custom_price_cont" style="display: none;">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="custom_rating_input" name="custom_rating_count" value="" placeholder="20">
                                            <small class="form-text text-muted">Custom price you can add</small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /Pricing -->

                            <!-- Services and Specialization -->
                            <div class="card services-card">
                                <div class="card-body">
                                    <h4 class="card-title">Services and Specialization</h4>
                                    <div class="form-group">
                                        <label>Services</label>
                                        <input type="text" data-role="tagsinput" class="input-tags form-control" placeholder="Enter Services" name="services" value="Tooth cleaning ">
                                        <small class="form-text text-muted">Note : Type & Press enter to add new services</small>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Specialization </label>
                                        <input class="input-tags form-control" type="text" data-role="tagsinput" placeholder="Enter Specialization" name="specialist" value="Children Care,Dental Care" id="specialist">
                                        <small class="form-text text-muted">Note : Type & Press  enter to add new specialization</small>
                                    </div>
                                </div>
                            </div>
                            <!-- /Services and Specialization -->

                            <!-- Education -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Education</h4>
                                    <div class="education-info">
                                        <div class="row form-row education-cont">
                                            <div class="col-12 col-md-10 col-lg-11">
                                                <div class="row form-row">
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="form-group">
                                                            <label>Degree</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="form-group">
                                                            <label>College/Institute</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="form-group">
                                                            <label>Year of Completion</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-more">
                                        <a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Education -->

                            <!-- Experience -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Experience</h4>
                                    <div class="experience-info">
                                        <div class="row form-row experience-cont">
                                            <div class="col-12 col-md-10 col-lg-11">
                                                <div class="row form-row">
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="form-group">
                                                            <label>Hospital Name</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="form-group">
                                                            <label>From</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="form-group">
                                                            <label>To</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="form-group">
                                                            <label>Designation</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-more">
                                        <a href="javascript:void(0);" class="add-experience"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Experience -->

                            <div class="submit-section submit-btn-bottom">
                                <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                            </div>

                        </div>
                    </div>

                    <!--/Profile Setting-->

                    <!--Social Media Setting-->
                    <div class="row" id="socialMediaTab" style="display: none;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    <!-- Social Form -->
                                    <form>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-8">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder='enter your Facebook URL'>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-8">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="enter your Twitter URL ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-8">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="enter your Instagram URL">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-8">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="enter your Pinterest URL">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-8">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="enter your Linkedin URL">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-8">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="enter your Youtube URL">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="submit-section">
                                            <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                                        </div>
                                    </form>
                                    <!-- /Social Form -->

                                </div>
                            </div>

                        </div>
                    </div>


                    <!--/Social Media Setting-->

                    <!--Change Password Tab-->
                    <div class="row" id="changePasswordTab" style="display: none;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-6">

                                            <!-- Change Password Form -->
                                            <form>
                                                <div class="form-group">

                                                    <input type="password" class="form-control" placeholder="Enter Old Password">
                                                    <label style="font-size: 12px;display: none;">Wrong Old Password</label>
                                                </div>
                                                <div class="form-group">

                                                    <input type="password" class="form-control" placeholder="Enter New Password">

                                                </div>
                                                <div class="form-group">

                                                    <input type="password" class="form-control" placeholder="Confirm Password">
                                                </div>
                                                <div class="submit-section">
                                                    <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                                                </div>
                                            </form>
                                            <!-- /Change Password Form -->

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!--/Change Password Tab-->


                </div>
                <!--/Dashboard-->



            </div>

        </div>

    </div>



    <!--/Page Content-->

</div>
<!--/Main Wrapper-->


<!--Modal Section-->

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
                <form>
                    <div class="hours-info">
                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <select class="form-control">
                                                <option>-</option>
                                                <option>12.00 am</option>
                                                <option>12.30 am</option>
                                                <option>1.00 am</option>
                                                <option>1.30 am</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <select class="form-control">
                                                <option>-</option>
                                                <option>12.00 am</option>
                                                <option>12.30 am</option>
                                                <option>1.00 am</option>
                                                <option>1.30 am</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="add-more mb-3">
                        <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Time Slot Modal -->

<!-- Edit Time Slot Modal -->
<div class="modal fade custom-modal" id="edit_time_slot">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Time Slots</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="hours-info">
                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <select class="form-control">
                                                <option>-</option>
                                                <option selected>12.00 am</option>
                                                <option>12.30 am</option>
                                                <option>1.00 am</option>
                                                <option>1.30 am</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <select class="form-control">
                                                <option>-</option>
                                                <option>12.00 am</option>
                                                <option selected>12.30 am</option>
                                                <option>1.00 am</option>
                                                <option>1.30 am</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <select class="form-control">
                                                <option>-</option>
                                                <option>12.00 am</option>
                                                <option selected>12.30 am</option>
                                                <option>1.00 am</option>
                                                <option>1.30 am</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <select class="form-control">
                                                <option>-</option>
                                                <option>12.00 am</option>
                                                <option>12.30 am</option>
                                                <option selected>1.00 am</option>
                                                <option>1.30 am</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
                        </div>

                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <select class="form-control">
                                                <option>-</option>
                                                <option>12.00 am</option>
                                                <option>12.30 am</option>
                                                <option selected>1.00 am</option>
                                                <option>1.30 am</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <select class="form-control">
                                                <option>-</option>
                                                <option>12.00 am</option>
                                                <option>12.30 am</option>
                                                <option>1.00 am</option>
                                                <option selected>1.30 am</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
                        </div>

                    </div>

                    <div class="add-more mb-3">
                        <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Time Slot Modal -->


<!--/Modal Section-->

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

</body>
</html>