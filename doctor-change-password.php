<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 04-Jul-20
 * Time: 3:12 PM
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

$doc=$con->query("select * from users where user_username='$username'")->fetch_array();
$doc_id=$doc['doc_id'];
$doc_user_id=$doc['user_id'];
$doctorDetails=$con->query("select * from doctor where doc_id='$doc_id'")->fetch_array();
$doctorProfile=$con->query("select * from doctorprofile where user_id='$doc_user_id'")->fetch_array();
$doctorImage=$con->query("select file_name from pictures where user_id='$doc_user_id'")->fetch_array()['file_name'];

$wrongPassword=false;
    $wrongConfirmPassword=false;

$length=true;
$upCase=true;
$lowCase=true;
$num=true;
$speCharacter=true;
$strength=false;
$checkWrong=false;
$checkMatch=false;
$checkStrngth=false;


if (!isset($_SESSION['username'])){

    header("Location: login.php");
    return;
    }elseif ((isset($_REQUEST['oldPassword'])) && (isset($_REQUEST['newPassword'])) && (isset($_REQUEST['confirmPassword'])) && (isset($_REQUEST['save']))){

        $oldPassword=$_REQUEST['oldPassword'];
        $newPassword=$_REQUEST['newPassword'];
        $confirmPassword=$_REQUEST['confirmPassword'];


        $selectOldPassword=$con->query("select user_password from users where user_username='$username'")->fetch_array()['user_password'];

    $uppercase=preg_match("@[A-Z]@",$newPassword);
    $lowercase=preg_match("@[a-z]@",$newPassword);
    $number=preg_match("@[0-9]@",$newPassword);
    $specialCharacters=preg_match("@[^\w]@",$newPassword);

        if (!password_verify($oldPassword,$selectOldPassword)){
            $wrongPassword=true;
        }elseif ($newPassword!==$confirmPassword){
            $wrongConfirmPassword=true;
        }elseif ($newPassword!=null){
            if (strlen($newPassword)<8){
                $length=false;
                $checkStrngth=true;
            }if (!$uppercase){
                $upCase=false;
                $checkStrngth=true;
            }if (!$lowercase){
                $lowCase=false;
                $checkStrngth=true;
            }if (!$number){
                $num=false;
                $checkStrngth=true;

            }if (!$specialCharacters){
                $speCharacter=false;
                $checkStrngth=true;
            }
            $strength=true;
        }if (($checkWrong==false) && ($checkMatch==false) && ($checkStrngth==false) && ($wrongPassword==false) && ($wrongConfirmPassword==false)){
            $newPassword=password_hash($newPassword,PASSWORD_DEFAULT);
            mysqli_query($con,"update users set user_password='$newPassword' where user_username='$username'");
            header("location:doctor-change-password.php?changed");
            return;
        }



    }elseif (isset($_REQUEST['logout'])){
        header("location:logout.php?doctor");
        return;
    }


/*
 * Messages Counter
 */
$doc_user_id=$con->query("select user_id from users where user_username='$username'")->fetch_array()['user_id'];
$counterMessages=$con->query("select * from chat_message where to_user_id='$doc_user_id' and status='not seen'");
$cou=mysqli_num_rows($counterMessages);

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
    <title>Change Password - Doctor Dashboard</title>


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
                                        <h5 class="mb-0"><?php echo $doctorProfile['profile_specilizations'];?> - <?=$doctorDetails['doc_qualification']?> </h5>
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
                                    <li>
                                        <a href="doctor-appointments.php">
                                            <i class="fas fa-calendar-check"></i>
                                            <span>Appointments</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="doctor-patients.php">
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
                                            <small class="unread-msg"><?=$cou?></small>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="doctor-profile-setting.php">
                                            <i class="fas fa-user-cog"></i>
                                            <span>Profile Settings</span>
                                        </a>
                                    </li>

                                    <li class="active">
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

                    <!--Change Password Tab-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-6">

                                            <!-- Change Password Form -->
                                            <form action="doctor-change-password.php" method="post">
                                                <div class="form-group">
                                                    <label class="mt-1 ml-2 bg-success-light" style="font-size: 12px;display:<?php if (!isset($_REQUEST['changed'])){ echo "none"; }  ?>;">Password Changed</label>

                                                    <input type="password" name="oldPassword" class="form-control <?php if ($wrongPassword==true){ echo "bg-danger-light"; }  ?>" placeholder="Enter Old Password" value="<?php if (isset($_REQUEST['oldPassword'])){echo $_REQUEST['oldPassword']; } ?>" required>
                                                    <label class="mt-1 ml-2 bg-danger-light" style="font-size: 12px;display:<?php if ($wrongPassword==false){ echo "none"; }  ?>;">Wrong Old Password</label>
                                                </div>
                                                <div class="form-group">

                                                    <input type="password" name="newPassword" class="form-control <?php if (($strength==true) || ($wrongConfirmPassword==true)){ echo "bg-danger-light"; }  ?>" placeholder="Enter New Password" value="<?php if (isset($_REQUEST['newPassword'])){echo $_REQUEST['newPassword']; } ?>" required>

                                                </div>
                                                <div class="form-group">

                                                    <input type="password" name="confirmPassword" class="form-control <?php if (($strength==true) || ($wrongConfirmPassword==true)){ echo "bg-danger-light"; }  ?>" placeholder="Confirm Password" value="<?php if (isset($_REQUEST['confirmPassword'])){echo $_REQUEST['confirmPassword']; } ?>" required>
                                                    <label class="mt-1 ml-2 bg-danger-light" style="font-size: 12px;display:<?php if ($wrongConfirmPassword==false){ echo "none"; }  ?>;">Password doesn't match</label>

                                                    <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($length==false){echo "bg-danger-light";}elseif($length==true){echo "bg-success-light";} ?>">Password should be at least 8 characters in length</small><br>
                                                    <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($upCase==false){echo "bg-danger-light";}elseif($upCase==true){echo "bg-success-light";} ?>">Password should include at least one upper case letter</small><br>
                                                    <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($num==false){echo "bg-danger-light";}elseif($num==true){echo "bg-success-light";} ?>">Password should include at least one number</small><br>
                                                    <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($speCharacter==false){echo "bg-danger-light";}elseif($speCharacter==true){echo "bg-success-light";} ?>">Password should include at least one special character</small><br>


                                                </div>
                                                <div class="submit-section">
                                                    <button type="submit" name="save" class="btn btn-sm btn-primary submit-btn">Save Changes</button>
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




            </div>


        </div>
    </div>
</div>

<!-----/Main Wrapper  ---->
<!-------------------------------->
<!----    >
<!-------------------------------->



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

