<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 14-Aug-20
 * Time: 6:28 PM
 */
require_once ("database-connection.php");
session_start();

$userAvaliability=false;
$doctorAvaliability=false;
$signupSuccess=false;
$signupNotSuccess=false;
$registerLink=false;
$loginLink=true;

$loginUserNotAvaliable=false;
$doctorNotAprroved=false;


/////////////////////////////////////////
$invalidEmail=false;
$invalidPassword=false;
/*    Login Request          */
if (isset($_REQUEST['login'])){
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];

    $getLoginDetails="select doc_id,user_username,user_password,user_type,user_status from users where user_username='$username'";

    $checkAvaliable=mysqli_num_rows($con->query($getLoginDetails));
    $getLogin=$con->query($getLoginDetails)->fetch_array();

    if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$username)){
        $invalidEmail=true;
        $loginUserNotAvaliable=true;
    }if (strlen($password)<8){
        $invalidPassword=true;
        $loginUserNotAvaliable=true;
    }
    elseif ($checkAvaliable==0){
        $loginUserNotAvaliable=true;

    }
    elseif (($getLogin['user_username']==$username) && (password_verify($password,$getLogin['user_password'])) ){
        if ($getLogin['user_type']=='patient') {
            if ($getLogin['user_status']=='unapproved'){
                $doctorNotAprroved=true;
            }else{
                setcookie("username",$username);
                header("location:patient-dashboard.php");
                return;
            }
        }elseif ($getLogin['user_type']=='doctor'){

            if ($getLogin['user_status']=='unapproved'){
                $doctorNotAprroved=true;
            }else{
                setcookie("username",$username);
                header("location:doctor-dashboard.php");
                return;
            }

        }elseif ($getLogin['user_type']=='outside doctor'){

            if ($getLogin['user_status']=='unapproved'){
                $doctorNotAprroved=true;
            }elseif ($getLogin['user_status']=='send'){
                $doctorSend=true;
            }else{
                setcookie("username",$username);
                header("location:outside-doctor-dashboard.php");
                return;
            }

        }
        elseif ($getLogin['user_type']=='moha'){
            setcookie("username",$username);
            header("location:moha-dashboard.php");
            return;
        } elseif ($getLogin['user_type']=='super admin'){

            setcookie("username",$username);
            header("location:./super admin/index.php");
            return;
        }

    }

    else{
        $loginUserNotAvaliable=true;
    }


}

//Search Working
$hospitalDetails=$con->query("select * from clinics");
$msgN=false;
$nameShow=false;
$provinceshow=false;
$typeprovince=false;
$typeshow=false;

$nametype=false;
$nameprovince=false;
$nametypeprovince=false;





if (isset($_REQUEST['search'])){
    $name=$_REQUEST['name'];
    $type=$_REQUEST['type'];
    $location=$_REQUEST['province'];

    if (($name==null) && ($type=="Select") && ($location=="Select")){
        header("location:search-clinics.php");
        return;
    }elseif (!preg_match("/^[a-zA-Z ]*$/",$name)){
        $msgN=true;
    }elseif (($name!=null) && ($location=="Select") && ($type=="Select")){
        $hospitalDetails=$con->query("select * from clinics where clinic_name like '%$name%'");
        $nameShow=true;
    }elseif (($location!="Select") && ($name==null) && ($type=="Select")){
        $hospitalDetails=$con->query("select * from clinics where clinic_location like '%$location%'");
        $provinceshow=true;

    }elseif (($type!="Select") && ($name==null) && ($location=="Select")){
        $hospitalDetails=$con->query("select * from clinics where clinic_type='$type'");
        $typeshow=true;

    }elseif (($location!="Select") && ($type!="Select") && ($name==null)){
        $hospitalDetails=$con->query("select * from clinics where clinic_type='$type' and clinic_location like '%$location%'");
        $typeprovince=true;

    }elseif (($location=="Select") && ($type!="Select") && ($name!=null)){
        $hospitalDetails=$con->query("select * from clinics where clinic_name like '%$name%' and clinic_type='$type'");
        $nametype=true;

    }elseif (($location!="Select") && ($type=="Select") && ($name!=null)){
        $hospitalDetails=$con->query("select * from clinics where clinic_name like '%$name%' and Clinic_location like '%$location%'");
        $nameprovince=true;

    }elseif (($location!="Select") && ($type!="Select") && ($name!=null)){
        $hospitalDetails=$con->query("select * from clinics where clinic_name like '%$name%' and Clinic_location like '%$location%' and clinic_type='$type'");
        $nametypeprovince=true;

    }

}

