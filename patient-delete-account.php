<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 03-Aug-20
 * Time: 10:04 PM
 */

require_once ('database-connection.php');
session_start();

if (!isset($_COOKIE['username'])){
    header("location:index.php?haveaccount");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}

$username=$_SESSION['username'];
$patientDetails=$con->query("select * from users where user_username='$username'")->fetch_array();

$user_id=$patientDetails['user_id'];

$patientImage=$con->query("select * from pictures where user_id='$user_id' ")->fetch_array()['file_name'];


$appointments=$con->query("select * from appointments where user_id='$user_id'");


if (isset($_REQUEST['yes'])){


    $con->query("delete from users where user_username='$username'");
    setcookie("username", "", time() - 10);
    unset($_SESSION['username']);
    header("location:index.php");
    return;
}

/*
 * Messages Counter
 */
$counterMessages=$con->query("select * from chat_message where to_user_id='$user_id' and status='not seen'");
$counter=mysqli_num_rows($counterMessages);

?>


<html>
<head>
    <meta charset="utf-8">
    <title>Patient Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<!--Main Wrapper-->
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
									<img class="rounded-circle" src="assets/img/patients/<?=$patientImage?>" width="31" alt="<?=$patientDetails['user_name']?>">
								</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="assets/img/patients/<?=$patientImage?>" alt="Patient Image" class="avatar-img rounded-circle">
                            </div>
                            <div class="user-text">
                                <h6><?=$patientDetails['user_name']?></h6>
                                <p class="text-muted mb-0">Patient</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="patient-dashboard.php">Dashboard</a>
                        <a class="dropdown-item" href="patient-profile-setting.php">Profile Settings</a>
                        <a class="dropdown-item" href="logout.php?patient">Logout</a>
                    </div>
                </li>
                <!-- /User Menu -->

            </ul>
        </nav>


    </header>
    <!--/Header-->

    <!--Page Content-->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Profile Sidebar -->
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    <div class="profile-sidebar">
                        <div class="widget-profile pro-widget-content">
                            <div class="profile-info-widget">
                                <a href="#" class="booking-doc-img">
                                    <img src="assets/img/patients/<?=$patientImage?>" alt="Patient Image">
                                </a>
                                <div class="profile-det-info">
                                    <h3><?=$patientDetails['user_name']?></h3>
                                    <div class="patient-details">

                                        <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?=$patientDetails['user_address']?>, Afghanistan</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-widget">
                            <nav class="dashboard-menu">
                                <ul>
                                    <li>
                                        <a href="patient-dashboard.php">
                                            <i class="fas fa-columns"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="patient-chats.php">
                                            <i class="fas fa-comments"></i>
                                            <span>Message</span>
                                            <small class="unread-msg"><?=$counter?></small>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="patient-profile-setting.php">
                                            <i class="fas fa-user-cog"></i>
                                            <span>Profile Settings</span>
                                        </a>
                                    </li>
                                    <li id="patientPassword">
                                        <a href="patient-change-password.php">
                                            <i class="fas fa-lock"></i>
                                            <span>Change Password</span>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="patient-delete-account.php">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Delete Account</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="logout.php?patient">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
                <!-- / Profile Sidebar -->

                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="row" id="scheduleTiming">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Delete Account </h4>
                                            <h5 class="text-muted">Deleting your user account removes all your personal data owned by your account and the data associated with your account.The account name and username (email address/phone number) associated with the account becomes available for use with a different Health Guide account.</h5>
                                            <div class="mt-3 text-md-center">
                                                <small class="btn-sm bg-danger-light">Note: Once your account has been deleted, Health Guide cannot restore your content.</small>
                                            </div>
                                            <button type="button" class="btn bg-danger-light text-md-center mt-4 float-right" data-toggle="modal" data-target="#confirm">Delete your account</button>

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



</div>

<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body bg-success-light">
                <strong class="text-md-center">  Do you want to delete your account? </strong>
            </div>

            <div class="modal-footer ">
                <form action="delete-doctor-account.php" method="post">
                    <button type="submit" class="btn bg-danger-light"  name="yes">Yes, Delete my account</button>
                    <button type="submit" class="btn bg-success-light" data-dismiss="modal">No</button>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>



<!-- Select2 JS -->
<script src="assets/plugins/select2/js/select2.min.js"></script>

<!-- Datetimepicker JS -->
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>





<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>

</body>

</html>




