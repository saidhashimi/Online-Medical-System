<?php
require_once ("database-connection.php");

/*  Login and Sign Up                 */


session_start();
if (!$_SESSION['doc_id']){
    header("location:search.php");
    return;
}

$userAvaliability=false;
$doctorAvaliability=false;
$signupSuccess=false;
$signupNotSuccess=false;
$registerLink=false;
$loginLink=true;

$loginUserNotAvaliable=false;


$doctorNotAprroved=false;
$msgN=false;
$msgG=false;
$msgSelectCon=false;


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
    } elseif ($checkAvaliable==0){
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

?>
<?php
$username=null;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}



$doc_id=$_SESSION['doc_id'];

$docDetails=$con->query("select * from outsidedoctor where id='$doc_id'")->fetch_array();
$docusername=$docDetails['email'];
$doc_user_id=$con->query("select user_id from users where user_username='$docusername'")->fetch_array()['user_id'];

$doctorDetails=$con->query("select * from outsidedoctor where id='$doc_id'")->fetch_array();
$doctorProfile=$con->query("select * from doctorprofile where user_id='$doc_user_id'")->fetch_array();
$doctorImage=$con->query("select file_name from pictures where  user_id='$doc_user_id'")->fetch_array()['file_name'];

$date=null;
$startTime=null;
$endTime=null;

if (isset($_REQUEST['startTime'])) {
    $date = $_REQUEST['date'];
    $startTime = $_REQUEST['startTime'];
    $endTime = $_REQUEST['endTime'];
    $time=$startTime.'-'.$endTime;

    $doc_user=$_SESSION['doc_id'];
    $checkCounter=mysqli_num_rows($con->query("select * from appointments where date='$date' and time='$time'"));
    $nowTime=date("h:m A");
    $todayDate=date("d M Y");



    if (($checkCounter>0) && (!isset($_REQUEST['nocheck']))){
        if ($todayDate==$date){
            if ($nowTime>$endTime){
                header("location:visitor-outside-doctor.php?startTime=$startTime&endTime=$endTime&date=$date&nocheck");
                return;
            }else{
                header("location:book-appointment-outside-doctor.php?doc_id=$doc_user&booked");
                return;
            }
        }else{
            header("location:book-appointment-outside-doctor.php?doc_id=$doc_user&booked");
            return;
        }
    }
}



?>

<?php
if (isset($_SESSION['username'])){

    $time=$startTime.'-'.$endTime;
    $doc_user=$_SESSION['doc_id'];

    $doDetails=$con->query("select * from outsidedoctor where id='$doc_user'")->fetch_array();
    $dousername=$doDetails['email'];


    $user_id=$con->query("select user_id from users where user_username='$username'")->fetch_array()['user_id'];
    $doc_user_id=$con->query("select user_id from users where user_username='$dousername'")->fetch_array()['user_id'];

    if ($user_id==$doc_user_id){
        header("location:book-appointment-outside-doctor.php?doc_id=$doc_user&false");
        return;
    }else {

        mysqli_query($con, "insert into appointments values ('','$time','$date','$user_id','$doc_user_id',null,'unapproved')");
        header("location:appointment-success-outside.php");
        return;
    }

}elseif (isset($_REQUEST['confirm'])){
    $name=$_REQUEST['name'];
    $age=$_REQUEST['age'];
    $gender=$_REQUEST['gender'];
    $contact=$_REQUEST['contact'];

    mysqli_query($con,"insert into visitors values ('','$name','$age','$gender','$contact')");
    $visitorID=mysqli_insert_id($con);
    $doc_user=$_SESSION['doc_id'];

    $doDetails=$con->query("select * from outsidedoctor where id='$doc_user'")->fetch_array();
    $dousername=$doDetails['email'];
    $doc_user_id=$con->query("select user_id from users where user_username='$dousername'")->fetch_array()['user_id'];



    $start=$_COOKIE['startTime'];
    $end=$_COOKIE['endTime'];
    $da=$_COOKIE['date'];

    $time=$start.'-'.$end;

    $chckN=true;
    $chckG=true;
    $chckC=true;
    $chckDigits=true;



    if (!preg_match("/^[a-zA-Z ]*$/",$name)){
        $msgN=true;
        $chckN=false;
    }if ($gender=="Select"){
        $msgG=true;
        $chckG=false;

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

    }if (($chckN==true) && ($chckG==true) && ($chckC==true)) {

        mysqli_query($con, "insert into appointments values ('','$time','$da',null ,'$doc_user_id','$visitorID','unapproved')");

        header("location:appointment-success-outside.php");
        return;
    }
}
else{
    setcookie("startTime",$startTime);
    setcookie("endTime",$endTime);
    setcookie("date",$date);
}




?>



