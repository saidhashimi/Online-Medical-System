<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 09-Jul-20
 * Time: 1:28 PM
 */


    require_once ("database-connection.php");
    session_start();

    if (!isset($_REQUEST['doc_id'])){
        header("location:search.php");
        return;
    }
    date_default_timezone_set("Asia/Kabul");
    $doc_id=$_REQUEST['doc_id'];
    $doctorDetails=$con->query("select * from doctor where doc_id='$doc_id'")->fetch_array();
    $user_id=$con->query("select user_id from users where doc_id='$doc_id'")->fetch_array()['user_id'];
    $doctorImage=$con->query("select file_name from pictures where user_id='$user_id'")->fetch_array()['file_name'];

    $doctorServices=$con->query("select profile_services from doctorprofile where user_id='$user_id'")->fetch_array()['profile_services'];

    $doctorProfile=$con->query("select * from doctorprofile where user_id='$user_id'")->fetch_array();

    $profileID=$doctorProfile['profile_id'];

    $satSlot=$con->query("select * from doctorslots where user_id='$user_id' and saturday='yes'");
    $sunSlot=$con->query("select * from doctorslots where user_id='$user_id' and sunday='yes'");
    $monSlot=$con->query("select * from doctorslots where user_id='$user_id' and monday='yes'");
    $tueSlot=$con->query("select * from doctorslots where user_id='$user_id' and tuesday='yes'");
    $wedSlot=$con->query("select * from doctorslots where user_id='$user_id' and wednesday='yes'");
    $thuSlot=$con->query("select * from doctorslots where user_id='$user_id' and thursday='yes'");
    $friSlot=$con->query("select * from doctorslots where user_id='$user_id' and friday='yes'");

    $today=date("D");
    $todaySlots=null;
    $end=null;
    $start=null;
    $open=false;
    $close=false;


    if ($today=='Sat'){
        $todaySlots=$con->query("select * from doctorslots where user_id='$user_id' and saturday='yes'");
    }elseif ($today=='Sun'){
        $todaySlots=$con->query("select * from doctorslots where user_id='$user_id' and sunday='yes'");
    }elseif ($today=='Mon'){
        $todaySlots=$con->query("select * from doctorslots where user_id='$user_id' and monday='yes'");
    }elseif ($today=='Tue'){
        $todaySlots=$con->query("select * from doctorslots where user_id='$user_id' and tuesday='yes'");
    }elseif ($today=='Wed'){
        $todaySlots=$con->query("select * from doctorslots where user_id='$user_id' and wednesday='yes'");
    }elseif ($today=='Thu'){
        $todaySlots=$con->query("select * from doctorslots where user_id='$user_id' and thursday='yes'");
    }

    $ds=$doctorProfile['profile_services'];

    $dspecializations=explode(",",$ds);

    /*    Login and Sign UP          */

$userAvaliability=false;
$doctorAvaliability=false;
$signupSuccess=false;
$signupNotSuccess=false;
$registerLink=false;
$loginLink=true;

$loginUserNotAvaliable=false;


$doctorNotAprroved=false;






/*    Login Request          */
if (isset($_REQUEST['login'])){
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];

    $getLoginDetails="select doc_id,user_username,user_password,user_type,user_status from users where user_username='$username'";

    $checkAvaliable=mysqli_num_rows($con->query($getLoginDetails));
    $getLogin=$con->query($getLoginDetails)->fetch_array();
    if ($checkAvaliable==0){
        $loginUserNotAvaliable=true;

    }
    elseif (($getLogin['user_username']==$username) && ($getLogin['user_password']==$password) ){
        if ($getLogin['user_type']=='patient') {
            $_SESSION['username']=$username;
            header("location:patient-dashboard.php");
            return;
        }elseif ($getLogin['user_type']=='doctor'){

            if ($getLogin['user_status']=='unapproved'){
                $doctorNotAprroved=true;
            }else{
                $_SESSION['username']=$username;
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
            $_SESSION['username']=$username;
            header("location:moha-dashboard.php");
            return;
        } elseif ($getLogin['user_type']=='super admin'){
            $_SESSION['username']=$username;
            header("location:./super admin/index.php");
            return;
        }

    }

    else{
        $loginUserNotAvaliable=true;
    }


}

