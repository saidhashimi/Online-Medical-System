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

    $doctorList=$con->query("select * from users where user_type='doctor' and user_status='unapproved'");

    $showCheck=true;
    $showEmail=false;
    $deleteButton=false;

    if (isset($_REQUEST['username'])){
        $username=$_REQUEST['username'];

        $result=mysqli_query($con,"select doc_email from doctor where doc_email='$username'");
        $counter=mysqli_num_rows($result);
        if ($counter==1){
            $showEmail=true;
            $showCheck=false;
            $deleteButton=false;
        }else{
            $showCheck=false;
            $showEmail=false;
            $deleteButton=true;
        }
    }elseif (isset($_REQUEST['delete'])){
        $username=$_REQUEST['delete'];

        mysqli_query($con,"delete from users where user_username='$username'");
        header("location:approve-doctor-accounts.php?deleted");
        return;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Approve Doctor Accounts - Health Guide</title>
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
                            <li><a href="register-outside-doctor.php">Register Outside Doctor</a></li>
                            <li><a class="active" href="approve-doctor-accounts.php">Approve Doctor Accounts</a></li>
                            <li><a href="delete-doctor-accounts.php">Delete Doctor Account</a></li>
                        </ul>
                    </li>
                    <li class="menu-title">
                        <span>MOHA Accounts</span>
                    </li>
                    <li class="submenu">
                        <a href="patient-list.html"><i class="fe fe-user"></i> <span>MOHA Employee</span><span class="menu-arrow"></span></a>
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
                <div class="col-md-12">

                    <!-- Recent Orders -->
                    <div class="card card-table" >
                        <div class="card-header">
                            <h4 class="card-title">Doctor Account Lists <small class="float-right btn btn-sm bg-success-light <?php if (!isset($_REQUEST['deleted'])){echo 'd-none'; } ?>">Deleted Successfully !</small>
                                <small class="float-right btn btn-sm bg-success-light <?php if (!isset($_REQUEST['sended'])){echo 'd-none'; } ?>">Email Send !</small>
                                <small class="float-right btn btn-sm bg-danger-light <?php if (!isset($_REQUEST['notsended'])){echo 'd-none'; } ?>">Email Not Send !</small>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Username</th>
                                        <th>Address</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        while ($row=$doctorList->fetch_array()) {


                                            ?>
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="profile.html">Dr. <?=$row['user_name']?></a>
                                                    </h2>
                                                </td>
                                                <td><?=$row['user_username']?></td>
                                                <td>
                                                    <?=$row['user_address']?>
                                                </td>
                                                <td><?=$row['user_contact']?></td>
                                                <td>
                                                    <div class="status-toggle">
                                                        <input type="checkbox" id="<?=$row['user_id']?>" class="check">
                                                        <label for="<?=$row['user_id']?>" class="checktoggle">checkbox</label>
                                                    </div>
                                                </td>
                                                <?php
                                                $id=null;
                                                if(isset($_REQUEST['id'])){
                                                 $id=$_REQUEST['id'];
                                                 }
                                                    if ($row['user_id']==$id){

                                                ?>

                                                <td class="<?php if (($deleteButton==false) && ($showCheck==false)){echo 'd-block'; }else{echo 'd-none';}?>">
                                                    <a href="send-email.php?email=<?=$row['user_username']?>" class="btn btn-sm bg-success-light"><i class="fa fa-send-o mr-1"></i> Send Email</a> <small>(Avaliable)</small>
                                                </td>
                                                <td class="<?php if (($showCheck==false) && ($showEmail==false)){echo 'd-block'; }else{echo 'd-none';}?>">
                                                    <a href="approve-doctor-accounts.php?delete=<?=$row['user_username']?>" class="btn btn-sm bg-danger-light"><i class="fe fe-trash mr-1"></i> Delete Account</a> <small>(Wrong)</small>
                                                </td>
                                                <?php
                                                }else{

                                                ?>
                                                        <td>
                                                            <a href="approve-doctor-accounts.php?username=<?=$row['user_username']?>&id=<?=$row['user_id']?>" class="btn btn-sm bg-primary-light"><i class="fa fa-check-circle-o mr-1"></i>Check Username</a>
                                                        </td>
                                                <?php
                                                }
                                                ?>


                                            </tr>
                                            <?php
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
