<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 14-Aug-20
 * Time: 3:33 PM
 */

    require_once ("database-connection.php");
    session_start();
    if (isset($_SESSION['username'])){
        header("index.php");
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
/*    SignUp Request          */

$msgPN=false;
$msgPM=false;
$lengthP=true;
$upCaseP=true;
$lowCaseP=true;
$numP=true;
$speCharacterP=true;
$checkStrngthP=false;
$msgPA=false;


if (isset($_REQUEST['signupforpatient'])){
    $name=$_REQUEST['name'];
    $contact=$_REQUEST['contact'];
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];
    $address=$_REQUEST['address'];




    $chckPN=true;
    $chckPM=true;
    $chckPA=true;
    $chckDigits=true;




    $uppercase=preg_match("@[A-Z]@",$password);
    $lowercase=preg_match("@[a-z]@",$password);
    $number=preg_match("@[0-9]@",$password);
    $specialCharacters=preg_match("@[^\w]@",$password);

    $users=$con->query("select user_username from users where user_username='$username'");
    $usrName=$users->fetch_array();

    if (!preg_match("/^[a-zA-Z ]*$/",$name)){
        $msgPN=true;
        $chckPN=false;
    }if (!preg_match('/^[0-9]{10}+$/',$contact)){
        $msgPM=true;
        $chckPM=false;
        $chckDigits=false;


    }if ($chckDigits==true){

        $subDigit=substr($contact,0,3);

        if (($subDigit=="078") || ($subDigit=="077") || ($subDigit=="076") || ($subDigit=="079") || ($subDigit=="072") || ($subDigit=="070")){
            $msgPM=false;
            $chckPM=true;


        }else{
            $msgPM=true;
            $chckPM=false;

        }

    }if ($password!=null){

        if (strlen($password)<8){
            $lengthP=false;
            $checkStrngthP=true;

        }elseif (!$uppercase){
            $upCaseP=false;
            $checkStrngthP=true;
        }elseif (!$lowercase){
            $lowCaseP=false;
            $checkStrngthP=true;
        }elseif (!$number){
            $numP=false;
            $checkStrngthP=true;

        }elseif (!$specialCharacters){
            $speCharacterP=false;
            $checkStrngthP=true;

        }
    }if ($address=="Address"){
        $msgPA=true;
        $chckPA=false;
    }if (($chckPA==true) && ($chckPM==true) && ($checkStrngthP==false) && ($chckPA==true)) {
        $password=password_hash($password,PASSWORD_DEFAULT);


        if ($username == $usrName['user_username']) {
            header("location:patient-signup.php?exist");
            return;
        } elseif ($userAvaliability == false) {

            $insertUser = "insert into users values ('','$name','$username','$password','$address','$contact','patient','unapproved', NULL )";
            if ($con->query($insertUser) == true) {
                $to=$username;
                $subject="Approve Your Health Guide Account";


// Message
                $message = "
<html>
<head>
  <title>Approve Your Health Guide Patient Account</title>
</head>
<body>
  <h3>Here is the link to activate your health guide account:</h3>
   <a href='http://localhost/fyp%20project/activate-account-for-patient.php?username=$to'>Click Here To Activate Account</a>
   <p>Thanks</p>
</body>
</html>
";

                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers

                $headers[] = 'From: Health Guide <saidmuqeemhashimi@gmail.com>';


                if(mail($to,$subject,$message,implode("\r\n", $headers))){

                    header("location:patient-signup.php?send");
                    return;

                }

            } else {
                $signupNotSuccess = true;
            }

        } else {
            echo " <script> $( '#LoginSignupModal' ).modal('show') </script> ";
        }

    }

}