$loginShow=true;
$short=false;
$dirImage=null;
$dashboard=null;
$profile=null;
$logout=null;
$type=null;


if (isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
    $loginShow=false;
    $short=true;

    $username=$_SESSION['username'];

    $userDetails=$con->query("select * from users where user_username='$username'")->fetch_array();
    $type=$userDetails['user_type'];
    $userID=$userDetails['user_id'];
    $userImage=$con->query("select file_name from pictures where user_id='$userID'")->fetch_array()['file_name'];




    if ($type=='patient'){
        $dirImage="patients";
        $dashboard="patient-dashboard.php";
        $profile="patient-profile-setting.php";
        $logout="logout.php?patient";
        $type="Patient";


    }elseif ($type=='doctor'){
        $dirImage="doctors";
        $dashboard="doctor-dashboard.php";
        $profile="doctor-profile-setting.php";
        $logout="logout.php?doctor";
        $type="Doctor";
    }elseif ($type=='outside doctor'){
        $dirImage="doctors";
        $dashboard="outside-doctor-dashboard.php";
        $profile="outside-doctor-profile-setting.php";
        $logout="logout.php?doctor";
        $type="Outside Doctor";
    }
    elseif ($type=='moha'){
        $dirImage="moha";
        $dashboard="moha-dashboard.php";
        $profile="moha-profile-setting.php";
        $logout="logout.php?doctor";
        $type="MOHA";
    }


}


?>





<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Clinics - Health Guide</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="assets/img/favicon.png" rel="icon">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">