/*    SignUp Request          */
if (isset($_REQUEST['signupforpatient'])){
    $name=$_REQUEST['name'];
    $contact=$_REQUEST['contact'];
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];
    $address=$_REQUEST['address'];





    $users=$con->query("select user_username from users where user_username='$username'");
    $usrName=$users->fetch_array();

    if ($username==$usrName['user_username']){
        $userAvaliability=true;
    }
    elseif ($userAvaliability==false){

        $insertUser="insert into users values ('','$name','$username','$password','$address','$contact','patient','approved', NULL )";
        if ($con->query($insertUser)==true){
            $signupSuccess=true;
        }
        else{
            $signupNotSuccess=true;
        }

    }
    else{
        echo " <script> $( '#LoginSignupModal' ).modal('show') </script> ";
    }

}
elseif (isset($_REQUEST['submitByDoctor'])){
    $name=$_REQUEST['name'];
    $contact=$_REQUEST['contact'];
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];





    $users=$con->query("select user_username from users where user_username='$username'");
    $usrName=$users->fetch_array();

    if ($username==$usrName['user_username']){
        $doctorAvaliability=true;
    }
    elseif ($userAvaliability==false){
        $insertUser="insert into users values ('','$name','$username','$password','','$contact','doctor','unapproved', null )";
        if ($con->query($insertUser)==true){
            $signupSuccess=true;

        }
        else{
            $signupNotSuccess=true;
        }

    }
    else{
        echo " <script> $( '#LoginSignupModal' ).modal('show') </script> ";
    }

}

/*   End Login and Sign Up   */

$loginShow=true;
$short=false;
$dirImage=null;
$dashboard=null;
$profile=null;
$logout=null;
$type=null;
$showreview=false;
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

    if (isset($_REQUEST['send'])){
        $message=$_REQUEST['message'];
        $from=$con->query("select * from users where user_username='$username'")->fetch_array()['user_id'];
        $to=$con->query("select * from users where doc_id='$doc_id'")->fetch_array()['user_id'];
        $date=date("Y-m-d h:i:s");


        if ($from==$to){
            header("location:doctor-profile.php?doc_id=$doc_id&self");
            return;
        }elseif ($con->query("insert into chat_message values ('','$to','$from','$message','$date','not seen')")){
            header("location:doctor-profile.php?doc_id=$doc_id&in");
            return;
        }else{
            header("location:doctor-profile.php?doc_id=$doc_id&out");
            return;
        }




    }



}


?>


<?php

    $msgN=false;
    $msgD=false;
    $showreviewtab=false;

    if (isset($_REQUEST['review'])){
        $showreview=true;

    }

    if (isset($_REQUEST['addreview'])) {
        $reviewmsg = $_REQUEST['review_msg'];
        $stars = 0;
        if (isset($_REQUEST['rating'])){
            $stars = $_REQUEST['rating'];
    }

        if (isset($_SESSION['username'])){
            $username=$_SESSION['username'];
            $reviewer=$con->query("select * from users where user_username='$username'")->fetch_array();
            $reviewer_id=$reviewer['user_id'];
            $review_type=$reviewer['user_type'];
            $date=date("Y-m-d h:i:s");
            $chckN=true;
            if (!preg_match("/^[a-zA-Z ]*$/",$reviewmsg)){
                $msgN=true;
                $chckN=false;
                $showreview=true;
            }elseif (($review_type=='doctor') || ($review_type=='outside doctor')){
                header("location:doctor-profile.php?doc_id=$doc_id&showreviewsmodal&notallow");
                return;
            }
            elseif ($chckN==true){

                if ($con->query("insert into reviews values ('','$user_id','$reviewer_id','$reviewmsg','$date','$stars')")){
                        header("location:doctor-profile.php?doc_id=$doc_id&showreviewsmodal&saved");
                        return;
                }
            }

        }else{
            header("location:doctor-profile.php?doc_id=$doc_id&showreviewsmodal&noaccount");
            return;
        }


    }
    if (isset($_REQUEST['showreviewsmodal'])){
        $showreviewtab=true;
    }
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Doctor Profile - Health Guide</title>

    <link href="assets/img/favicon.png" rel="icon">



    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
