<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 11-Jul-20
 * Time: 11:44 PM
 */

require_once ("database-connection.php");

session_start();
if (!isset($_COOKIE['username'])){
    header("location:login.php");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}

$selectDoctors=$con->query("select * from doctor");
$selectHospitals=$con->query("select * from hospital");
$selectClincs=$con->query("select * from clinics");
$selectMedicals=$con->query("select * from medicals");
$selectMedicines=$con->query("select * from medicineindustry");

$countDoctor=mysqli_num_rows($selectDoctors);
$countHospials=mysqli_num_rows($selectHospitals);
$countClinics=mysqli_num_rows($selectClincs);
$countMedicalStores=mysqli_num_rows($selectMedicals);
$countMedicine=mysqli_num_rows($selectMedicines);

    $username=$_SESSION['username'];
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
        $checkWrong=true;
    }elseif ($newPassword!==$confirmPassword){
        $wrongConfirmPassword=true;
        $checkMatch=true;
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
    }  if (($checkWrong==false) && ($checkMatch==false) && ($checkStrngth==false) && ($wrongPassword==false) && ($wrongConfirmPassword==false) ){
        $newPassword=password_hash($newPassword,PASSWORD_DEFAULT);
        mysqli_query($con,"update users set user_password='$newPassword' where user_username='$username'");
        header("location:moha-change-password.php?changed");
        return;
    }



}





?>

<html>
<head>
    <meta charset="utf-8">
    <title>MOHA-Employee Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <link href="assets/img/favicon.png" rel="icon">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">

    <link rel="stylesheet" href="assets/plugins/dropzone/dropzone.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<!---------------------------------------->
<!--             MAIN WRAPPER           -->
<!---------------------------------------->


