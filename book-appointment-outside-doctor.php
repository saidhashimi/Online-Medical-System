<?php
require_once ("database-connection.php");
/*  Login and Sign Up                 */


session_start();
$userAvaliability=false;
$doctorAvaliability=false;
$signupSuccess=false;
$signupNotSuccess=false;
$registerLink=false;
$loginLink=true;

$loginUserNotAvaliable=false;


$doctorNotAprroved=false;

if (!isset($_REQUEST['doc_id'])){
    header("location:search.php");
    return;
}

/////////////////////////////////////////
$invalidEmail=false;
$invalidPassword=false;

/*    Login Request          */
if (isset($_REQUEST['login'])) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $getLoginDetails = "select doc_id,user_username,user_password,user_type,user_status from users where user_username='$username'";

    $checkAvaliable = mysqli_num_rows($con->query($getLoginDetails));
    $getLogin = $con->query($getLoginDetails)->fetch_array();

    if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$username)){
        $invalidEmail=true;
        $loginUserNotAvaliable=true;
    }if (strlen($password)<8){
        $invalidPassword=true;
        $loginUserNotAvaliable=true;
    }

    elseif ($checkAvaliable == 0) {
        $loginUserNotAvaliable = true;

    } elseif (($getLogin['user_username'] == $username) && (password_verify($password, $getLogin['user_password']))) {
        if ($getLogin['user_type'] == 'patient') {
            if ($getLogin['user_status'] == 'unapproved') {
                $doctorNotAprroved = true;
            } else {
                setcookie("username", $username);
                header("location:patient-dashboard.php");
                return;
            }
        } elseif ($getLogin['user_type'] == 'doctor') {

            if ($getLogin['user_status'] == 'unapproved') {
                $doctorNotAprroved = true;
            } else {
                setcookie("username", $username);
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
        elseif ($getLogin['user_type'] == 'moha') {
            setcookie("username", $username);
            header("location:moha-dashboard.php");
            return;
        } elseif ($getLogin['user_type'] == 'super admin') {

            setcookie("username", $username);
            header("location:./super admin/index.php");
            return;
        }

    } else {
        $loginUserNotAvaliable = true;
    }


}

?>

<?php
$username=null;
if (isset($_COOKIE['username'])) {
    $_SESSION['username']=$_COOKIE['username'];
    $username = $_SESSION['username'];
}


$doc_id=$_REQUEST['doc_id'];
$_SESSION['doc_id']=$doc_id;

$doc_id=$_SESSION['doc_id'];
$selectDetails=$con->query("select * from outsidedoctor where id='$doc_id'")->fetch_array();
$docusername=$selectDetails['email'];


$doc_user_id=$con->query("select user_id from users where user_username='$docusername'")->fetch_array()['user_id'];

$doctorDetails=$con->query("select * from outsidedoctor where id='$doc_id'")->fetch_array();
$doctorProfile=$con->query("select * from doctorprofile where user_id='$doc_user_id'")->fetch_array();
$doctorImage=$con->query("select file_name from pictures where  user_id='$doc_user_id'")->fetch_array()['file_name'];


date_default_timezone_set("Asia/Kabul");

$todayDay=date("D");
$satDate=null;
$sunDate=null;
$monDate=null;
$tueDate=null;
$wedDate=null;
$thuDate=null;
$friDate=null;


if ($todayDay=='Sat'){
    $satDate=date("d M Y");
    $sunDate=date("d M Y", strtotime("+1 day"));
    $monDate=date("d M Y", strtotime("+2 day"));
    $tueDate=date("d M Y", strtotime("+3 day"));
    $wedDate=date("d M Y", strtotime("+4 day"));
    $thuDate=date("d M Y", strtotime("+5 day"));
    $friDate=date("d M Y", strtotime("+6 day"));

}elseif ($todayDay=='Sun'){


    $sunDate=date("d M Y");
    $monDate=date("d M Y", strtotime("+1 day"));
    $tueDate=date("d M Y", strtotime("+2 day"));
    $wedDate=date("d M Y", strtotime("+3 day"));
    $thuDate=date("d M Y", strtotime("+4 day"));
    $satDate=date("d M Y", strtotime("+6 day"));
    $friDate=date("d M Y", strtotime("+5 day"));
}elseif ($todayDay=='Mon'){


    $monDate=date("d M Y");
    $tueDate=date("d M Y", strtotime("+1 day"));
    $wedDate=date("d M Y", strtotime("+2 day"));
    $thuDate=date("d M Y", strtotime("+3 day"));
    $friDate=date("d M Y", strtotime("+4 day"));
    $satDate=date("d M Y", strtotime("+5 day"));
    $sunDate=date("d M Y", strtotime("+6 day"));
}elseif ($todayDay=='Tue'){

    $tueDate=date("d M Y");
    $wedDate=date("d M Y", strtotime("+1 day"));
    $thuDate=date("d M Y", strtotime("+2 day"));
    $friDate=date("d M Y", strtotime("+3 day"));
    $satDate=date("d M Y", strtotime("+4 day"));
    $sunDate=date("d M Y", strtotime("+5 day"));
    $monDate=date("d M Y", strtotime("+6 day"));

}elseif ($todayDay=='Wed'){

    $wedDate=date("d M Y");
    $thuDate=date("d M Y", strtotime("+1 day"));
    $friDate=date("d M Y", strtotime("+2 day"));
    $satDate=date("d M Y", strtotime("+3 day"));
    $sunDate=date("d M Y", strtotime("+4 day"));
    $monDate=date("d M Y", strtotime("+5 day"));
    $tueDate=date("d M Y", strtotime("+6 day"));
}elseif ($todayDay=='Thu'){

    $thuDate=date("d M Y");
    $friDate=date("d M Y", strtotime("+1 day"));
    $satDate=date("d M Y", strtotime("+2 day"));
    $sunDate=date("d M Y", strtotime("+3 day"));
    $monDate=date("d M Y", strtotime("+4 day"));
    $tueDate=date("d M Y", strtotime("+5 day"));
    $wedDate=date("d M Y", strtotime("+6 day"));
}elseif($todayDay=="Fri"){
    $friDate=date("d M Y");
    $satDate=date("d M Y", strtotime("+1 day"));
    $sunDate=date("d M Y", strtotime("+2 day"));
    $monDate=date("d M Y", strtotime("+3 day"));
    $tueDate=date("d M Y", strtotime("+4 day"));
    $wedDate=date("d M Y", strtotime("+5 day"));
    $thuDate=date("d M Y", strtotime("+6 day"));
}


$doctorSatSlots=$con->query("select * from doctorslots where saturday='yes' and user_id='$doc_user_id'");
$doctorSunSlots=$con->query("select * from doctorslots where sunday='yes' and user_id='$doc_user_id'");
$doctorMonSlots=$con->query("select * from doctorslots where monday='yes' and user_id='$doc_user_id'");
$doctorTueSlots=$con->query("select * from doctorslots where tuesday='yes' and user_id='$doc_user_id'");
$doctorWedSlots=$con->query("select * from doctorslots where wednesday='yes' and user_id='$doc_user_id'");
$doctorThuSlots=$con->query("select * from doctorslots where thursday='yes' and user_id='$doc_user_id'");

$doctorFriSlots=$con->query("select * from doctorslots where friday='yes' and user_id='$doc_user_id'");

$loginShow=true;
$short=false;
$dirImage=null;
$dashboard=null;
$profile=null;
$logout=null;
$type=null;

if (isset($_SESSION['username'])){
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
    <meta charset="utf-8">
    <title>Book Appointment - Health Guide</title>

    <link href="assets/img/favicon.png" rel="icon">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">



</head>

<body>
<!-------------------------------------->
<!--         Main Wrapper             -->
<!-------------------------------------->
<!-- Main Wrapper -->
<div class="main-wrapper">
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
    <!--/Header-->

    <!-- Title Page -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">

                    </nav>
                    <h2 class="breadcrumb-title">Appointment Booking</h2>
                </div>

            </div>
        </div>
    </div>
    <!-- /Title Page -->

    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="booking-doc-info">
                                <a  class="booking-doc-img">
                                    <img src="assets/img/doctors/<?=$doctorImage?>" alt="User Image">
                                </a>
                                <div class="booking-info">
                                    <h4><a">Dr. <?php
                                            echo $doctorDetails['firstname'].' '.$doctorDetails['lastname'];
                                            ?></a></h4>
                                    <p class="text-muted mb-0"><i class="fas fa-check" style="margin-right: 10px"></i>Approved by Super Admin</p>
                                    <br>
                                    <p class="text-muted mb-0"><i class="fas fa-map-marker-alt" style="margin-right: 10px"></i> <?php echo $doctorDetails['location']; ?>, Pakistan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <small class="btn btn-sm bg-danger-light mb-2 <?php if (!isset($_REQUEST['false'])){echo "d-none";} ?>">You are not allowed to make an appointment</small>
                    <small class="btn btn-sm bg-info-light mb-2 <?php if (!isset($_REQUEST['booked'])){echo "d-none";} ?>">Sorry, this slot is already booked, book another one</small>

                    <!-- Schedule Widget -->
                    <div class="card booking-schedule schedule-widget">

                        <!-- Schedule Header -->
                        <div class="schedule-header">
                            <div class="row">
                                <div class="col-md-12">

                                    <!-- Day Slot -->
                                    <div class="day-slot">
                                        <ul>

                                            <li>
                                                <span>Sat</span>
                                                <span class="slot-date"><?=$satDate?></span>
                                            </li>
                                            <li>
                                                <span>Sun</span>
                                                <span class="slot-date"><?=$sunDate?></span>
                                            </li>
                                            <li>
                                                <span>Mon</span>
                                                <span class="slot-date"><?=$monDate?></span>
                                            </li>
                                            <li>
                                                <span>Tue</span>
                                                <span class="slot-date"><?=$tueDate?></span>
                                            </li>
                                            <li>
                                                <span>Wed</span>
                                                <span class="slot-date"><?=$wedDate?></span>
                                            </li>
                                            <li>
                                                <span>Thu</span>
                                                <span class="slot-date"><?=$thuDate?></span>
                                            </li>
                                            <li>
                                                <span>Fri</span>
                                                <span class="slot-date"><?=$friDate?></span>

                                            </li>

                                        </ul>
                                    </div>
                                    <!-- /Day Slot -->

                                </div>
                            </div>
                        </div>
                        <!-- /Schedule Header -->

                        <!-- Schedule Content -->
                        <div class="schedule-cont">
                            <div class="row">
                                <div class="col-md-12">

                                    <!-- Time Slot -->
                                    <div class="time-slot">
                                        <ul class="clearfix">
                                            <li>
                                                <span class="time <?php if (mysqli_num_rows($doctorSatSlots)>0){echo "d-none";} ?>"><span class="badge bg-danger-light">Closed</span></span>

                                                <?php
                                                while($row=$doctorSatSlots->fetch_array()) {
                                                    ?>
                                                    <a class="timing" href="visitor-outside-doctor.php?startTime=<?=$row['start_time']?>&endTime=<?=$row['end_time']?>&date=<?=$satDate?>">
                                                        <span><?php echo $row['start_time'].'-'.$row['end_time']; ?></span>
                                                    </a>
                                                    <?php
                                                }
                                                ?>

                                            </li>
                                            <li>
                                                <span class="time <?php if (mysqli_num_rows($doctorSunSlots)>0){echo "d-none";} ?>"><span class="badge bg-danger-light">Closed</span></span>

                                                <?php
                                                while($row=$doctorSunSlots->fetch_array()) {
                                                    ?>
                                                    <a class="timing" href="visitor-outside-doctor.php?startTime=<?=$row['start_time']?>&endTime=<?=$row['end_time']?>&date=<?=$sunDate?>">
                                                        <span><?php echo $row['start_time'].'-'.$row['end_time']; ?></span>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                            <li>
                                                <span class="time <?php if (mysqli_num_rows($doctorMonSlots)>0){echo "d-none";} ?>"><span class="badge bg-danger-light">Closed</span></span>

                                                <?php
                                                while($row=$doctorMonSlots->fetch_array()) {
                                                    ?>
                                                    <a class="timing" href="visitor-outside-doctor.php?startTime=<?=$row['start_time']?>&endTime=<?=$row['end_time']?>&date=<?=$monDate?>">
                                                        <span><?php echo $row['start_time'].'-'.$row['end_time']; ?></span>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                            <li>
                                                <span class="time <?php if (mysqli_num_rows($doctorTueSlots)>0){echo "d-none";} ?>"><span class="badge bg-danger-light">Closed</span></span>

                                                <?php
                                                while($row=$doctorTueSlots->fetch_array()) {
                                                    ?>
                                                    <a class="timing" href="visitor-outside-doctor.php?startTime=<?=$row['start_time']?>&endTime=<?=$row['end_time']?>&date=<?=$tueDate?>">
                                                        <span><?php echo $row['start_time'].'-'.$row['end_time']; ?></span>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                            <li>
                                                <span class="time <?php if (mysqli_num_rows($doctorWedSlots)>0){echo "d-none";} ?>"><span class="badge bg-danger-light">Closed</span></span>

                                                <?php
                                                while($row=$doctorWedSlots->fetch_array()) {
                                                    ?>
                                                    <a class="timing" href="visitor-outside-doctor.php?startTime=<?=$row['start_time']?>&endTime=<?=$row['end_time']?>&date=<?=$wedDate?>">
                                                        <span><?php echo $row['start_time'].'-'.$row['end_time']; ?></span>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                            <li>
                                                <span class="time <?php if (mysqli_num_rows($doctorThuSlots)>0){echo "d-none";} ?>"><span class="badge bg-danger-light">Closed</span></span>

                                                <?php
                                                while($row=$doctorThuSlots->fetch_array()) {
                                                    ?>
                                                    <a class="timing" href="visitor-outside-doctor.php?startTime=<?=$row['start_time']?>&endTime=<?=$row['end_time']?>&date=<?=$thuDate?>">
                                                        <span><?php echo $row['start_time'].'-'.$row['end_time']; ?></span>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                            <li>
                                                <span class="time <?php if (mysqli_num_rows($doctorFriSlots)>0){echo "d-none";} ?>"><span class="badge bg-danger-light">Closed</span></span>

                                                <?php
                                                while($row=$doctorFriSlots->fetch_array()) {
                                                    ?>
                                                    <a class="timing" href="visitor-outside-doctor.php?startTime=<?=$row['start_time']?>&endTime=<?=$row['end_time']?>&date=<?=$friDate?>">
                                                        <span><?php echo $row['start_time'].'-'.$row['end_time']; ?></span>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- /Time Slot -->

                                </div>
                            </div>
                        </div>
                        <!-- /Schedule Content -->

                    </div>
                    <!-- /Schedule Widget -->



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
                        <div class="footer-widget footer-about">

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
                                <li><a href="appointmentBooking.php?haveaccount"><i class="fas fa-angle-double-right"></i> Login</a></li>
                                <li><a href="appointmentBooking.php?registerLink"><i class="fas fa-angle-double-right"></i> Register</a></li>
                                <li><a href="appointmentBooking.php"><i class="fas fa-angle-double-right"></i> Booking Appointment</a></li>
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
                                <li><a href="doctor-dashboard.html"><i class="fas fa-angle-double-right"></i>Check Appointments</a></li>

                                <li><a href="appointmentBooking.php?haveaccount"><i class="fas fa-angle-double-right"></i> Login</a></li>
                                <li><a href="appointmentBooking.php?doctorLink" ><i class="fas fa-angle-double-right"></i> Register</a></li>
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
<!--/Mian wrapper-->


<!-------------------------------------->
<!--         Modal Area               -->
<!-------------------------------------->
<!---Search Modal-->
<div class="modal fade" id="searchmodal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Doctors Specailities</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <h3>Text here</h3>

            </div>
        </div>
    </div>
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
                                            <form action="book-appointment-outside-doctor.php.php" method="post">

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
                                                    <a class="forgot-link" href="appointmentBooking.php?forgotpassword">Forgot Password ?</a>
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

<div class="modal fade"  id="patientRegisterModal">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content loginModal">
            <div class="login-close">
                <button type="button" class="close"  data-dismiss="modal" onclick="loginBody();"><span>&times;</span></button>
            </div>

            <!--Patient Register Modal Body-->
            <div class="modal-body">
                <!--Register Content -->

                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">

                                <!-- Patient Register Content -->
                                <div class="account-content">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="col-md-7 col-lg-6 login-left">
                                            <img src="assets/img/login-banner.png" class="img-fluid" alt="Register">
                                        </div>
                                        <div class="col-md-12 col-lg-6 login-right">
                                            <div class="login-header">
                                                <h3>Patient Register <a href="appointmentBooking.php?doctorLink">Are you a Doctor?</a></h3>
                                            </div>

                                            <!-- Register Form -->
                                            <form action="appointmentBooking.php" method="post">
                                                <div style="margin-left: 75px;display: <?php if ($userAvaliability==false){ echo 'none'; }   ?>;"><h4 style="color:red;" >User Already Exist!</h4></div>

                                                <div class="form-group form-focus">
                                                    <input type="text" name="name" required class="form-control floating">
                                                    <label class="focus-label">Full Name</label>
                                                </div>
                                                <div class="form-group form-focus">
                                                    <input type="text" name="contact" required class="form-control floating">
                                                    <label class="focus-label">Mobile Number</label>
                                                </div>
                                                <div class="form-group form-focus">
                                                    <input type="text" name="username" required class="form-control floating">
                                                    <label class="focus-label">Email / Phone Number</label>
                                                </div>
                                                <div class="form-group form-focus">
                                                    <input type="password" name="password" required class="form-control floating">
                                                    <label class="focus-label">Create Password</label>
                                                </div>
                                                <div class="form-group form-focus">
                                                    <input type="text" name="address" required class="form-control floating">
                                                    <label class="focus-label">Address</label>
                                                </div>
                                                <div class="text-right">
                                                    <a class="forgot-link" href="appointmentBooking.php?haveaccount">Already have an account?</a>
                                                </div>
                                                <button name="signupforpatient" class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>
                                                <div class="login-or">
                                                    <span class="or-line"></span>
                                                    <span class="span-or">or</span>
                                                </div>
                                                <div class="row form-row social-login">
                                                    <div class="col-6">
                                                        <a href="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</a>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- /Register Form -->

                                        </div>
                                    </div>
                                </div>
                                <!-- /Register Content -->

                            </div>
                        </div>

                    </div>

                </div>
                <!-- /Patient Register Content -->



            </div>
        </div>
    </div>
</div>
<!---/Patient Register Modal Body-->



<!--Doctor Register Modal Body-->
<div class="modal fade"  id="doctorRegisterModal">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content loginModal">
            <div class="login-close">
                <button type="button" class="close"  data-dismiss="modal" onclick="loginBody();"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <!--Doctor Register Content -->
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
                                                <h3>Doctor Register <a href="appointmentBooking.php?registerLink">Not a Doctor?</a></h3>
                                            </div>

                                            <!--Doctor Register Form -->
                                            <form action="appointmentBooking.php" method="post">
                                                <div style="margin-left: 75px;display: <?php if ($doctorAvaliability==false){ echo 'none'; }   ?>;"><h4 style="color:red;" >Doctor Already Exist!</h4></div>

                                                <div class="form-group form-focus">
                                                    <input type="text" name="name" required class="form-control floating">
                                                    <label class="focus-label">Full Name</label>
                                                </div>
                                                <div class="form-group form-focus">
                                                    <input type="text" name="contact" required class="form-control floating">
                                                    <label class="focus-label">Mobile Number</label>
                                                </div>
                                                <div class="form-group form-focus">
                                                    <input type="text" name="username" required class="form-control floating">
                                                    <label class="focus-label">Email / Phone Number / ID Given By MOHA</label>
                                                </div>
                                                <div class="form-group form-focus">
                                                    <input type="password" name="password" required class="form-control floating">
                                                    <label class="focus-label">Create Password</label>
                                                </div>
                                                <div class="text-right">
                                                    <a class="forgot-link" href="appointmentBooking.php?haveaccount">Already have an account?</a>
                                                </div>
                                                <button class="btn btn-primary btn-block btn-lg login-btn" name="submitByDoctor" type="submit">Signup</button>
                                                <div class="login-or">
                                                    <span class="or-line"></span>
                                                    <span class="span-or">or</span>
                                                </div>
                                                <div class="row form-row social-login">
                                                    <div class="col-6">
                                                        <a href="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</a>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- /Doctor Register Form -->

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                </div>
                <!-- /Doctor Register  Content -->

            </div>
        </div>
    </div>
</div>
<!--/Doctor Register Modal Body-->


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
                                            <form action="appointmentBooking.php" method="post">
                                                <div class="form-group form-focus">
                                                    <input type="email" class="form-control floating">
                                                    <label class="focus-label">Email</label>
                                                </div>
                                                <div class="text-right">
                                                    <a class="forgot-link" href="#" onclick="loginBody();">Remember your password?</a>
                                                </div>
                                                <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Reset Password</button>
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







<!-------------------------------------->
<!--         EXTERNAL SOURCES         -->
<!-------------------------------------->

<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>

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