<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 04-Jul-20
 * Time: 7:10 PM
 */

    require_once ("database-connection.php");
    session_start();
if (!isset($_COOKIE['username'])){
    header("location:../login.php");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}

    $countDoctors=mysqli_num_rows($con->query("select * from users where user_type='doctor' and user_status='approved'"));
    $countPatients=mysqli_num_rows($con->query("select * from users where user_type='patient'"));
    $countAppointmetns=mysqli_num_rows($con->query("select * from appointments"));
    $countingPatients=$countPatients;

    $doctorList=$con->query("select * from users where user_type='doctor' and user_status='approved'");

    $patientList=$con->query("select * from users where user_type='patient'");
    $appointments=$con->query("select * from appointments");

    $superAdmin=$con->query("select * from users where user_type='super admin'")->fetch_array();
    $super_user_id=$superAdmin['user_id'];
    $superAdminImage=$con->query("select file_name from pictures where user_id='$super_user_id'")->fetch_array()['file_name'];

    if (isset($_REQUEST['delete'])){
        $user_id=$_REQUEST['delete'];

        mysqli_query($con,"delete from users where user_id='$user_id'");
        header("location:index.php?deleted");
        return;

    } elseif (isset($_REQUEST['deletePatient'])){
    $user_id=$_REQUEST['deletePatient'];

    mysqli_query($con,"delete from users where user_id='$user_id'");
    header("location:index.php?deletedPatient");
    return;

}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Super Admin - Health Guide</title>

    <link href="../assets/img/favicon.png" rel="icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">

    <link rel="stylesheet" href="assets/plugins/morris/morris.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Header -->
    <div class="header">

        <!-- Logo -->
        <div class="header-left">
            <a href="../index.php" class="logo">
                <img src="../assets/img/logo1.png" alt="Logo">
            </a>

        </div>
        <!-- /Logo -->

        <a href="" id="toggle_btn">
            <i class="fe fe-text-align-left"></i>
        </a>


        <!-- Mobile Menu Toggle -->
        <a class="mobile_btn" id="mobile_btn">
            <i class="fa fa-bars"></i>
        </a>
        <!-- /Mobile Menu Toggle -->

        <!-- Header Right Menu -->
        <ul class="nav user-menu">



            <!-- User Menu -->
            <li class="nav-item dropdown has-arrow">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <span class="user-img"><img class="rounded-circle" src="../assets/img/profiles/super.jpg" width="30" alt="<?=$superAdmin['user_name']?>"></span>
                </a>
                <div class="dropdown-menu">
                    <div class="user-header">

                        <div class="user-text">
                            <h6>Mr. <?=$superAdmin['user_name']?></h6>
                            <p class="text-muted mb-0">Administrator</p>
                        </div>
                    </div>
                    <a class="dropdown-item" href="index.php">Dashboard</a>
                    <a class="dropdown-item" href="profile.php">Profile Setting</a>
                    <a class="dropdown-item" href="../logout.php?doctor">Logout</a>
                </div>
            </li>
            <!-- /User Menu -->

        </ul>
        <!-- /Header Right Menu -->

    </div>
    <!-- /Header -->

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="active">
                        <a href="index.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                    </li>

                    <li class="menu-title">
                        <span>Doctor Accounts</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fe fe-user-plus"></i> <span>Doctors</span><span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="register-outside-doctor.php">Register Outside Doctor</a></li>
                            <li><a href="approve-doctor-accounts.php">Approve Doctor Accounts</a></li>
                            <li><a href="delete-doctor-accounts.php">Delete Doctor Account</a></li>
                        </ul>
                    </li>
                    <li class="menu-title">
                        <span>MOHA Accounts</span>
                    </li>
                    <li class="submenu">
                        <a><i class="fe fe-user"></i> <span>MOHA Employee</span><span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="register-moha.php">Register MOHA </a></li>

                            <li><a href="delete-moha.php">Delete MOHA</a></li>
                        </ul>
                    </li>
                    <li class="menu-title">
                        <span>Delete Patient Accounts</span>
                    </li>
                    <li>
                        <a href="delete-patients.php"><i class="fe fe-user"></i> <span>Patients</span></a>
                    </li>
                    <li>
                        <a href="profile.php"><i class="fe fe-user"></i> <span>Profile Setting</span></a>
                    </li>
                    <li>
                        <a href="../logout.php?doctor"><i class="fe fe-logout"></i> <span>Logout</span></a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <!-- /Sidebar -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Welcome Super Admin!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-xl-4 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
										<span class="dash-widget-icon text-primary border-primary">
                                            <i class=""></i>
										</span>
                                <div class="dash-count">
                                    <h3><?=$countDoctors?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Doctors</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
										<span class="dash-widget-icon text-success">
											<i class="fe fe-credit-card"></i>
										</span>
                                <div class="dash-count">
                                    <h3><?=$countingPatients?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">

                                <h6 class="text-muted">Patients</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
										<span class="dash-widget-icon text-danger border-danger">
											<i class="fe fe-money"></i>
										</span>
                                <div class="dash-count">
                                    <h3><?=$countAppointmetns?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">

                                <h6 class="text-muted">Appointment</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 d-flex">


                    <div class="card card-table flex-fill" style="overflow-y:scroll; overflow-x:hidden; height:400px;">
                        <div class="card-header">
                            <h4 class="card-title">Doctors Accounts List <small class="btn btn-sm bg-success-light float-right <?php if (!isset($_REQUEST['deleted'])){ echo 'd-none';}?>">Deleted Successfully</small> </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                    <tr>
                                        <th>Doctor Name</th>
                                        <th>Speciality</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        while ($row=$doctorList->fetch_array()) {
                                            $doc_user_id=$row['user_id'];
                                            $doc_id=$row['doc_id'];
                                            $doctorImage=$con->query("select file_name from pictures where user_id='$doc_user_id'")->fetch_array()['file_name'];

                                            $doctorDetails=$con->query("select * from doctor where doc_id='$doc_id'")->fetch_array();


                                            ?>


                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="../doctor-profile.php?doc_id=<?=$doctorDetails['doc_id']?>" class="avatar avatar-sm mr-2"><img
                                                                    class="avatar-img rounded-circle"
                                                                    src="../assets/img/doctors/<?=$doctorImage?>"
                                                                    alt=""></a>
                                                        <a href="../doctor-profile.php?doc_id=<?=$doctorDetails['doc_id']?>">Dr. <?=$doctorDetails['doc_firstName']?></a>
                                                    </h2>
                                                </td>
                                                <td><?=$doctorDetails['doc_specialization']?></td>
                                                <form action="index.php" method="post">

                                                <td>
                                                    <button name="delete" value="<?=$doc_user_id?>" class="btn btn-sm bg-danger-light"><i
                                                                class="fe fe-trash"></i></button>
                                                </td>
                                                </form>
                                            </tr>


                                            <?php

                                        }
                                    ?>


                                    <?php
                                    $doctorList=$con->query("select * from users where user_type='outside doctor' and user_status='approved'");
                                    while ($row=$doctorList->fetch_array()) {
                                        $doc_user_id=$row['user_id'];
                                        $email=$row['user_username'];
                                        $doctorImage=$con->query("select file_name from pictures where user_id='$doc_user_id'")->fetch_array()['file_name'];

                                        $doctorDetails=$con->query("select * from outsidedoctor where email='$email'")->fetch_array();


                                        ?>


                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="../outside-doctor-profile.php?username=<?=$doctorDetails['email']?>" class="avatar avatar-sm mr-2"><img
                                                                class="avatar-img rounded-circle"
                                                                src="../assets/img/doctors/<?=$doctorImage?>"
                                                                alt=""></a>
                                                    <a href="../outside-doctor-profile.php?username=<?=$doctorDetails['email']?>">Dr. <?=$doctorDetails['firstname']?><small>(Outside)</small></a>
                                                </h2>
                                            </td>
                                            <td><?=$doctorDetails['specialization']?></td>
                                            <form action="index.php" method="post">

                                                <td>
                                                    <button name="delete" value="<?=$doc_user_id?>" class="btn btn-sm bg-danger-light"><i
                                                                class="fe fe-trash"></i></button>
                                                </td>
                                            </form>
                                        </tr>


                                        <?php

                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-6 d-flex" >


                    <div class="card  card-table flex-fill" style="overflow-y:scroll; overflow-x:hidden; height:400px;">
                        <div class="card-header">
                            <h4 class="card-title">Patients List <small class="btn btn-sm bg-success-light float-right <?php if (!isset($_REQUEST['deletedPatient'])){ echo 'd-none';}?>" >Deleted Successfully !</small></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        while ($row=$patientList->fetch_array()) {
                                            $user_id=$row['user_id'];
                                            $patientImage=$con->query("select file_name from pictures where user_id='$user_id'")->fetch_array()['file_name'];

                                            ?>
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a class="avatar avatar-sm mr-2"><img
                                                                    class="avatar-img rounded-circle"
                                                                    src="../assets/img/patients/<?=$patientImage?>"
                                                                    alt="No"></a>
                                                        <a ><?=$row['user_name']?> </a>
                                                    </h2>
                                                </td>
                                                <td><?=$row['user_contact']?></td>
                                                <td><?=$row['user_address']?></td>
                                                <form action="index.php" method="post">

                                                <td>
                                                    <button name="deletePatient" value="<?=$user_id?>" class="btn btn-sm bg-danger-light"><i
                                                                class="fe fe-trash"></i></button>
                                                </td>
                                                </form>

                                            </tr>
                                            <?php
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Feed Activity -->

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <!-- Recent Orders -->
                    <div class="card card-table" style="overflow-y:scroll; overflow-x:hidden; height:400px;">
                        <div class="card-header">
                            <h4 class="card-title">Appointment List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                    <tr>
                                        <th>Doctor Name</th>
                                        <th>Speciality</th>
                                        <th>Patient Name</th>
                                        <th>Apointment Time</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                     while ($row=$appointments->fetch_array()){
                                    $doc_user_id = $row['doc_user_id'];
                                    $doc_user_details = $con->query("select * from users where user_id='$doc_user_id'")->fetch_array();
                                    $doc_id = $doc_user_details['doc_id'];
                                    $doctorImage = $con->query("select file_name from pictures where user_id='$doc_user_id'")->fetch_array()['file_name'];
                                    $doctorDetails = $con->query("select * from doctor where doc_id='$doc_id'")->fetch_array();

                                    if ($doc_id!=null){

                                    if (!$row['visitor_id'] == null){
                                        $visitor_id=$row['visitor_id'];
                                        $visitorDetails=$con->query("select * from visitors where id='$visitor_id'")->fetch_array();
                                    ?>

                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="../doctor-profile.php>doc_id=<?=$doc_id?>" class="avatar avatar-sm mr-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="../assets/img/doctors/<?= $doctorImage ?>"
                                                            alt="Doctor Image"></a>
                                                <a href="../doctor-profile.php?doc_id=<?=$doc_id?>">Dr. <?= $doc_user_details['user_name']?></a>
                                            </h2>
                                        </td>
                                        <td><?=$doctorDetails['doc_specialization']?></td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a class="avatar avatar-sm mr-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="../assets/img/patients/visitor.png" alt="No"></a>
                                                <a>Mr. <?=$visitorDetails['name']?> <small>(visitor)</small> </a>
                                            </h2>
                                        </td>
                                        <td><?=$row['date']?> <span class="text-primary d-block"><?=$row['time']?></span>
                                        </td>


                                    </tr>

                                    <?php
                                    }else{
                                        $user_id=$row['user_id'];
                                        $userImage=$con->query("select file_name from pictures where user_id='$user_id'")->fetch_array()['file_name'];
                                        $userDetails=$con->query("select * from users where user_id='$user_id'")->fetch_array();



                                   ?>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="../doctor-profile.php>doc_id=<?=$doc_id?>" class="avatar avatar-sm mr-2"><img
                                                                class="avatar-img rounded-circle"
                                                                src="../assets/img/doctors/<?= $doctorImage ?>"
                                                                alt="Doctor Image"></a>
                                                    <a href="../doctor-profile.php?doc_id=<?=$doc_id?>">Dr. <?= $doctorDetails['doc_firstName'] ?></a>
                                                </h2>
                                            </td>
                                            <td><?=$doctorDetails['doc_specialization']?></td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a class="avatar avatar-sm mr-2"><img
                                                                class="avatar-img rounded-circle"
                                                                src="../assets/img/patients/<?=$userImage?>" alt="No"></a>
                                                    <a>Mr. <?=$userDetails['user_name']?> </a>
                                                </h2>
                                            </td>
                                            <td><?=$row['date']?> <span class="text-primary d-block"><?=$row['time']?></span>
                                            </td>


                                        </tr>


                                        <?php
                                    }}

                                    }
                                    ?>



                                    <?php
                                    $appointments=$con->query("select * from appointments");
                                    while ($row=$appointments->fetch_array()){
                                        $doc_user_id = $row['doc_user_id'];
                                        $doc_user_details = $con->query("select * from users where user_id='$doc_user_id'")->fetch_array();
                                        $email=$doc_user_details['user_username'];
                                        $doctorImage = $con->query("select file_name from pictures where user_id='$doc_user_id'")->fetch_array()['file_name'];
                                        $doctorDetails = $con->query("select * from outsidedoctor where email='$email'")->fetch_array();

                                        if ($doc_user_details['user_type']=='outside doctor'){

                                            if (!$row['visitor_id'] == null){
                                                $visitor_id=$row['visitor_id'];
                                                $visitorDetails=$con->query("select * from visitors where id='$visitor_id'")->fetch_array();
                                                ?>

                                                <tr>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="../outside-doctor-profile.php>username=<?=$email?>" class="avatar avatar-sm mr-2"><img
                                                                        class="avatar-img rounded-circle"
                                                                        src="../assets/img/doctors/<?= $doctorImage ?>"
                                                                        alt="Doctor Image"></a>
                                                            <a href="../outside-doctor-profile.php?username=<?=$email?>">Dr. <?= $doctorDetails['firstname']?><small>(Outside)</small></a>
                                                        </h2>
                                                    </td>
                                                    <td><?=$doctorDetails['specialization']?></td>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a class="avatar avatar-sm mr-2"><img
                                                                        class="avatar-img rounded-circle"
                                                                        src="../assets/img/patients/visitor.png" alt="No"></a>
                                                            <a>Mr. <?=$visitorDetails['name']?> <small>(visitor)</small> </a>
                                                        </h2>
                                                    </td>
                                                    <td><?=$row['date']?> <span class="text-primary d-block"><?=$row['time']?></span>
                                                    </td>


                                                </tr>

                                                <?php
                                            }else{
                                                $user_id=$row['user_id'];
                                                $userImage=$con->query("select file_name from pictures where user_id='$user_id'")->fetch_array()['file_name'];
                                                $userDetails=$con->query("select * from users where user_id='$user_id'")->fetch_array();



                                                ?>
                                                <tr>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="../outside-doctor-profile.php>username=<?=$email?>" class="avatar avatar-sm mr-2"><img
                                                                        class="avatar-img rounded-circle"
                                                                        src="../assets/img/doctors/<?= $doctorImage ?>"
                                                                        alt="Doctor Image"></a>
                                                            <a href="../outside-doctor-profile.php?username=<?=$email?>">Dr. <?= $doctorDetails['firstname'] ?><small>(Outside)</small></a>
                                                        </h2>
                                                    </td>
                                                    <td><?=$doctorDetails['specialization']?></td>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a class="avatar avatar-sm mr-2"><img
                                                                        class="avatar-img rounded-circle"
                                                                        src="../assets/img/patients/<?=$userImage?>" alt="No"></a>
                                                            <a>Mr. <?=$userDetails['user_name']?> </a>
                                                        </h2>
                                                    </td>
                                                    <td><?=$row['date']?> <span class="text-primary d-block"><?=$row['time']?></span>
                                                    </td>


                                                </tr>


                                                <?php
                                            }}

                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Recent Orders -->

                </div>
            </div>

        </div>
    </div>
    <!-- /Page Wrapper -->

</div>
<!-- /Main Wrapper -->

<!-- jQuery -->
<script src="assets/js/jquery-3.2.1.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Slimscroll JS -->
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/plugins/raphael/raphael.min.js"></script>
<script src="assets/plugins/morris/morris.min.js"></script>
<script src="assets/js/chart.morris.js"></script>

<!-- Custom JS -->
<script  src="assets/js/script.js"></script>

</body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->
</html>