<div class="main-wrapper">
    <!--Sidebar-->

    <div class="wrapper1 d-flex align-items-stretch">

        <nav id="sidebar">
            <div class="custom-menu2">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>

            <div class="p-4 pt-5">
                <span>Main</span>
                <ul class="list-unstyled components mb-5">
                    <li>

                        <a href="moha-dashboard.php"><i class="fas fa-columns" style="position: relative; margin-right: 12px;"></i>Dashboard</a>
                    </li>
                    <li class="subMenu2">
                        <a href="#regSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="fas fa-file-medical" style="position: relative; margin-right: 12px;"></i>Registration</a>
                        <ul class="collapse list-unstyled" id="regSubmenu">
                            <li>
                                <a href="doctor-registration.php">Doctor Registration</a>
                            </li>
                            <li>
                                <a href="hospital-registration.php">Hospital Registration</a>
                            </li>
                            <li>
                                <a href="clinic-registration.php">Clinic Registration</a>
                            </li>
                            <li>
                                <a href="medical-registration.php">Medical Stores Reg</a>
                            </li>
                            <li>
                                <a href="medicine-registration.php">Medicine Industry Reg</a>
                            </li>
                        </ul>
                    </li>

                    <li class="subMenu3">
                        <a href="#delSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="fas fa-trash-alt" style="position: relative; margin-right: 12px;"></i>Deletion</a>
                        <ul class="collapse list-unstyled" id="delSubmenu">
                            <li>
                                <a href="delete-doctor.php">Doctor Deletion</a>
                            </li>
                            <li>
                                <a href="delete-hospital.php">Hospital Deletion</a>
                            </li>
                            <li>
                                <a href="delete-clinic.php">Clinic Deletion</a>
                            </li>
                            <li>
                                <a href="delete-medicine.php">Medical Stores Del</a>
                            </li>
                            <li>
                                <a href="delete-medicine.php">Medicine Industry Del</a>
                            </li>
                        </ul>
                    </li>

                    <li class="subMenu4">
                        <a href="#viewSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="far fa-eye" style="position: relative; margin-right: 12px;"></i>View Records</a>
                        <ul class="collapse list-unstyled" id="viewSubmenu">
                            <li>
                                <a href="view-doctor-records.php">Doctor Records</a>
                            </li>
                            <li>
                                <a href="view-hospital-records.php">Hospital Records</a>
                            </li>
                            <li>
                                <a href="view-clinic-records.php">Clinic Records</a>
                            </li>
                            <li>
                                <a href="view-medical-records.php">Medical Stores Rec</a>
                            </li>
                            <li>
                                <a href="view-medicine-records.php">Medicine Industry Rec</a>
                            </li>
                        </ul>
                    </li>

                    <li class="subMenu5">
                        <a href="#updateSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="fas fa-edit" style="position: relative; margin-right: 12px;"></i>Update Records</a>
                        <ul class="collapse list-unstyled" id="updateSubmenu">
                            <li>
                                <a href="update-doctor-records.php">Doctor Records</a>
                            </li>
                            <li>
                                <a href="update-hospital-records.php">Hospital Records</a>
                            </li>
                            <li>
                                <a href="update-clinic-records.php">Clinic Records</a>
                            </li>
                            <li>
                                <a href="update-medical-records.php">Medical Stores Rec</a>
                            </li>
                            <li>
                                <a href="update-medicine-records.php">Medicine Industry Rec</a>
                            </li>
                        </ul>
                    </li>

                    <li>

                        <a href="moha-profile.php"><i class="fas fa-user-cog" style="position: relative; margin-right: 12px;"></i>Profile Setting</a>
                    </li>
                    <li class="active">

                        <a href="moha-change-password.php"><i class="fas fa-lock" style="position: relative; margin-right: 12px;"></i>Change Password</a>
                    </li>
                    <li>

                        <a href="lock-screen.php"><i class="fas fa-user-lock" style="position: relative; margin-right: 12px;"></i>Lock Screen</a>
                    </li>
                    <li>

                        <a href="logout.php?doctor"><i class="fas fa-sign-out-alt" style="position: relative; margin-right: 12px;"></i>Log out</a>
                    </li>
                    <br><br><br><br>

                </ul>

            </div>

        </nav>
    </div>

    <!--/Sidebar-->

    <!--Dashboard Page Content-->
    <div class="mohaPageContent" id="mohaPageContent">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome MOHA-Employee!</h3>
                    <span class="spp">Dashboard</span>
                </div>
            </div>
        </div>
        <!--Counter Area-->
        <div class="row mohaCounter">
            <div class="mohaCounterArea doctorCounterArea" data-toggle="modal" data-target="#clinicUpdateModal">

                <div class="dash-widget-header" >
            <span class="dash-widget-icon text-primary">
                <i class="fas fa-user"></i>
            </span>
                    <div class="dash-count">
                        <h3><?=$countDoctor?></h3>
                    </div>

                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted1">Doctors</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar w-50" style="background-color: green;"></div>
                    </div>
                </div>

            </div>
            <!--Hospital Area-->
            <div class="mohaCounterArea hospitalCounterArea" data-toggle="modal" data-target="#clinicUpdateModal">

                <div class="dash-widget-header">
            <span class="dash-widget-icon" style="border-color: black;">
                <i class="fas fa-hospital" style="color: black;"></i>
            </span>
                    <div class="dash-count">
                        <h3><?=$countHospials?></h3>
                    </div>

                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted1">Hospitals</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar w-50" style="background-color: black;"></div>
                    </div>
                </div>

            </div>
            <!--/Hospital Area-->

            <!--Clinic Area-->
            <div class="mohaCounterArea clinicCounterArea">

                <div class="dash-widget-header">
            <span class="dash-widget-icon" style="border-color: rgb(204, 54, 54);">
                <i class="fas fa-clinic-medical" style="color: rgb(204, 54, 54);"></i>
            </span>
                    <div class="dash-count">
                        <h3><?=$countClinics?></h3>
                    </div>

                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted1">Clinics</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar w-50" style="background-color: rgb(204, 54, 54);"></div>
                    </div>
                </div>

            </div>
            <!--/Clinic Area-->
            <!--Medical Stores Area-->
            <div class="mohaCounterArea medicalCounterArea">

                <div class="dash-widget-header">
            <span class="dash-widget-icon" style="border-color: rgb(198, 211, 21);">
                <i class="fas fa-cannabis" style="color: rgb(198, 211, 21);"></i>
            </span>
                    <div class="dash-count">
                        <h3><?=$countMedicalStores?></h3>
                    </div>

                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted1">Medical Stores</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar w-50" style="background-color: rgb(198, 211, 21);"></div>
                    </div>
                </div>

            </div>
            <!--/Medical Stores Area-->

            <!--Medicine Industry Area-->
            <div class="mohaCounterArea medicineCounterArea">

                <div class="dash-widget-header">
            <span class="dash-widget-icon" style="border-color: rgb(9, 156, 161);">
                <i class="fas fa-capsules" style="color: rgb(9, 156, 161);"></i>
            </span>
                    <div class="dash-count">
                        <h3><?=$countMedicine?></h3>
                    </div>

                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted1">Medicine Industries</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar w-50" style="background-color: rgb(9, 156, 161);"></div>
                    </div>
                </div>

            </div>
            <!--/Medicine Industry Area-->
        </div>

        <!--/Counter Area-->



    </div>
    <!--/Dashboard Page Content-->

    <!--Change Password-->
    <div class="mohaForms" id="mohaChangePassword">
        <h4 class="card-title">Change Password</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12 col-lg-6">
                                <!-- Change Password Form -->
                                <form action="moha-change-password.php" method="post">
                                    <div class="form-group">
                                        <label class="mt-1 ml-2 bg-success-light" style="font-size: 12px;display:<?php if (!isset($_REQUEST['changed'])){ echo "none"; }  ?>;">Password Changed</label>

                                        <input type="password" name="oldPassword" class="form-control" placeholder="Enter Old Password" value="<?php if (isset($_REQUEST['oldPassword'])){echo $_REQUEST['oldPassword']; } ?>" required>
                                        <label class="mt-1 ml-2 bg-danger-light" style="font-size: 12px;display:<?php if ($wrongPassword==false){ echo "none"; }  ?>;">Wrong Old Password</label>
                                    </div>
                                    <div class="form-group">

                                        <input type="password" name="newPassword" class="form-control" placeholder="Enter New Password" value="<?php if (isset($_REQUEST['newPassword'])){echo $_REQUEST['newPassword']; } ?>" required>

                                    </div>
                                    <div class="form-group">

                                        <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password" value="<?php if (isset($_REQUEST['confirmPassword'])){echo $_REQUEST['confirmPassword']; } ?>" required>
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

        </div>

    </div>

    <!--/Change Password-->

</div>
<!--/Main Wrapper-->



<!---------------------------------------->
<!--        EXTERNAL SOURCES            -->
<!---------------------------------------->

<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Sticky Sidebar JS -->
<script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

<!-- Circle Progress JS -->
<script src="assets/js/circle-progress.min.js"></script>

<!-- Dropzone JS -->
<script src="assets/plugins/dropzone/dropzone.min.js"></script>

<!-- Select2 JS -->
<script src="assets/plugins/select2/js/select2.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>
<script src="assets/js/MOHA.js"></script>

<!-- Bootstrap Tagsinput JS -->
<script src="assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>


</body>
</html>
