<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 08-Jul-20
 * Time: 8:03 PM
 */
    require_once ("database-connection.php");
    session_start();
if (!isset($_COOKIE['username'])){
    header("location:index.php?haveaccount");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}
    $patientID=null;
    $patientDetails=null;


    $username=$_SESSION['username'];

    $msgN=false;
    $msgSelectCon=false;
    $msgA=false;

?>

<?php
    $user_id=$con->query("select user_id from users where user_username='$username'")->fetch_array()['user_id'];

    $patientDetails=$con->query("select * from users where user_username='$username'")->fetch_array();
    $patientImage=$con->query("select * from pictures where user_id='$user_id'")->fetch_array()['file_name'];



    if (isset($_REQUEST['save'])){



        if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {

            $image_name=$_FILES['image']['name'];

            $file_extension=substr($image_name,strlen($image_name)-3,3);
            $tmp_file_at_server = $_FILES['image']['tmp_name'];

            $file_name_at_server = time();

            $new_file_path = "./assets/img/patients".'/'.$file_name_at_server.'.'.$file_extension;

            if (is_uploaded_file($tmp_file_at_server)) {
                move_uploaded_file($tmp_file_at_server, $new_file_path);
            }

            $image_name=$file_name_at_server.'.'.$file_extension;

            mysqli_query($con,"delete from pictures where user_id='$user_id'");
            mysqli_query($con,"insert into pictures values ('','$image_name','$user_id')");



        }if ((isset($_REQUEST['name'])) && (isset($_REQUEST['email'])) && (isset($_REQUEST['contact'])) && (isset($_REQUEST['address']))){
            $name=$_REQUEST['name'];

            $contact=$_REQUEST['contact'];
            $address=$_REQUEST['address'];

            $chckN=true;
            $chckCon=true;
            $chckA=true;
            $chckDigits=true;


            if (!preg_match("/^[a-zA-Z ]*$/",$name)){
                $msgN=true;
                $chckN=false;
            }if (!preg_match('/^[0-9]{10}+$/',$contact)){
                $msgSelectCon=true;
                $chckCon=false;
                $chckDigits=false;


            }if ($chckDigits==true){

                $subDigit=substr($contact,0,3);

                if (($subDigit=="078") || ($subDigit=="077") || ($subDigit=="076") || ($subDigit=="079") || ($subDigit=="072") || ($subDigit=="070")){
                    $msgSelectCon=false;
                    $chckCon=true;


                }else{
                    $msgSelectCon=true;
                    $chckCon=false;

                }

            }if ($address=="Select"){
                $msgA=true;
                $chckA=false;
            }if (($chckN==true) && ($chckCon==true) && ($chckA==true)) {


                mysqli_query($con, "update users set user_name='$name',user_address='$address',user_contact='$contact' where user_id='$user_id'");
                header("location:patient-profile-setting.php");
                return;
            }
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
    <title>Patient Dashboard</title>
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
									<img class="rounded-circle" src="assets/img/patients/<?=$patientImage?>" width="31" alt="<?= $patientDetails['user_name'] ?>">
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
                            <a class="dropdown-item" href="index.php">Logout</a>
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
                                        <img src="assets/img/patients/<?=$patientImage?>" alt="User Image">
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

                                        <li class="active">
                                            <a href="patient-profile-setting.php">
                                                <i class="fas fa-user-cog"></i>
                                                <span>Profile Settings</span>
                                            </a>
                                        </li>
                                        <li id="patientPassword">
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
                                            <a href="index.php">
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
                    <!--Profile Setting-->
                    <div class="col-md-7 col-lg-8 col-xl-9">
                        <div class="card">
                            <div class="card-body">

                                <!-- Profile Settings Form -->
                                <form action="patient-profile-setting.php" method="POST" enctype="multipart/form-data">
                                    <div class="row form-row">
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <div class="change-avatar">
                                                    <div class="profile-img">
                                                        <img src="assets/img/patients/<?=$patientImage?>" alt="Patient Image">
                                                    </div>
                                                    <div class="upload-img">
                                                        <div class="change-photo-btn">
                                                            <span><i class="fa fa-upload"></i> Upload Photo</span>
                                                            <input type="file" name="image"  accept="image/*" class="upload">
                                                        </div>
                                                        <small class="form-text text-muted">Select your photo here</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12  col-md-6">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" name="name" value="<?php if (isset($_REQUEST['save'])){echo $_REQUEST['name'];}  else{echo $patientDetails['user_name'];}?>" class="form-control" minlength="5" required>
                                                <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>


                                            </div>
                                        </div>


                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label>Email ID</label>
                                                <input type="email" name="email" value="<?php if (isset($_REQUEST['save'])){echo $_REQUEST['email'];}  else{echo $patientDetails['user_username'];}?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input type="text" name="contact" value="<?php if (isset($_REQUEST['save'])){echo $_REQUEST['contact'];}  else{echo $patientDetails['user_contact'];}?>" class="form-control" required>
                                                <small class="mt-1 ml-2 bg-danger-light <?php if ($msgSelectCon==false){echo 'd-none';} ?>">Enter a Valid Phone Number</small>


                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label>Address</label>

                                                <select name="address" class="form-control select">
                                                    <option <?php if (isset($_REQUEST['save'])){if ($_REQUEST['address']=="Kabul"){echo "selected";}}elseif($patientDetails['user_address']=="Kabul"){echo "selected";} ?>>Kabul</option>
                                                    <option <?php if (isset($_REQUEST['save'])){if ($_REQUEST['address']=="Nangarhar"){echo "selected";}}elseif($patientDetails['user_address']=="Nangarhar"){echo "selected";} ?>>Nangarhar</option>
                                                    <option <?php if (isset($_REQUEST['save'])){if ($_REQUEST['address']=="Konar"){echo "selected";}}elseif($patientDetails['user_address']=="Konar"){echo "selected";} ?>>Konar</option>
                                                    <option <?php if (isset($_REQUEST['save'])){if ($_REQUEST['address']=="Logar"){echo "selected";}}elseif($patientDetails['user_address']=="Logar"){echo "selected";} ?>>Logar</option>
                                                    <option <?php if (isset($_REQUEST['save'])){if ($_REQUEST['address']=="Paktia"){echo "selected";}}elseif($patientDetails['user_address']=="Paktia"){echo "selected";} ?>>Paktia</option>

                                                    <option <?php if (isset($_REQUEST['save'])){if ($_REQUEST['address']=="Khost"){echo "selected";}}elseif($patientDetails['user_address']=="Khost"){echo "selected";} ?>>Khost</option>
                                                    <option <?php if (isset($_REQUEST['save'])){if ($_REQUEST['address']=="Ghazni"){echo "selected";}}elseif($patientDetails['user_address']=="Ghazni"){echo "selected";} ?>>Ghazni</option>
                                                    <option <?php if (isset($_REQUEST['save'])){if ($_REQUEST['address']=="Balkh"){echo "selected";}}elseif($patientDetails['user_address']=="Balkh"){echo "selected";} ?>>Balkh</option>
                                                    <option <?php if (isset($_REQUEST['save'])){if ($_REQUEST['address']=="Herat"){echo "selected";}}elseif($patientDetails['user_address']=="Herat"){echo "selected";} ?>>Herat</option>
                                                    <option <?php if (isset($_REQUEST['save'])){if ($_REQUEST['address']=="Laghman"){echo "selected";}}elseif($patientDetails['user_address']=="Laghman"){echo "selected";} ?>>Laghman</option>





                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="float-right">
                                        <button type="submit" name="save" class="btn btn-primary submit-btn">Save Changes</button>
                                    </div>
                                </form>
                                <!-- /Profile Settings Form -->

                            </div>

                        </div>

                    </div>


                    <!--/Profile Setting-->



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

