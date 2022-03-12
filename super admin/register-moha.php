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

$superAdmin=$con->query("select * from users where user_type='super admin'")->fetch_array();
$super_user_id=$superAdmin['user_id'];
$superAdminImage=$con->query("select file_name from pictures where user_id='$super_user_id'")->fetch_array()['file_name'];


    $msgN=false;
    $msgSelectCon=false;
    $msgP=false;
    $msgA=false;
    $msgE=false;


if (isset($_REQUEST['submit'])){

        $name=$_REQUEST['name'];
        $username=$_REQUEST['username'];
        $pass=$_REQUEST['password'];
        $address=$_REQUEST['address'];
        $contact=$_REQUEST['contact'];


        $chckN=true;
        $chckC=true;
        $chckP=true;
        $chckA=true;
        $chckDigits=true;
        $chckE=true;

    $hash=password_hash($pass,PASSWORD_DEFAULT);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)){
        $msgN=true;
        $chckN=false;
    } if (!preg_match("/^[a-zA-Z ]*$/",$address)){
        $msgA=true;
        $chckA=false;
    }if (!preg_match('/^[0-9]{10}+$/',$contact)){
        $msgSelectCon=true;
        $chckC=false;
        $chckDigits=false;


    }if ($chckDigits==true){

        $subDigit=substr($contact,0,3);

        if (($subDigit=="078") || ($subDigit=="077") || ($subDigit=="076") || ($subDigit=="079") || ($subDigit=="072") || ($subDigit=="070")){
            $msgSelectCon=false;
            $chckC=true;
        }else{
            $msgSelectCon=true;
            $chckC=false;

        }

    }if (strlen($pass)<8){
        $msgP=true;
        $chckP=false;
    }if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$username)){
        $msgE=true;
        $chckE=false;

    }if (($chckN==true) && ($chckA==true) && ($chckC==true) && ($chckP==true) && ($chckE==true)) {


        if (mysqli_query($con, "insert into users value ('','$name','$username','$hash','$address','$contact','moha','approved' ,null )")) {
            header("location:register-moha.php?register");
            return;
        } else {
            header("location:register-moha.php?notregister");
            return;
        }

    }

    }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Moha Registration - Super Admin</title>

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
                    <span class="user-img"><img class="rounded-circle" src="../assets/img/profiles/super.jpg" width="31" alt="<?=$superAdmin['user_name']?>"></span>
                </a>
                <div class="dropdown-menu">
                    <div class="user-header">
                        <div class="avatar avatar-sm">
                            <img src="../assets/img/profiles/super.jpg" alt="No" class="avatar-img rounded-circle">
                        </div>
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
                    <li>
                        <a href="index.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                    </li>

                    <li class="menu-title">
                        <span>Doctor Accounts</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fe fe-user-plus"></i> <span>Doctors</span><span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a  href="register-outside-doctor.php">Register Outside Doctor</a></li>
                            <li><a href="approve-doctor-accounts.php">Approve Doctor Accounts</a></li>
                            <li><a href="delete-doctor-accounts.php">Delete Doctor Account</a></li>
                        </ul>
                    </li>
                    <li class="menu-title">
                        <span>MOHA Accounts</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fe fe-user"></i> <span>MOHA Employee</span><span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="active" href="register-moha.php">Register MOHA </a></li>

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
            <!--Doctor Registration Area-->
            <div class="mohaForms" id="doctorRegistration">

                <form action="register-moha.php" method="post">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">MOHA-Employee Registration <small class="float-right btn btn-sm bg-success-light <?php if (!isset($_REQUEST['register'])){echo 'd-none';} ?>">Register Successfully !</small>
                                <small class="float-right btn btn-sm bg-danger-light <?php if (!isset($_REQUEST['notregister'])){echo 'd-none';} ?>">Not Register !</small>
                            </h4>
                            <div class="row form-row">
                                <div class="col-md-12">
                                    <div class="form-group">

                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>MOHA-Employee Name <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control <?php if ($msgN==true){echo "bg-danger-light"; } ?>" name="name" minlength="5" maxlength="40"  value="<?php if (isset($_REQUEST['name'])){echo $_REQUEST['name'];} ?>" required>
                                        <div class="d-flex justify-content-between mt-1 ml-2"><small class="text-muted"><span id="firstchars">40</span> characters only</small></div>
                                        <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>


                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username (Email) <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control <?php if ($msgE==true){echo "bg-danger-light"; } ?>" name="username" value="<?php if (isset($_REQUEST['username'])){echo $_REQUEST['username'];} ?>" required>
                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgE==false){echo 'd-none';} ?>">enter a valid email</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control <?php if ($msgP==true){echo "bg-danger-light"; } ?>" name="password" value="<?php if (isset($_REQUEST['password'])){echo $_REQUEST['password'];} ?>" required>
                                        <div class="d-flex justify-content-between text-muted mt-1 ml-2"><small class="text-muted">Note: Password length must not less then 8 characters</small></div>
                                        <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgP==false){echo 'd-none'; } ?>">Password length must not less then 8 characters</small>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address" value="Kabul" minlength="5" readonly>
                                        <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgA==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Number <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control <?php if ($msgSelectCon==true){echo "bg-danger-light"; } ?>" name="contact" value="<?php  if (isset($_REQUEST['contact'])){echo $_REQUEST['contact'];}  ?>" required>
                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgSelectCon==false){echo 'd-none';} ?>">Enter a valid Phone Number</small>

                                    </div>
                                </div>


                                <div class="submit-section" style="position: relative; margin-left: 400px; margin-right: 400px;">

                                    <button type="submit" class="btn bg-success-light submit-btn" name="submit">Register</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <!--/Doctor Registration Area-->



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



<!-- Custom JS -->
<script  src="assets/js/script.js"></script>

</body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->
</html>