?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Signup - Health Guide</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="assets/img/favicon.png" rel="icon">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

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
            <ul class="nav header-navbar-rht">

                <!---Login/ Sign Up-->
                <li class="nav-item">
                    <a href="#" data-toggle="modal" data-target="#LoginSignupModal" class="nav-link header-login">Login / Signup </a>
                </li>
            </ul>

        </nav>


    </header>

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
                                    <h3>Patient Register <a href="doctor-signup.php">Are you a Doctor?</a></h3>
                                </div>

                                <!-- Register Form -->
                                <form action="patient-signup.php" method="post">
                                    <div style="margin-left: 75px;display: <?php if (!isset($_REQUEST['exist'])){ echo 'none'; }   ?>;"><h4 style="color:red;" >User Already Exist!</h4></div>
                                    <div style="margin-left: ;display: <?php if (!isset($_REQUEST['send'])){ echo 'none'; }   ?>;"><h4 style="color:green;" >An email has been sent to your account, go their and click on link to activate your account</h4></div>

                                    <div class="form-group form-focus">
                                        <input type="text" name="name" minlength="5" maxlength="50" value="<?php if (isset($_REQUEST['signupforpatient'])){echo $_REQUEST['name'];} ?>" required class="form-control floating">
                                        <label class="focus-label">Full Name</label>
                                        <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgPN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="text" name="contact" value="<?php if (isset($_REQUEST['signupforpatient'])){echo $_REQUEST['contact'];} ?>" required class="form-control floating">
                                        <label class="focus-label">Mobile Number</label>
                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgPM==false){echo 'd-none';} ?>">Enter Valid Phone Number</small>

                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="email" value="<?php if (isset($_REQUEST['signupforpatient'])){echo $_REQUEST['username'];} ?>" name="username" required class="form-control floating">
                                        <label class="focus-label">Email</label>
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="password" name="password" value="<?php if (isset($_REQUEST['signupforpatient'])){echo $_REQUEST['password'];} ?>" required class="form-control floating <?php if (isset($_REQUEST['signupforpatient'])){if ($checkStrngthP==true){echo "bg-danger-light";}} ?>">
                                        <label class="focus-label">Create Password</label>

                                        <small class="text-muted <?php if (isset($_REQUEST['signupforpatient'])){if ($lengthP==false){echo "d-block";}else{echo "d-none";}}else{echo "d-none";} ?>">more then 8 characters</small>
                                        <small class="text-muted <?php if (isset($_REQUEST['signupforpatient'])){if ($upCaseP==false){echo "d-block";}else{echo "d-none";}}else{echo "d-none";} ?>">at least one upper case letter</small>
                                        <small class="text-muted <?php if (isset($_REQUEST['signupforpatient'])){if ($lowCaseP==false){echo "d-block";}else{echo "d-none";}}else{echo "d-none";} ?>">at least one lower case letter</small>
                                        <small class="text-muted <?php if (isset($_REQUEST['signupforpatient'])){if ($numP==false){echo "d-block";}else{echo "d-none";}}else{echo "d-none";} ?>">at least one number</small>
                                        <small class="text-muted <?php if (isset($_REQUEST['signupforpatient'])){if ($speCharacterP==false){echo "d-block";}else{echo "d-none";}}else{echo "d-none";} ?>">at least one special character</small>


                                    </div>
                                    <div class="form-group form-focus">


                                        <select name="address" class="form-control select <?php if (isset($_REQUEST['signupforpatient'])){if ($msgPA==true){echo "bg-danger-light";}} ?>">
                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Address"){echo "selected";}} ?>>Address</option>

                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Kabul"){echo "selected";}} ?>>Kabul</option>
                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Nangarhar"){echo "selected";}} ?>>Nangarhar</option>
                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Konar"){echo "selected";}}?>>Konar</option>
                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Logar"){echo "selected";}} ?>>Logar</option>
                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Paktia"){echo "selected";}} ?>>Paktia</option>

                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Khost"){echo "selected";}}?>>Khost</option>
                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Ghazni"){echo "selected";}}?>>Ghazni</option>
                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Balkh"){echo "selected";}} ?>>Balkh</option>
                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Herat"){echo "selected";}} ?>>Herat</option>
                                            <option <?php if (isset($_REQUEST['signupforpatient'])){if ($_REQUEST['address']=="Laghman"){echo "selected";}} ?>>Laghman</option>





                                        </select>
                                    </div>
                                    <div class="text-right">
                                        <a class="forgot-link" href="patient-signup.php?haveaccount">Already have an account?</a>
                                    </div>
                                    <button name="signupforpatient" class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>

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
                                <ul class="policy-menu">
                                    <li><a href="term-condition.html">Terms and Conditions</a></li>
                                    <li><a href="privacy-policy.html">Policy</a></li>
                                </ul>
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
                                            <form action="patient-signup.php" method="post">

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
                                            <form action="patient-signup.php" method="post">
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
}elseif ($chckUsername==true){
    echo "<script>
        $( '#forgotPasswordModal' ).modal('show');
      </script> ";
}elseif ($showForgot==true){
    echo "<script>
        $( '#forgotPasswordModal' ).modal('show');
      </script> ";
}

?>
</body>
</html>