<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Visitor - Health Guide</title>
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
            <ul class="nav header-navbar-rht">


                <!---Login/ Sign Up-->
                <li class="nav-item">
                    <a href="#" data-toggle="modal" data-target="#LoginSignupModal" class="nav-link header-login">Login / Signup </a>
                </li>
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
                    <h2 class="breadcrumb-title">Visitor Profile</h2>
                </div>

            </div>
        </div>
    </div>
    <!-- /Title Page -->

    <!-- Page Content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-md-7 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <!-- Visitor Form -->
                            <form action="visitor-outside-doctor.php" method="post">

                                <!-- Personal Information -->
                                <div class="info-widget">
                                    <h4 class="card-title">Personal Information</h4>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group card-label">

                                                <input type="hidden" name="startTime" value="<?php if (isset($_REQUEST['startTime'])){echo $_REQUEST['startTime'];} ?>">
                                                <input type="hidden" name="endTime" value="<?php if (isset($_REQUEST['endTime'])){echo $_REQUEST['endTime'];} ?>">
                                                <input type="hidden" name="date" value="<?php if (isset($_REQUEST['date'])){echo $_REQUEST['date'];} ?>">


                                                <label>Name</label>
                                                <input class="form-control" name="name" value="<?php if (isset($_REQUEST['confirm'])){echo $_REQUEST['name'];} ?>" type="text" minlength="5" maxlength="50" required>
                                                <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>


                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group card-label">
                                                <label>Age</label>
                                                <input class="form-control" name="age" type="number" min="1" max="130" value="<?php if (isset($_REQUEST['confirm'])){echo $_REQUEST['age'];} ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group card-label">
                                                <label class="<?php if ($msgG==true){ echo "bg-danger-light";} ?>">Gender</label>
                                                <select class="select" name="gender" required>
                                                    <option <?php if (isset($_REQUEST['confirm'])){if ($_REQUEST['gender']=="Select"){echo "selected";}} ?>>Select</option>
                                                    <option <?php if (isset($_REQUEST['confirm'])){if ($_REQUEST['gender']=="Male"){echo "selected";}} ?>>Male</option>
                                                    <option <?php if (isset($_REQUEST['confirm'])){if ($_REQUEST['gender']=="Female"){echo "selected";}} ?>>Female</option>


                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group card-label">
                                                <label>Phone</label>
                                                <input class="form-control" name="contact" type="text" value="<?php if (isset($_REQUEST['confirm'])){echo $_REQUEST['contact'];} ?>" required>
                                                <small class="mt-1 ml-2 bg-danger-light <?php if ($msgSelectCon==false){echo 'd-none';} ?>">Enter Valid Phone Number</small>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="exist-customer">Existing Customer? <a href="index.php?haveaccount">Click here to login</a></div>
                                </div>
                                <!-- /Personal Information -->


                                <!-- Submit Section -->
                                <div class="submit-section mt-4">
                                    <button type="submit" name="confirm" class="btn btn-primary submit-btn">Confirm</button>
                                </div>
                                <!-- /Submit Section -->


                            </form>
                            <!-- /Visitor Form -->

                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4 theiaStickySidebar">

                    <!-- Booking Summary -->
                    <div class="card booking-card">
                        <div class="card-header">
                            <h4 class="card-title">Booking Summary</h4>
                        </div>
                        <div class="card-body">

                            <!-- Booking Doctor Info -->
                            <div class="booking-doc-info">
                                <a href="doctor-profile.php?doc_id=<?=$doc_id?>" class="booking-doc-img">
                                    <img src="assets/img/doctors/<?=$doctorImage?>" alt="User Image">
                                </a>
                                <div class="booking-info">
                                    <h4><a>Dr. <?php echo $doctorDetails['firstname']." ".$doctorDetails['lastname'];  ?></a></h4>

                                    <div class="clinic-details">
                                        <p class="doc-location"><i class="fas fa-map-marker-alt" style="margin-right: 5px"></i> <?php echo $doctorDetails['location'];  ?>, Pakistan</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Booking Doctor Info -->

                            <div class="booking-summary">
                                <div class="booking-item-wrap">
                                    <ul class="booking-date">
                                        <li>Date <span><?=$date?></span></li>
                                        <li>Time <span><?php echo $startTime.'-'.$endTime; ?></span></li>
                                    </ul>
                                    <ul class="booking-fee">
                                        <li>Fees <span><?=$doctorProfile['profile_fees']?>-RS</span></li>

                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Booking Summary -->

                </div>


            </div>
        </div>
    </div>


</div>
<!--/Main Wrapper-->


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
                                            <form action="visitor-outside-doctor.php.php" method="post">

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
                                                    <a class="forgot-link" href="visitor.php?forgotpassword">Forgot Password ?</a>
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
                                                <h3>Patient Register <a href="visitor.php?doctorLink">Are you a Doctor?</a></h3>
                                            </div>

                                            <!-- Register Form -->
                                            <form action="visitor.php" method="post">
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
                                                    <a class="forgot-link" href="visitor.php?haveaccount">Already have an account?</a>
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
                                                <h3>Doctor Register <a href="visitor.php?registerLink">Not a Doctor?</a></h3>
                                            </div>

                                            <!--Doctor Register Form -->
                                            <form action="visitor.php" method="post">
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
                                                    <a class="forgot-link" href="visitor.php?haveaccount">Already have an account?</a>
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
                                            <form action="visitor.php" method="post">
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
<!--         EXTERNAL  SOURCES        -->
<!-------------------------------------->

<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>


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