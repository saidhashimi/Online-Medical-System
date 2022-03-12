<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 09-Jul-20
 * Time: 11:17 AM
 */

    require_once ('database-connection.php');
    session_start();

if (!isset($_COOKIE['username'])){
    header("location:index.php?haveaccount");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}

    $wrongPassword=false;
    $wrongConfirmPassword=false;

    $username=$_SESSION['username'];
    $patientDetails=$con->query("select * from users where user_username='$username'")->fetch_array();

    $user_id=$patientDetails['user_id'];

    $patientImage=$con->query("select * from pictures where user_id='$user_id' ")->fetch_array()['file_name'];


$length=true;
$upCase=true;
$lowCase=true;
$num=true;
$speCharacter=true;
$strength=false;
$checkWrong=false;
$checkMatch=false;
$checkStrngth=false;


?>

<?php
    if ((isset($_REQUEST['oldPassword'])) && (isset($_REQUEST['newPassword'])) && (isset($_REQUEST['confirmPassword'])) && (isset($_REQUEST['save']))){

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
                  header("location:patient-change-password.php?changed");
                    return;
            }



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
    <title>Change Password - Patient Dashboard</title>
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
                                    <li class="active">
                                        <a href="patient-change-password.php">
                                            <i class="fas fa-lock"></i>
                                            <span>Change Password</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="patient-delete-account.php">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Delete Account</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="logout.php">
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

                <!--Change Password Tab-->
                <div class="col-md-7 col-lg-8 col-xl-9">

                    <div class="card">
                        <div class="card-body">
                            <h4>Change your password</h4>
                            <div class="row">

                                <div class="col-md-12 col-lg-6">
                                    <!-- Change Password Form -->
                                    <form action="patient-change-password.php" method="post">
                                        <div class="form-group">
                                            <label class="mt-1 ml-2 bg-success-light" style="font-size: 12px;display:<?php if (!isset($_REQUEST['changed'])){ echo "none"; }  ?>;">Password Changed</label>

                                            <input type="password" name="oldPassword" class="form-control <?php if ($wrongPassword==true){ echo "bg-danger-light"; }  ?>" placeholder="Enter Old Password" value="<?php if (isset($_REQUEST['oldPassword'])){echo $_REQUEST['oldPassword']; } ?>" required>
                                            <label class="mt-1 ml-2 bg-danger-light" style="font-size: 12px;display:<?php if ($wrongPassword==false){ echo "none"; }  ?>;">Wrong Old Password</label>
                                        </div>
                                        <div class="form-group">

                                            <input type="password" name="newPassword" class="form-control <?php if (($strength==true) || ($wrongConfirmPassword==true)){echo "bg-danger-light";} ?>" placeholder="Enter New Password" value="<?php if (isset($_REQUEST['newPassword'])){echo $_REQUEST['newPassword']; } ?>" required>

                                        </div>
                                        <div class="form-group">

                                            <input type="password" name="confirmPassword" class="form-control <?php if (($strength==true) || ($wrongConfirmPassword==true)){echo "bg-danger-light";} ?>" placeholder="Confirm Password" value="<?php if (isset($_REQUEST['confirmPassword'])){echo $_REQUEST['confirmPassword']; } ?>" required>
                                            <label class="mt-1 ml-2 bg-danger-light" style="font-size: 12px;display:<?php if ($wrongConfirmPassword==false){ echo "none"; }  ?>;">Password doesn't match</label>

                                            <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($length==false){echo "bg-danger-light";}elseif($length==true){echo "bg-success-light";} ?>">Password should be at least 8 characters in length</small><br>
                                            <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($upCase==false){echo "bg-danger-light";}elseif($upCase==true){echo "bg-success-light";} ?>">Password should include at least one upper case letter</small><br>
                                            <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($num==false){echo "bg-danger-light";}elseif($num==true){echo "bg-success-light";} ?>">Password should include at least one number</small><br>
                                            <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($speCharacter==false){echo "bg-danger-light";}elseif($speCharacter==true){echo "bg-success-light";} ?>">Password should include at least one special character</small><br>

                                        </div>

                                    <!-- /Change Password Form -->
                                </div>

                            </div>
                            <div class="submit-section float-right">
                                <button type="submit" name="save" class="btn btn-primary submit-btn">Save Changes</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--/Change Password Tab-->



            </div>
        </div>
    </div>
    <!--/Page Content-->

</div>
<!--/Main Wrapper-->



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




