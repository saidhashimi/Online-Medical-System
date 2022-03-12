

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

$msgFirstName=false;
$msgLastName=false;

$msgSelectSpe=false;

$msgSelectG=false;
$msgSelectL=false;
$msgSelectCon=false;
$doctorAva=false;
//////////////////////
$msgLP=false;
$msgLC=false;
$msgLB=false;
$msgE=false;


    if (isset($_REQUEST['submit'])){

        $firstName=$_REQUEST['firstname'];
        $lastName=$_REQUEST['lastname'];
        $specialization=$_REQUEST['specialization'];
        $country=$_REQUEST['country'];
        $email=$_REQUEST['email'];
        $contact=$_REQUEST['contact'];
        $gender=$_REQUEST['gender'];
        //////////////////////////////////////////
        $locprovince=$_REQUEST['locprovince'];
        $loccity=$_REQUEST['loccity'];
        $locblock=$_REQUEST['locblock'];

        $location=$locblock.",".$loccity.",".$locprovince;


        $counter=mysqli_num_rows($con->query("select * from outsidedoctor where email='$email'"));


        $chckFN=true;
        $chckLN=true;
        $chckSP=true;
        $chckG=true;
        $chckL=true;
        $chckN=true;
        $chckDigits=true;

        //////////////////////////////////////////
        $chckLP=true;
        $chckLC=true;
        $chckLB=true;
        $chckE=true;

        if (!preg_match("/^[a-zA-Z ]*$/",$firstName)){
            $msgFirstName=true;
            $chckFN=false;
        }if (!preg_match("/^[a-zA-Z ]*$/",$lastName)){
            $msgLastName=true;
            $chckLN=false;
        }if ($specialization=="Select"){
            $msgSelectSpe=true;
            $chckSP=false;
        }
        /////////////////////////////////////////////////
        if ($locprovince=="Select"){
            $msgLP=true;
            $chckLP=false;

        }if ($loccity=="Select"){
            $msgLC=true;
            $chckLC=false;

        }if ($locblock=="Select"){
            $msgLB=true;
            $chckLB=false;

        }if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$email)){
            $msgE=true;
            $chckE=false;

        }
        //////////////////////////////////////////////////////
        if ($gender=="Select"){
            $msgSelectG=true;
            $chckG=false;
        }if (!preg_match('/^[0-9]{14}+$/',$contact)){
            $msgSelectCon=true;
            $chckN=false;
            $chckDigits=false;
        }if ($chckDigits==true){

            $subDigit=substr($contact,0,4);
            $other=substr($contact,4,7);

            if ($subDigit=="0092"){
                $msgSelectCon=false;
                $chckN=true;
            }else{
                $msgSelectCon=true;
                $chckN=false;

            }

        } if (($chckFN==true) && ($chckLN==true) && ($chckSP==true) && ($chckN==true)  && ($chckG==true) && ($chckLP==true) && ($chckLC==true) && ($chckLB==true) && ($chckE==true)) {


            if ($counter>0) {
                $doctorAva = true;

            }else {
                mysqli_query($con, "insert into outsidedoctor value ('','$firstName','$lastName','$specialization','$country','$location','$contact','$email','$gender')");
                header("location:send-email-doctor.php?email=$email");
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
    <title>Register Outside Doctor - Super Admin</title>

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
            <a href="index.php" class="logo">
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
                    <span class="user-img"><img class="avatar-img rounded-circle" src="../assets/img/profiles/super.jpg" width="31" alt="<?=$superAdmin['user_name']?>"></span>
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
                            <li><a class="active" href="register-outside-doctor.php">Register Outside Doctor</a></li>
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
            <!--Doctor Registration Area-->
            <div class="mohaForms">

                <form action="register-outside-doctor.php" method="post">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Doctor Registration <small class="btn btn-sm bg-success-light float-right <?php if (!isset($_REQUEST['success'])){ echo 'd-none';}?>">Registered Successfully, Email Sent</small><small class="btn btn-sm bg-success-light float-right <?php if (!isset($_REQUEST['notsuccess'])){ echo 'd-none';}?>">Registered Successfully, Email Not Sent</small><small class="btn btn-sm bg-danger-light float-right <?php if ($doctorAva==false){ echo 'd-none';}?>">This Doctor is Avaliable!</small></h4>
                            <div class="row form-row">
                                <div class="col-md-12">
                                    <div class="form-group">

                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" name="firstname" maxlength="40" id="doc_firstName" value="<?php if (isset($_REQUEST['firstname'])){echo $_REQUEST['firstname'];} ?>" minlength="5" required>
                                        <div class="d-flex justify-content-between mt-1 ml-2"><small class="text-muted"><span>40</span> characters only</small></div>
                                        <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgFirstName==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" name="lastname" value="<?php if (isset($_REQUEST['lastname'])){echo $_REQUEST['lastname'];} ?>" minlength="4" maxlength="40" required>
                                        <div class="d-flex justify-content-between mt-1 ml-2"><small class="text-muted"><span>40</span> characters only</small></div>

                                        <small class="ml-2 text-muted bg-danger-light <?php if ($msgLastName==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Specialization <span class="text-danger">*</span></label>

                                        <select class="form-control select" name="specialization">
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='Select'){echo 'selected';}} ?>>Select</option>
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='Dentist'){echo 'selected';}} ?>>Dentist</option>
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='Eye'){echo 'selected';}} ?>>Eye</option>
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='Primary Care'){echo 'selected';}} ?>>Primary Care</option>
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='ENT'){echo 'selected';}} ?>>ENT</option>
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='Skin'){echo 'selected';}} ?>>Skin</option>
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='Dermatologist'){echo 'selected';}} ?>>Dermatologist</option>
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='Urology'){echo 'selected';}} ?>>Urology</option>
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='Neurology'){echo 'selected';}} ?>>Neurology</option>
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='Orthopedic'){echo 'selected';}} ?>>Orthopedic</option>
                                            <option <?php if (isset($_REQUEST['specialization'])){  if ($_REQUEST['specialization']=='Cardiologist'){echo 'selected';}} ?>>Cardiologist</option>
                                        </select>
                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgSelectSpe==false){echo 'd-none';} ?>">Select a specialization</small>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country <span class="text-danger">*</span></label>

                                        <select class="form-control select" name="country">
                                            <option>Pakistan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Location <span class="text-danger">*</span></label>
                                        <select class="form-control select" name="locprovince" id="locprovince">
                                            <option <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Select'){echo 'selected';}} ?>>Select</option>
                                            <option value="Peshawar" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Peshawar'){echo 'selected';}} ?>>Peshawar</option>

                                        </select>
                                        <small class="text-muted ml-2">State</small>
                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgLP==false){echo 'd-none';} ?>">select one</small>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-top: 30px">
                                        <select class="form-control select" name="loccity" id="loccity">
                                            <option <?php if (isset($_REQUEST['loccity'])){  if ($_REQUEST['loccity']=='Select'){echo 'selected';}} ?>>Select</option>
                                            <?php
                                            if (isset($_REQUEST['loccity'])){
                                                ?>
                                                <option <?php if (isset($_REQUEST['loccity'])){  echo 'selected';} ?>><?=$_REQUEST['loccity']?></option>

                                                <?php
                                            }
                                            ?>

                                        </select>
                                        <small class="text-muted ml-2">City</small>
                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgLC==false){echo 'd-none';} ?>">Select a city</small>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-top: 30px">
                                        <select class="form-control select" name="locblock" id="locblock">
                                            <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='Select'){echo 'selected';}} ?>>Select</option>
                                            <?php
                                            if (isset($_REQUEST['locblock'])){
                                                ?>
                                                <option <?php if (isset($_REQUEST['locblock'])){  echo 'selected';} ?>><?=$_REQUEST['locblock']?></option>

                                                <?php
                                            }
                                            ?>

                                        </select>
                                        <small class="text-muted ml-2">Block No</small>
                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgLB==false){echo 'd-none';} ?>">Select a block</small>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" value="<?php
                                        if (isset($_REQUEST['email'])){echo $_REQUEST['email'];}
                                        ?>" required>
                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgE==false){echo 'd-none';} ?>">enter a valid email</small>


                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Number <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" name="contact" value="<?php if (isset($_REQUEST['contact'])){echo $_REQUEST['contact'];} ?>" required>
                                        <div class="d-flex justify-content-between mt-1 ml-2"><small class="text-muted"><span>Type: 0092 then 10 digits number</span> </small></div>

                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgSelectCon==false){echo 'd-none';} ?>">Enter Valid Phone Number</small>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gender <span class="text-danger">*</span></label>
                                        <select class="form-control select" name="gender">
                                            <option <?php if (isset($_REQUEST['gender'])){if ($_REQUEST['gender']=="Select"){echo "selected";}} ?> >Select</option>
                                            <option <?php if (isset($_REQUEST['gender'])){if ($_REQUEST['gender']=="Male"){echo "selected";}} ?>>Male</option>
                                            <option <?php if (isset($_REQUEST['gender'])){if ($_REQUEST['gender']=="Female"){echo "selected";}} ?>>Female</option>
                                        </select>
                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgSelectG==false){echo 'd-none';} ?>">Select a gender</small>

                                    </div>
                                </div>



                                <div class="submit-section" style="position: relative; margin-left: 400px; margin-right: 400px;">

                                    <button type="submit" class="btn bg-success-light submit-btn" name="submit">Register Doctor</button>

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


