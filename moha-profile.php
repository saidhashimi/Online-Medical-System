<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 11-Jul-20
 * Time: 6:48 PM
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


    $mohaDetials=$con->query("select * from users where user_username='$username'")->fetch_array();
    $user_id=$mohaDetials['user_id'];
    $mohaImage=$con->query("select file_name from pictures where user_id='$user_id'")->fetch_array()['file_name'];

$msgSelectCon=false;
$msgN=false;
$msgA=false;
$msgE=false;


    if (isset($_REQUEST['upload'])){
        if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {

            $image_name=$_FILES['image']['name'];

            $file_extension=substr($image_name,strlen($image_name)-3,3);
            $tmp_file_at_server = $_FILES['image']['tmp_name'];

            $file_name_at_server = time();

            $new_file_path = "./assets/img/profiles".'/'.$file_name_at_server.'.'.$file_extension;

            if (is_uploaded_file($tmp_file_at_server)) {
                move_uploaded_file($tmp_file_at_server, $new_file_path);
            }

            $image_name=$file_name_at_server.'.'.$file_extension;

            mysqli_query($con,"delete from pictures where user_id='$user_id'");
            mysqli_query($con,"insert into pictures values ('','$image_name','$user_id')");

            header("location:moha-profile.php?uploaded");
            return;

        }

    }elseif (isset($_REQUEST['save'])){

        $name=$_REQUEST['name'];
        $username=$_REQUEST['username'];
        $contact=$_REQUEST['contact'];



        $chckName=true;
        $chckN=true;
        $chckDigits=true;
        $chckA=true;
        $chckE=true;

        if (!preg_match("/^[a-zA-Z ]*$/",$name)){
            $msgN=true;
            $chckName=false;
        }if (!preg_match('/^[0-9]{10}+$/',$contact)){
            $msgSelectCon=true;
            $chckN=false;
            $chckDigits=false;


        }if ($chckDigits==true){

            $subDigit=substr($contact,0,3);

            if (($subDigit=="078") || ($subDigit=="077") || ($subDigit=="076") || ($subDigit=="079") || ($subDigit=="072") || ($subDigit=="070")){
                $msgSelectCon=false;
                $chckN=true;


            }else{
                $msgSelectCon=true;
                $chckN=false;

            }

        }if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$username)){
            $msgE=true;
            $chckE=false;

        }if (($chckName==true) && ($chckN==true) && ($chckA==true) && ($chckE==true)) {

            if (mysqli_query($con, "update users set user_name='$name',user_username='$username',user_contact='$contact',user_address='$address' where user_id='$user_id'")) {
                $_SESSION['username'] = $username;
                header("location:moha-profile.php?saved");
                return;
            } else {
                header("location:moha-profile.php?notsaved");
                return;
            }
        }
    }



?>

<html>
<head>
    <meta charset="utf-8">
    <title>MOHA-Employee Profile</title>
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
                                <a href="delete-medical.php">Medical Stores Del</a>
                            </li>
                            <li>
                                <a href="delete-medicine.php">Medicine Industry Del</a>
                            </li>
                        </ul>
                    </li>

                    <li class="subMenu4 active">
                        <a href="#viewSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="far fa-eye" style="position: relative; margin-right: 12px;"></i>View Records</a>
                        <ul class="collapse list-unstyled" id="viewSubmenu">
                            <li class="active">
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

                        <a href="moha-profile.html"><i class="fas fa-user-cog" style="position: relative; margin-right: 12px;"></i>Profile Setting</a>
                    </li>
                    <li>

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

    <!--Profile Setting Area-->
    <div class="mohaForms mohaProfile" id="mohaProfileSetting">
        <h4 class="card-title">MOHA-emp Profile <small class="float-right btn btn-sm bg-success-light <?php if (!isset($_REQUEST['saved'])){echo 'd-none';} ?>">Personal Details Saved !</small>
            <small class="float-right btn btn-sm bg-success-light <?php if (!isset($_REQUEST['uploaded'])){echo 'd-none';} ?>">Image Uploaded!</small>
            <small class="float-right btn btn-sm bg-danger-light <?php if (!isset($_REQUEST['notsaved'])){echo 'd-none';} ?>">Personal Details Not Saved !</small>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <form action="moha-profile.php" method="post" enctype="multipart/form-data">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image mt-0">
                            <a href="#">
                                <img class="rounded-circle" alt="User Image" src="assets/img/profiles/<?=$mohaImage?>">
                            </a>
                        </div>
                        <div class="col profile-user-info mt-2">
                            <h4 class="user-name mb-0 ml-4">Mr. <?=$mohaDetials['user_name']?></h4>
                            <h6 class="text-muted ml-4"><?=$mohaDetials['user_username']?></h6>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <div class="change-avatar">
                                        <div class="upload-img">
                                            <div class="change-photo-btn">
                                                <span><i class="fa fa-upload"></i> Upload Photo</span>
                                                <input type="file" name="image"  accept="image/*" class="upload">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto profile-btn">

                            <button class="btn btn-sm bg-success-light" name="upload"><i class="fa fa-upload"></i> Upload</button>
                        </div>

                    </div>
                </div>
                </form>
                <!-- Personal Details -->
                <div class="row personalDetails">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <span>Personal Details</span>
                                    <a class="edit-link" data-toggle="modal" data-target="#edit_personal_details" href="#"><i class="fa fa-edit mr-1"></i>Edit</a>
                                </h5>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Name</p>
                                    <p class="col-sm-10" style="color: black;"><?=$mohaDetials['user_name']?></p>
                                </div>

                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Username</p>
                                    <p class="col-sm-10" style="color: black;"><?=$mohaDetials['user_username']?></p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Mobile</p>
                                    <p class="col-sm-10" style="color: black;"><?=$mohaDetials['user_contact']?></p>
                                </div>

                            </div>
                        </div>



                    </div>


                </div>
                <!-- /Personal Details -->
            </div>
        </div>

    </div>

    <!--/Profile Setting Area-->


</div>

<!--/Main Wrapper-->


<!---------------------------------------->
<!--              MODAL AREA            -->
<!---------------------------------------->


<!-- Edit Details Modal -->

<div class="modal fade mohaProfile" id="edit_personal_details">
    <div class="modal-dialog modal-dialog-centered" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Personal Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="moha-profile.php" method="post">
                    <div class="row form-row">
                        <div class="col-12 col-sm-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?php  if (isset($_REQUEST['save'])){echo $_REQUEST['name'];}else{echo $mohaDetials['user_name'];} ?>" minlength="5">
                                <small class=" text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="email" required name="username" class="form-control" value="<?php if (isset($_REQUEST['save'])){echo $_REQUEST['username'];}else{echo $mohaDetials['user_username']; }?>" readonly>
                                <small class="mt-1 ml-2 bg-danger-light <?php if ($msgE==false){echo 'd-none';} ?>">enter a valid email</small>

                            </div>
                        </div>
                        <div class="col-12 col-sm-12">
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" name="contact" value="<?php if(isset($_REQUEST['save'])){echo $_REQUEST['contact']; }else{echo $mohaDetials['user_contact']; }?>" required class="form-control">
                                <small class="mt-1 ml-2 bg-danger-light <?php if ($msgSelectCon==false){echo 'd-none';} ?>">Enter Valid Phone Number</small>

                            </div>
                        </div>


                    </div>
                    <button type="submit" name="save" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Details Modal -->




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


<?php
if (isset($_REQUEST['save'])){
    echo "<script>
        $( '#edit_personal_details' ).modal('show');
      </script> ";
}
?>
</body>
</html>