<!----------------------------------------->
<!--          MAIN WRAPPER               -->
<!----------------------------------------->
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
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8 col-12">

                    <h2 class="breadcrumb-title">Doctor Profile<small class="ml-2 btn-sm btn-primary <?php if (!isset($_REQUEST['in'])){echo 'd-none';} ?>">Message Send</small><small class="ml-2 btn-sm btn-primary <?php if (!isset($_REQUEST['send'])){echo 'd-none';} ?>">Sorry, you cann't make a message, for sending a message create your account on Health Guide,<a href="patient-signup.php"> Register</a> </small><small class="ml-2 btn-sm bg-primary <?php if (!isset($_REQUEST['self'])){echo 'd-none';} ?>">Sorry, you are not allowed to send message to the same user</small> <small class="ml-2 btn-sm btn-danger <?php if (!isset($_REQUEST['out'])){echo 'd-none';} ?>">Not Send</small></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->


    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <!-- Doctor Widget -->
            <div class="card">
                <div class="card-body">
                    <div class="doctor-widget">
                        <div class="doc-info-left">
                            <div class="doctor-img">
                                <img src="assets/img/doctors/<?=$doctorImage?>" class="img-fluid" alt="Doctor Image">
                            </div>
                            <div class="doc-info-cont">
                                <h4 class="doc-name">Dr. <?php echo $doctorDetails['doc_firstName'].' '.$doctorDetails['doc_lastName']; ?></h4>
                                <p class="doc-speciality"><?php echo $doctorDetails['doc_qualification'].', '.$doctorDetails['doc_university'] ?></p>
                                <h5 class="doc-department"><?=$doctorDetails['doc_specialization']?></h5>


                                <div class="clinic-services mt-4">
                                    <?php
                                        for ($i=0;$i<sizeof($dspecializations);$i++) {
                                            ?>
                                            <span><?=$dspecializations[$i]?></span>


                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="doc-info-right">
                            <div class="clini-infos">
                                <ul>

                                    <li><i class="fas fa-map-marker-alt" title="Location"></i>  <?= $doctorDetails['doc_location']?></li>
                                    <li><i class="far fa-money-bill-alt"></i> <?=$doctorProfile['profile_fees']?>-Afg Fees </li>
                                </ul>
                            </div>
                            <div class="doctor-action">

                                <a  class="btn btn-white msg-btn" data-toggle="modal" data-target="#messageModal">
                                    <i class="far fa-comment-alt mt-1"></i>
                                </a>
                                <a  class="btn btn-white msg-btn " data-toggle="modal" data-target="#reviewmodal">
                                    Reviews
                                </a>

                            </div>
                            <div class="clinic-booking">
                                <a class="apt-btn" href="appointmentBooking.php?doc_id=<?=$doc_id?>">Book Appointment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Doctor Widget -->

            <!-- Doctor Details Tab -->
            <div class="card">
                <div class="card-body pt-0">

                    <!-- Tab Menu -->
                    <nav class="user-tabs mb-4">
                        <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                            <li class="nav-item">
                                <a class="nav-link <?php if ((!isset($_REQUEST['in'])) || (!isset($_REQUEST['out']))){echo 'active';} ?>" href="#doc_overview" data-toggle="tab">Overview</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#doc_reviews" data-toggle="tab">Send Message</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#doc_business_hours" data-toggle="tab">Business Hours</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /Tab Menu -->

                    <!-- Tab Content -->
                    <div class="tab-content pt-0">

                        <!-- Overview Content -->
                        <div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
                            <div class="row">
                                <div class="col-md-12 col-lg-9">

                                    <!-- About Details -->
                                    <div class="widget about-widget">
                                        <h4 class="widget-title">About Me</h4>
                                        <p style="color: black;"><?=$doctorProfile['profile_biography']?></p>
                                    </div>
                                    <!-- /About Details -->

                                    <!-- Education Details -->
                                    <div class="widget education-widget">
                                        <h4 class="widget-title">Education</h4>
                                        <div class="experience-box">
                                            <ul class="experience-list">
                                                <?php

                                                    $doctorEducation=$con->query("select * from doctoreducation where profile_id='$profileID'");

                                                    while($row=$doctorEducation->fetch_array()) {


                                                        ?>
                                                        <li>
                                                            <div class="experience-user">
                                                                <div class="before-circle"></div>
                                                            </div>
                                                            <div class="experience-content">
                                                                <div class="timeline-content">
                                                                    <a  class="name"><?=$row['college']?></a>
                                                                    <div><?=$row['degree']?></div>
                                                                    <span class="time">Completion Year <?=$row['yearofcompletion']?></span>
                                                                </div>
                                                            </div>
                                                        </li>

                                                        <?php
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /Education Details -->

                                    <!-- Experience Details -->
                                    <div class="widget experience-widget">
                                        <h4 class="widget-title">Work & Experience</h4>
                                        <div class="experience-box">
                                            <ul class="experience-list">
                                                <?php

                                                $doctorExperience=$con->query("select * from doctorexpierence where profile_id='$profileID'");

                                                while($row=$doctorExperience->fetch_array()) {


                                                    ?>
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <a class="name"><?=$row['hospitalName']?></a>
                                                                <span class="time"><?=$row['startFrom']?> - <?=$row['endDate']?></span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /Experience Details -->



                                    <!-- Services List -->
                                    <div class="service-list">
                                        <h4>Services</h4>
                                        <ul class="clearfix">
                                            <?php
                                                $services=$doctorProfile['profile_services'];
                                                $docServices=explode(",",$services);
                                                for ($i=0;$i<sizeof($docServices);$i++) {

                                                    ?>
                                                    <li><?=$docServices[$i]?></li>
                                                    <?php
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                    <!-- /Services List -->

                                    <!-- Specializations List -->
                                    <div class="service-list">
                                        <h4>Specializations</h4>
                                        <ul class="clearfix">
                                            <?php
                                            $doctorSpecializations=$doctorProfile['profile_specilizations'];
                                            $doctorSpecializations=explode(",",$doctorSpecializations);

                                            for ($i=0;$i<sizeof($doctorSpecializations);$i++) {

                                                ?>
                                                <li><?=$doctorSpecializations[$i]?></li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <!-- /Specializations List -->

                                    <!-- Locations-->
                                    <div class="widget experience-widget">
                                        <h4 class="widget-title">Clinic Details</h4>
                                        <div class="experience-box">
                                            <ul class="experience-list">
                                                <?php

                                                $doctorClinics=$con->query("select * from doctorclinics where profile_id='$profileID'");

                                                while($row=$doctorClinics->fetch_array()) {


                                                    ?>
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <a class="name"><?=$row['clinic_name']?></a>
                                                                <span class="time"><i class="fas fa-map-marker-alt"></i> <?=$row['clinic_address']?>, Afghanistan</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /Locations -->

                                </div>
                            </div>
                        </div>
                        <!-- /Overview Content -->


                        <!-- Reviews Content -->
                        <div role="tabpanel" id="doc_reviews" class="tab-pane fade">



                            <!-- Write Review -->
                            <div class="write-review">
                                <h4>Write a message to <strong>Dr. <?php echo $doctorDetails['doc_firstName'].' '.$doctorDetails['doc_lastName'];?></strong></h4>

                                <!-- Write Review Form -->
                                <form action="doctor-profile.php" method="post">

                                    <input type="hidden" name="doc_id" value="<?=$doc_id?>">

                                    <div class="form-group">
                                        <label>Your Message</label>
                                        <textarea id="review_desc" placeholder="type message here" name="message" maxlength="500" class="form-control"></textarea>

                                        <div class="d-flex justify-content-between mt-3"><small class="text-muted"><span id="chars">500</span> characters remaining</small></div>
                                    </div>
                                    <hr>
                                    <div class="form-group">

                                    </div>
                                    <div class="submit-section float-right">
                                        <button type="submit" name="send" class="btn bg-success-light submit-btn">Send Message</button>
                                    </div>
                                </form>
                                <!-- /Write Review Form -->

                            </div>
                            <!-- /Write Review -->

                        </div>
                        <!-- /Reviews Content -->

                        <!-- Business Hours Content -->
                        <div role="tabpanel" id="doc_business_hours" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">

                                    <!-- Business Hours Widget -->
                                    <div class="widget business-widget">
                                        <div class="widget-content">
                                            <div class="listing-hours">
                                                <div class="listing-day current">
                                                    <div class="day">Today <span><?php echo date("d M Y") ?></span></div>
                                                    <div class="time-items">

                                                        <?php
                                                        if (mysqli_num_rows($todaySlots)>0){
                                                        while ($row=$todaySlots->fetch_array()) {
                                                            $start=$row['start_time'];
                                                            $end=$row['end_time'];
                                                            $nowTime=date("h:m A");

                                                            if (($nowTime>=$start) && ($nowTime<$end)){
                                                                $open=true;
                                                                $close=false;
                                                            }else{
                                                                $close=true;
                                                                $open=false;
                                                            }
                                                            ?>
                                                            <span class="time"> <?php echo $row['start_time']." - ".$row['end_time'] ?></span>
                                                            <?php



                                                         }}else{
                                                            $close=true;
                                                            $open=false;
                                                            ?>

                                                        <?php
                                                        }

                                                        ?>
                                                        <?php

                                                        ?>
                                                        <span class="open-status mt-2 <?php if ($close==true){echo 'd-none'; } ?>"><span class="badge bg-success-light">Open Now</span></span>
                                                        <span class="time mt-2 <?php if ($open==true){echo 'd-none'; } ?> "><span class="badge bg-danger-light">Closed</span></span>

                                                    </div>
                                                </div>
                                                <div class="listing-day">
                                                    <div class="day">Saturday Slots</div>

                                                            <div class="time-items">
                                                                <?php
                                                                    if (mysqli_num_rows($satSlot)>0){
                                                                    while ($row=$satSlot->fetch_array()) {
                                                                        ?>
                                                                        <span class="time"><?php echo $row['start_time']." - ".$row['end_time'] ?></span>
                                                                        <?php
                                                                    }}else{

                                                                        ?>
                                                                        <span class="time mt-2 "><span class="badge bg-danger-light">Closed</span></span>

                                                                        <?php
                                                                    }
                                                                ?>

                                                            </div>


                                                </div>
                                                <div class="listing-day ">
                                                    <div class="day">Sunday Slots</div>
                                                    <div class="time-items">
                                                        <?php
                                                        if (mysqli_num_rows($sunSlot)>0){
                                                        while ($row=$sunSlot->fetch_array()) {
                                                            ?>
                                                            <span class="time"> <?php echo $row['start_time']." - ".$row['end_time'] ?></span>
                                                            <?php
                                                        }}else{

                                                            ?>
                                                            <span class="time mt-2 "><span class="badge bg-danger-light">Closed</span></span>

                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="listing-day">
                                                    <div class="day">Monday Slots</div>
                                                    <div class="time-items">
                                                        <?php
                                                        if (mysqli_num_rows($monSlot)>0){
                                                        while ($row=$monSlot->fetch_array()) {
                                                            ?>
                                                            <span class="time"> <?php echo $row['start_time']." - ".$row['end_time'] ?></span>
                                                            <?php
                                                        }}else{

                                                            ?>
                                                            <span class="time mt-2 "><span class="badge bg-danger-light">Closed</span></span>

                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="listing-day">
                                                    <div class="day">Tuesday Slots</div>
                                                    <div class="time-items">
                                                        <?php
                                                        if (mysqli_num_rows($tueSlot)){
                                                        while ($row=$tueSlot->fetch_array()) {
                                                            ?>
                                                            <span class="time"><?php echo $row['start_time']." - ".$row['end_time'] ?></span>
                                                            <?php
                                                        }}else{

                                                            ?>
                                                            <span class="time mt-2 "><span class="badge bg-danger-light">Closed</span></span>

                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="listing-day">
                                                    <div class="day">Wednesday Slots</div>
                                                    <div class="time-items">
                                                        <?php
                                                        if (mysqli_num_rows($wedSlot)>0){
                                                        while ($row=$wedSlot->fetch_array()) {
                                                            ?>
                                                            <span class="time"> <?php echo $row['start_time']." - ".$row['end_time'] ?></span>
                                                            <?php
                                                        }}else{

                                                            ?>
                                                            <span class="time mt-2 "><span class="badge bg-danger-light">Closed</span></span>

                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="listing-day">
                                                    <div class="day">Thursday Slots</div>
                                                    <div class="time-items">
                                                        <?php
                                                        if (mysqli_num_rows($thuSlot)>0){
                                                        while ($row=$thuSlot->fetch_array()) {
                                                            ?>
                                                            <span class="time"> <?php echo $row['start_time']." - ".$row['end_time'] ?></span>
                                                            <?php
                                                        }}else{

                                                            ?>
                                                            <span class="time mt-2 "><span class="badge bg-danger-light">Closed</span></span>

                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="listing-day closed">
                                                    <div class="day">Friday</div>
                                                    <div class="time-items">
                                                        <span class="time"><span class="badge bg-danger-light">Closed</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Business Hours Widget -->

                                </div>
                            </div>
                        </div>
                        <!-- /Business Hours Content -->

                    </div>
                </div>
            </div>
            <!-- /Doctor Details Tab -->
        </div>
    </div>
    <!--/Page Content-->


</div>
<!--/Main Wrapper-->



<!----------------------------------------->
<!--          MODAL PART                 -->
<!----------------------------------------->

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
                                            <form action="index.php" method="post">

                                                <div class="form-group form-focus">
                                                    <input type="text" name="username" class="form-control floating" required>
                                                    <label class="focus-label">Email / Phone Number</label>
                                                </div>
                                                <div class="form-group form-focus">
                                                    <input type="password" name="password" class="form-control floating" required>
                                                    <label class="focus-label">Password</label>
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
                                                    <a class="forgot-link" href="doctor-profile.php?forgotpassword">Forgot Password ?</a>
                                                </div>
                                                <button class="btn btn-primary btn-block btn-lg login-btn" name="login" type="submit">Login</button>
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
                                                <div class="text-center dont-have">Don’t have an account? <a href="doctor-profile.php?registerLink">Register</a></div>
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
                                                <h3>Patient Register <a href="index.php?doctorLink">Are you a Doctor?</a></h3>
                                            </div>

                                            <!-- Register Form -->
                                            <form action="index.php" method="post">
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
                                                    <a class="forgot-link" href="doctor-profile.php?haveaccount">Already have an account?</a>
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
                                                <h3>Doctor Register <a href="index.php?registerLink">Not a Doctor?</a></h3>
                                            </div>

                                            <!--Doctor Register Form -->
                                            <form action="index.php" method="post">
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
                                                    <a class="forgot-link" href="doctor-profile.php?haveaccount">Already have an account?</a>
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
                                            <form action="index.php" method="post">
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
                                            <form action="doctor-profile.php" method="post">

                                                <input type="hidden" name="doc_id" value="<?=$doc_id?>">

                                                <div class="form-group">
                                                    <textarea id="review_desc" placeholder="type message here" name="message" maxlength="500" class="form-control"></textarea>

                                                    <div class="d-flex justify-content-between mt-3"><small class="text-muted"><span id="chars">500</span> characters only</small></div>
                                                </div>

                                                <button class="btn btn-primary btn-block btn-lg login-btn" type="submit" name="send">Send Message</button>
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

<!--Message Modal Body-->
<div class="modal fade"  id="reviewmodal">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content loginModal">
            <div class="login-close">
                <button type="button" class="close"  data-dismiss="modal" onclick="loginBody();"><span>&times;</span></button>
                <small class="btn btn-sm bg-success-light ml-4 mt-2 <?php if (!isset($_REQUEST['saved'])){echo "d-none";} ?>">Your review saved</small>
                <small class="btn btn-sm bg-primary-light ml-4 mt-2 <?php if (!isset($_REQUEST['noaccount'])){echo "d-none";} ?>">You can't make a review, for making review create your own account, <a href="patient-signup.php"> click here</a></small>
                <small class="btn btn-sm bg-danger-light ml-4 mt-2 <?php if (!isset($_REQUEST['notallow'])){echo "d-none";} ?>">Sorry you are not allowed to make a review</small>

            </div>
            <div class="modal-body">



                <!-- Review Listing -->
                <div class="widget review-listing">
                    <ul class="comments-list">
                        <?php
                            $reviewDetails=$con->query("select * from reviews where profile_id='$doc_id'");

                            while ($row=$reviewDetails->fetch_array()) {

                                $reviewer_id=$row['reviewer_id'];

                                $reviewerDetails=$con->query("select * from users where user_id='$reviewer_id'")->fetch_array();
                                $reviewImage=$con->query("select file_name from pictures where user_id='$reviewer_id'")->fetch_array()['file_name'];
                                $date=$row['review_date'];

                                $date=date("d M Y",strtotime($row['review_date']));

                                ?>
                                <!-- Comment List -->
                                <li>
                                    <div class="comment">
                                        <img class="avatar avatar-sm rounded-circle" alt="User Image"
                                             src="assets/img/patients/<?=$reviewImage?>">
                                        <div class="comment-body">
                                            <div class="meta-data">
                                                <span class="comment-author"><?=$reviewerDetails['user_name']?></span>
                                                <span class="comment-date">Reviewed <?=$date?></span>
                                                <div class="review-count rating" style="left: 300px">

                                                    <?php
                                                        if ($row['rating']==1){
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                        }elseif ($row['rating']==2){
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                        }elseif ($row['rating']==3){
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                        }elseif ($row['rating']==4){
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                        }elseif ($row['rating']==5){
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                            echo "<i class=\"fas fa-star filled\"></i>";
                                                        }else{
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                            echo "<i class=\"fas fa-star \"></i>";
                                                        }
                                                    ?>

                                                </div>
                                            </div>

                                            <p class="comment-content">
                                               <?=$row['reviewer_msg']?>
                                            </p>

                                        </div>
                                    </div>



                                </li>
                                <!-- /Comment List -->
                                <?php
                            }
                        ?>

                    </ul>

                </div>
                <!-- /Review Listing -->
            </div>
            <div class="modal-footer">
                <!-- Show All -->

                    <a href="doctor-profile.php?doc_id=<?=$doctorDetails['doc_id']?>&review" class="btn btn-outline-primary">
                        Make Review <strong></strong>
                    </a>

                <!-- /Show All -->
            </div>

            <!---Message Modal Body-->
        </div>

    </div>

</div>

<!--Message Modal Body-->
<div class="modal fade"  id="review">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content loginModal">
            <div class="login-close">

                <button type="button" class="close"  data-dismiss="modal" onclick="loginBody();"><span>&times;</span></button>
            </div>
            <div class="modal-body">


                <!-- Write Review -->
                <div class="write-review">
                    <h4>Write a review for <strong>Dr. <?=$doctorDetails['doc_firstName'].' '.$doctorDetails['doc_lastName']?></strong></h4>

                    <!-- Write Review Form -->
                    <form action="doctor-profile.php" method="get">
                        <input type="hidden" name="doc_id" value="<?=$doctorDetails['doc_id']?>">
                        <div class="form-group">
                            <div class="star-rating">
                                <input id="star-5" type="radio" name="rating" value="5" <?php if (isset($_REQUEST['rating'])){if($_REQUEST['rating']==5){echo "checked";}} ?>>
                                <label for="star-5" title="5 stars">
                                    <i class="active fa fa-star"></i>
                                </label>
                                <input id="star-4" type="radio" name="rating" value="4"  <?php if (isset($_REQUEST['rating'])){if($_REQUEST['rating']==4){echo "checked";}} ?>>
                                <label for="star-4" title="4 stars">
                                    <i class="active fa fa-star"></i>
                                </label>
                                <input id="star-3" type="radio" name="rating" value="3"  <?php if (isset($_REQUEST['rating'])){if($_REQUEST['rating']==3){echo "checked";}} ?>>
                                <label for="star-3" title="3 stars">
                                    <i class="active fa fa-star"></i>
                                </label>
                                <input id="star-2" type="radio" name="rating" value="2"  <?php if (isset($_REQUEST['rating'])){if($_REQUEST['rating']==2){echo "checked";}} ?>>
                                <label for="star-2" title="2 stars">
                                    <i class="active fa fa-star"></i>
                                </label>
                                <input id="star-1" type="radio" name="rating" value="1"  <?php if (isset($_REQUEST['rating'])){if($_REQUEST['rating']==1){echo "checked";}} ?>>
                                <label for="star-1" title="1 star">
                                    <i class="active fa fa-star"></i>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Your review</label>
                            <input type="text" id="review_desc" name="review_msg" maxlength="150" value="<?php if (isset($_REQUEST['review_msg'])){echo $_REQUEST['review_msg'];} ?>" class="form-control <?php if ($msgN==true){echo "bg-danger-light";} ?>" required>
                            <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>
                            <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgD==false){echo 'd-none'; } ?>">Sorry you are not allowed to make a review</small>

                            <div class="d-flex justify-content-between mt-3"><small class="text-muted"><span id="chars">150</span> characters</small></div>
                        </div>
                        <hr>

                        <div class="submit-section">
                            <button type="submit" name="addreview" class="btn btn-primary submit-btn">Add Review</button>
                        </div>
                    </form>
                    <!-- /Write Review Form -->

                </div>
                <!-- /Write Review -->
            </div>

            <!---Message Modal Body-->
        </div>

    </div>

</div>
<!----------------------------------------->
<!--          EXTERNAL SOURCES           -->
<!----------------------------------------->

<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>


<!-- Fancybox JS -->
<script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>
<!-- Slick JS -->
<script src="assets/js/slick.js"></script>



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
elseif ($showreview==true){
    echo "<script>
        $( '#review').modal('show');
      </script> ";
}
elseif ($showreviewtab==true){
    echo "<script>
        $( '#reviewmodal').modal('show');
      </script> ";
}


?>
<script type="text/javascript">
    var objDiv = document.getElementById("reviewmodal");
    objDiv.scrollTop = objDiv.scrollHeight;
</script>

</body>
</html>