</head>
<body>
<!--Main Wrapper-->
<div class="main-wrapper" style="background-color: white">

    <!--Header Part-->
    <header class="header">
        <nav class="navbar navbar-expand-lg header-nav">
            <!---Logo-->
            <div class="navbar-header">
                <a href="index.php" class="navbar-brand logo"><img src="assets/img/logo1.png"   class="img-fluid" alt="Logo"></a>
            </div>
            <!--Contact & Login/Sign Up-->
            <ul class="nav header-navbar-rht <?php if ($loginShow==false){echo 'd-none'; } ?>">

                <!---Login/ Sign Up-->
                <li class="nav-item">
                    <a href="#" data-toggle="modal" data-target="#LoginSignupModal" class="nav-link header-login">Login / Signup </a>
                </li>
            </ul>
            <ul class="nav header-navbar-rht <?php if ($short==false){echo 'd-none'; } ?>">
                <!-- User Menu -->
                <li class="nav-item dropdown has-arrow logged-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
									<img class="rounded-circle" src="assets/img/<?=$dirImage?>/<?=$userImage?>" width="31" alt="<?=$userDetails['user_name']?>">
								</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="assets/img/<?=$dirImage?>/<?=$userImage?>" alt="User Image" class="avatar-img rounded-circle">
                            </div>
                            <div class="user-text">
                                <h6><?php echo $userDetails['user_name'] ?></h6>
                                <p class="text-muted mb-0"><?=$type?></p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="<?=$dashboard?>">Dashboard</a>
                        <a class="dropdown-item" href="<?=$profile?>" >Profile Settings</a>
                        <a class="dropdown-item" href="<?=$logout?>">Logout</a>
                    </div>
                </li>
                <!-- /User Menu -->

            </ul>

        </nav>


    </header>
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar" style="display: <?php if (!isset($_REQUEST['search'])){ echo "none"; }  ?> ">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8 col-12">
                    <?php
                    if ($nameShow==true){
                        echo "<h3 style='color: white'> Searching: ".$name." clinic </h3>";
                    }elseif ($provinceshow==true){
                        echo "<h3 style='color: white'> Searching: Clinics in ".$location." </h3>";
                    }elseif ($typeshow==true){
                        echo "<h3 style='color: white'> Searching:".$type." Clinics </h3>";
                    }elseif ($typeprovince==true){
                        echo "<h3 style='color: white'> Searching: ".$type." clinic in ".$location." </h3>";

                    }elseif ($nametype==true){
                        echo "<h3 style='color: white'> Searching: ".$name." clinic of ".$type." </h3>";

                    }elseif ($nameprovince==true){
                        echo "<h3 style='color: white'> Searching: ".$name." clinic in ".$location." </h3>";

                    }elseif ($nametypeprovince==true){
                        echo "<h3 style='color: white'> Searching: ".$name." clinic of ".$type." in ".$location."</h3>";

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">

                    <!-- Search Filter -->
                    <form action="search-clinics.php" method="get">
                        <div class="card search-filter">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Search Filter</h4>
                            </div>
                            <div class="card-body">
                                <div class="filter-widget">
                                    <h4>Clinic Name</h4>
                                    <input type="text" name="name" value="<?php if ($msgN==true){echo $_REQUEST['name'];} ?>" class="form-control <?php if (isset($_REQUEST['search'])){if ($msgN==true){echo "bg-danger-light";}} ?>" minlength="5" maxlength="50" >
                                    <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>


                                </div>
                                <div class="filter-widget">
                                    <h4>Type</h4>
                                    <select class="select" name="type">
                                        <option>Select</option>
                                        <option>Eye</option>
                                        <option>Dentist</option>
                                        <option>ENT</option>
                                        <option>Dermatologist</option>
                                        <option>Urology</option>
                                        <option>Neurology</option>
                                        <option>Primary Care</option>
                                        <option>Orthopedic</option>
                                        <option>Cardiologist</option>
                                        <option>Skin</option>
                                    </select>
                                </div>

                                <div class="filter-widget">
                                    <h4>Province</h4>
                                    <select class="select" name="province">
                                        <option>Select</option>
                                        <option>Kabul</option>
                                        <option>Nangarhar</option>
                                        <option>Kandahar</option>
                                        <option>Logar</option>
                                        <option>Paktia</option>
                                        <option>Paktika</option>
                                        <option>Ghazni</option>
                                        <option>Mazar e shreef</option>
                                        <option>Herat</option>
                                        <option>Khoast</option>
                                        <option>Laghman</option>
                                    </select>
                                </div>
                                <div class="btn-search">
                                    <button type="submit" name="search" class="btn btn-block bg-success">Search</button>
                                </div>
                            </div>
                        </div>
                        <!-- /Search Filter -->
                    </form>


                </div>





                    <div class="col-md-12 col-lg-4 col-xl-9">
                        <?php

                        while ($row=$hospitalDetails->fetch_array()) {


                        ?>
                            <!-- Doctor Widget -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="doctor-widget">
                                        <div class="doc-info-left">
                                            <div class="doctor-img">
                                                <a>
                                                    <img src="assets/img/services/cli.png" class="img-fluid"
                                                         alt="Doctor Image">
                                                </a>
                                            </div>
                                            <div class="doc-info-cont">
                                                <h4 class="doc-name bg-s"><a> <?php echo $row['clinic_name']  ?> Clinic</a></h4>
                                                <p class="text-muted"> <?php echo $row['clinic_type']  ?>
                                                    </p><br>

                                            </div>
                                        </div>
                                        <div class="doc-info-right">
                                            <div class="clini-infos">
                                                <ul>
                                                    <li><i class="fas fa-check"></i> <?php  echo $row['clinic_status']; ?> by MOHA</li>

                                                    <li title="Location"><i class="fas fa-map-marker-alt"
                                                                            data-toggle="tooltip" title="Location"></i>
                                                        <?php
                                                        echo $row['clinic_location'];
                                                        ?>
                                                    </li>
                                                    <li><i class="fas fa-phone-alt"></i> <?php  echo $row['contact']; ?></li>


                                                </ul>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /Doctor Widget -->
                            <?php
                        }
                        ?>


                    </div>






            </div>
        </div>
    </div>



    <!-- Footer -->
    <footer class="footer">

        <!-- Footer Top -->
        <div class="footer-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-6">

                        <!-- Footer Widget -->
                        <div class="footer-widget footer-about mt-5">

                            <div class="footer-about-content">
                                <p>Book appointments with approved doctors and Specialists such as Gynecologists, Skin Specialists, Child Specialists,etc in Afghanistan conveniently.  </p>
                                <span class="aa">Find approved doctors, hospitals, clinics, medical stores and medicine industries in Afghanistan.<a href="#section-service">  Read more...</a></span>
                            </div>
                        </div>
                        <!-- /Footer Widget -->

                    </div>

                    <div class="col-lg-2 col-md-6">

                        <!-- Footer Widget -->
                        <div class="footer-widget footer-menu">
                            <h2 class="footer-title">For Patients</h2>
                            <ul>
                                <li><a href="search.php"><i class="fas fa-angle-double-right"></i> Search for Doctors</a></li>
                                <li><a href="index.php?haveaccount"><i class="fas fa-angle-double-right"></i> Login</a></li>
                                <li><a href="index.php?registerLink"><i class="fas fa-angle-double-right"></i> Register</a></li>
                                <li><a href="search.php"><i class="fas fa-angle-double-right"></i> Booking Appointment</a></li>
                                <li><a href="patient-dashboard.php"><i class="fas fa-angle-double-right"></i> Patient Dashboard</a></li>
                            </ul>
                        </div>
                        <!-- /Footer Widget -->

                    </div>

                    <div class="col-lg-2 col-md-6">

                        <!-- Footer Widget -->
                        <div class="footer-widget footer-menu">
                            <h2 class="footer-title">For Doctors</h2>
                            <ul>
                                <li><a href="doctor-dashboard.php"><i class="fas fa-angle-double-right"></i>Check Appointments</a></li>

                                <li><a href="index.php?haveaccount"><i class="fas fa-angle-double-right"></i> Login</a></li>
                                <li><a href="index.php?doctorLink" ><i class="fas fa-angle-double-right"></i> Register</a></li>
                                <li><a href="doctor-dashboard.php"><i class="fas fa-angle-double-right"></i> Doctor Dashboard</a></li>
                            </ul>
                        </div>
                        <!-- /Footer Widget -->

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <!-- Footer Widget -->
                        <div class="footer-widget footer-contact">
                            <h2 class="footer-title">Contact Us</h2>
                            <div class="footer-contact-info">

                                <p style="color: rgba(255,255,255,.5);">
                                    <i class="fas fa-phone-alt"></i>
                                    0093-766 242362
                                </p>
                                <p class="mb-0" style="color: rgba(255,255,255,.5);">
                                    <i class="fas fa-envelope"></i>
                                    saidmuqeemhashimi@gmail.com

                                </p>
                            </div>
                        </div>
                        <!-- /Footer Widget -->

                    </div>

                </div>
            </div>
        </div>
        <!-- /Footer Top -->

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container-fluid">

                <!-- Copyright -->
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="copyright-text">
                                <p class="mb-0">Copyright @ 2020 - All Rights Reserved</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="social-icon">

                                <ul>
                                    <li>
                                        <p>Connect with us </p>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank"><i class="fab fa-facebook-f"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank"><i class="fab fa-twitter"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank"><i class="fab fa-dribbble"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">

                            <!-- Copyright Menu -->
                            <div class="copyright-menu">

                            </div>
                            <!-- /Copyright Menu -->

                        </div>
                    </div>
                </div>
                <!-- /Copyright -->

            </div>
        </div>
        <!-- /Footer Bottom -->

    </footer>
    <!-- /Footer -->



</div>



<!---Login/Sign Up Modal-->
<div class="modal fade"  id="LoginSignupModal">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content loginModal">
            <div class="login-close">
                <button type="button" class="close"  data-dismiss="modal" onclick="loginBody();"><span>&times;</span></button>
            </div>



            <div class="modal-body" id="Login-Body">
                <!--Login Content -->
                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">

                                <!-- Login Tab Content -->
                                <div class="account-content">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="col-md-7 col-lg-6 login-left">
                                            <img src="assets/img/login-banner.png" class="img-fluid" alt="Login">
                                        </div>
                                        <div class="col-md-12 col-lg-6 login-right">
                                            <div class="login-header">
                                                <h3>Login</h3>
                                            </div>
                                            <form action="search-hospitals.php" method="post">

                                                <div class="form-group form-focus">

                                                    <input type="text" name="username" value="<?php if (isset($_REQUEST['login'])){echo $_REQUEST['username']; } ?>" class="form-control floating <?php if ($invalidEmail==true){echo "bg-danger-light";} ?>" required>
                                                    <label class="focus-label">Email</label>
                                                    <small class="bg-danger-light ml-1 <?php if ($invalidEmail==false){echo "d-none";} ?>">Type a valid email</small>

                                                </div>
                                                <div class="form-group form-focus">
                                                    <input type="password" name="password" value="<?php if (isset($_REQUEST['login'])){echo $_REQUEST['password']; } ?>" class="form-control floating <?php if ($invalidPassword==true){echo "bg-danger-light"; } ?>" required>
                                                    <label class="focus-label">Password</label>
                                                    <small class="bg-danger-light ml-1 <?php if ($invalidPassword==false){echo "d-none";} ?>">Type a valid password</small>



                                                </div>
                                                <div style="margin-left: 35px;display: <?php if ($loginUserNotAvaliable==false){ echo 'none'; }   ?>;"><h5 style="color:red;" >invalid username and password</h5></div>

                                                <div style="margin-left: 60px; display: <?php if ($signupSuccess==false){echo 'none';}  ?>">
                                                    <span style="color: darkgreen" class="forgot-link"> <i class="fas fa-check" style="margin-right: 3px"></i> Registered Successfully </span>
                                                    <br>
                                                    <span style="color: darkgreen" class="forgot-link">Enter username and password</span>
                                                </div>
                                                <div style="margin-left: 60px; display: <?php if ($doctorNotAprroved==false){echo 'none';}  ?>">
                                                    <span style="color: darkred" class="forgot-link"> <i class="fas fa-door-closed" style="margin-right: 3px"></i> You are not approved yet! </span>

                                                </div>
                                                <div class="text-right">
                                                    <a class="forgot-link" href="index.php?forgotpassword">Forgot Password ?</a>
                                                </div>
                                                <button class="btn btn-primary btn-block btn-lg login-btn" name="login" type="submit">Login</button>
                                                <div class="login-or">
                                                    <span class="or-line"></span>
                                                    <span class="span-or">or</span>
                                                </div>

                                                <div class="text-center dont-have">Don’t have an account? <a href="patient-signup.php">Register</a></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                </div>


            </div>
            <!--/Modal Body-->
        </div>
    </div>
</div>


<!--Forgot Password Modal Body-->
<div class="modal fade"  id="forgotPasswordModal">
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
                                                <h3>Forgot Password?</h3>
                                                <p class="small text-muted">Enter your email to get a password reset link</p>
                                            </div>

                                            <!-- Forgot Password Form -->
                                            <form action="search-hospitals.php" method="post">
                                                <div class="form-group form-focus">
                                                    <input type="email" class="form-control floating" name="username" required>
                                                    <label class="focus-label">Email</label>
                                                </div>
                                                <a href="index.php?registerLink" class="<?php if ($chckUsername==false){echo 'd-none'; } ?>"><small class="btn btn-sm bg-danger-light mb-2"><strong>Email doesn't exist's !,</strong><simple> Click here to register</simple></small></a>
                                                <?php
                                                if ($sendEmail==true){

                                                    ?>
                                                    <small class="btn btn-sm bg-success-light mb-2">Email Send, Check your email..</small>

                                                    <?php
                                                }if ($sendnotEmail==true){
                                                    ?>
                                                    <small class="btn btn-sm bg-danger-light mb-2">Email not send, please retry again !</small>
                                                    <?php
                                                }
                                                ?>
                                                <button class="btn btn-primary btn-block btn-lg login-btn" name="reset" type="submit">Reset Password</button>
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

            <!---Forgot Password Modal Body-->
        </div>

    </div>

</div>



<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Slick JS -->
<script src="assets/js/slick.js"></script>
<!-- Sticky Sidebar JS -->

<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

<!-- Select2 JS -->
<script src="assets/plugins/select2/js/select2.min.js"></script>

<!-- Datetimepicker JS -->
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

<!-- Fancybox JS -->
<script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>

<?php
if ($signupSuccess==true) {
    echo "<script>
        $( '#LoginSignupModal' ).modal('show');
      </script> ";
}
elseif ($userAvaliability==true){
    echo "<script>
        $( '#patientRegisterModal' ).modal('show');
      </script> ";
}
elseif ($doctorNotAprroved==true){
    echo "<script>
        $( '#LoginSignupModal' ).modal('show');
      </script> ";
}
elseif ($doctorAvaliability==true){
    echo "<script>
        $( '#doctorRegisterModal' ).modal('show');
      </script> ";
}
elseif ($loginUserNotAvaliable==true){
    echo "<script>
        $( '#LoginSignupModal' ).modal('show');
      </script> ";
}
elseif (isset($_REQUEST['registerLink'])){

    echo "<script>
        $( '#patientRegisterModal' ).modal('show');
      </script> ";
}
elseif (isset($_REQUEST['forgotpassword'])){
    echo "<script>
        $( '#forgotPasswordModal' ).modal('show');
      </script> ";
}
elseif (isset($_REQUEST['haveaccount'])){
    echo "<script>
        $( '#LoginSignupModal').modal('show');
      </script> ";
}
elseif (isset($_REQUEST['doctorLink'])){
    echo "<script>
        $( '#doctorRegisterModal').modal('show');
      </script> ";
}

?>
</body>
</html>