<script type="text/javascript">
    $(document).ready(function () {
        $("#locprovince").change(function () {
            var val = $(this).val();
            if (val == "Peshawar") {
                $('#loccity').html("<option value='Hayatabad' <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Hayatabad') {
                        echo 'selected';
                    }
                } ?>>Hayatabad</option>                                        <option value='Dabgar e garden' <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Dabgar e garden') {
                        echo 'selected';
                    }
                } ?>>Dabgar e garden</option>                                        <option value='Ring Road' <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Ring Road') {
                        echo 'selected';
                    }
                } ?>>Ring Road</option>                                        <option value='Abdara Road' <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Abdara Road') {
                        echo 'selected';
                    }
                } ?>>Abdara Road</option>  ");


            }


        });
        $("#loccity").change(function () {
            var val = $(this).val();
            if (val == "Hayatabad") {
                $('#locblock').html("<option  <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 1') {
                        echo 'selected';
                    }
                } ?>>Phase 1</option>                                        <option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 2') {
                        echo 'selected';
                    }
                } ?>>Phase 2</option>                                        <option  <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 3') {
                        echo 'selected';
                    }
                } ?>>Phase 3</option> <option <?php if (isset($_REQUEST['locblock'])) {if ($_REQUEST['locblock'] == 'Phase 4') {
                        echo 'selected';}} ?>>Phase 4</option> <option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 4') {
                                         echo 'selected';}
                } ?>>Phase 4</option><option <?php if (isset($_REQUEST['locblock'])) {
                                    if ($_REQUEST['locblock'] == 'Phase 5') {
                                                       echo 'selected';}               } ?>>Phase 5</option><option <?php if (isset($_REQUEST['locblock'])) {
                                                 if ($_REQUEST['locblock'] == 'Phase 6') {
                                                                             echo 'selected';}               } ?>>Phase 6</option>  ");


            }if (val == "Dabgar e garden") {
                $('#locblock').html("<option  <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase') {
                        echo 'selected';
                    }
                } ?>>Phase</option>                                        <option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 2') {
                        echo 'selected';
                    }
                } ?>>Phase 2</option>                                        <option  <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 3') {
                        echo 'selected';
                    }
                } ?>>Phase 3</option> <option <?php if (isset($_REQUEST['locblock'])) {if ($_REQUEST['locblock'] == 'Phase 4') {
                    echo 'selected';}} ?>>Phase 4</option> <option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 4') {
                        echo 'selected';}
                } ?>>Phase 4</option><option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 5') {
                        echo 'selected';}               } ?>>Phase 5</option><option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 6') {
                        echo 'selected';}               } ?>>Phase 6</option>  ");


            }if (val == "Ring Road") {
                $('#locblock').html("<option  <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase') {
                        echo 'selected';
                    }
                } ?>>Phase</option>                                        <option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 2') {
                        echo 'selected';
                    }
                } ?>>Phase 2</option>                                        <option  <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 3') {
                        echo 'selected';
                    }
                } ?>>Phase 3</option> <option <?php if (isset($_REQUEST['locblock'])) {if ($_REQUEST['locblock'] == 'Phase 4') {
                    echo 'selected';}} ?>>Phase 4</option> <option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 4') {
                        echo 'selected';}
                } ?>>Phase 4</option><option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 5') {
                        echo 'selected';}               } ?>>Phase 5</option><option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 6') {
                        echo 'selected';}               } ?>>Phase 6</option>  ");


            }if (val == "Abdara Road") {
                $('#locblock').html("<option  <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase') {
                        echo 'selected';
                    }
                } ?>>Phase</option>                                        <option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 2') {
                        echo 'selected';
                    }
                } ?>>Phase 2</option>                                        <option  <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 3') {
                        echo 'selected';
                    }
                } ?>>Phase 3</option> <option <?php if (isset($_REQUEST['locblock'])) {if ($_REQUEST['locblock'] == 'Phase 4') {
                    echo 'selected';}} ?>>Phase 4</option> <option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 4') {
                        echo 'selected';}
                } ?>>Phase 4</option><option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 5') {
                        echo 'selected';}               } ?>>Phase 5</option><option <?php if (isset($_REQUEST['locblock'])) {
                    if ($_REQUEST['locblock'] == 'Phase 6') {
                        echo 'selected';}               } ?>>Phase 6</option>  ");


            }


        });

    });
</script>
</body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->
</html>
