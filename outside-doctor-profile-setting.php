<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 17-May-20
 * Time: 3:51 PM
 */

require_once ("database-connection.php");
session_start();
/*   Doctor Information       */
$doctorRecordRow=null;
$pro_des=null;
$doc_id=null;
$profileSettingSuccess=false;
$doc_clinics=null;
$doc_education=null;
$doc_experience=null;
$doc_image=null;
$msgBiography=false;
$msgAdressLine=false;
$msgSelectP=false;
$msgServices=false;
$msgSpecialization=false;

$failMessage=false;







if (!isset($_COOKIE['username'])){
    header("location:login.php");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}if (isset($_SESSION['username'])){


    $username=$_SESSION['username'];

    $counterDoo=mysqli_num_rows($con->query("select * from outsidedoctor where email='$username'"));
    $contactDetails=true;

    if ($counterDoo>0){
        $contactDetails=false;
    }

    $doctorRecord=$con->query("select * from users where user_username='$username'");


    $doctorRecordRow=$doctorRecord->fetch_array();


    $doctorRecord=$con->query("select * from outsidedoctor where email='$username'");
    $u_id=$con->query("select user_id from users where user_username='$username'")->fetch_array()['user_id'];
    $pro_des=$con->query("select * from doctorprofile where user_id='$u_id'")->fetch_array();
    $proID=$pro_des['profile_id'];
    $doc_clinics=$con->query("select * from doctorclinics where profile_id='$proID'");
    $doc_education=$con->query("select * from doctoreducation where profile_id='$proID'");
    $doc_experience=$con->query("select * from doctorexpierence where profile_id='$proID'");
    $doc_image=$con->query("select * from pictures where user_id='$u_id'")->fetch_array()['file_name'];




    $doctorRecordRow=$doctorRecord->fetch_array();



}
if (isset($_REQUEST['upload'])){
    $username=$_SESSION['username'];
    $u_id=$con->query("select user_id from users where user_username='$username'")->fetch_array()['user_id'];


    $image_name=$_FILES['doc_image']['name'];
    $target_dir="./assets/img/doctors/";

    $file_extension=substr($image_name,strlen($image_name)-3,3);
    $tmp_file_at_server = $_FILES['doc_image']['tmp_name'];

    $file_name_at_server = time();

    $new_file_path = "./assets/img/doctors".'/'.$file_name_at_server.'.'.$file_extension;
    if (is_uploaded_file($tmp_file_at_server)) {
        move_uploaded_file($tmp_file_at_server, $new_file_path);

    }
    $image=$file_name_at_server.'.'.$file_extension;

    $selectImage=$con->query("select file_name from pictures where user_id='$u_id'")->fetch_array()['file_name'];


    mysqli_query($con,"delete from pictures where user_id='$u_id'");


    mysqli_query($con,"insert into pictures values ('','$image','$u_id')");


    header("location:outside-doctor-profile-setting.php?uploaded");
    return;





}
?>


<?php
if (isset($_REQUEST['save'])){
    $biography=$_REQUEST['biography'];
    $clinicName=$_REQUEST['clinicName'];
    $clinicAddress=$_REQUEST['clinicAddress'];
    $addressLine=$_REQUEST['addressLine'];
    $city=$_REQUEST['city'];
    $province=$_REQUEST['province'];
    $fees=$_REQUEST['fees'];
    $services=$_REQUEST['services'];
    $specializations=$_REQUEST['specializations'];

    $degree1=$_REQUEST['degree1'];
    $degree2=$_REQUEST['degree2'];
    $degree3=$_REQUEST['degree3'];
    $degree4=$_REQUEST['degree4'];

    $college1=$_REQUEST['college1'];
    $college2=$_REQUEST['college2'];
    $college3=$_REQUEST['college3'];
    $college4=$_REQUEST['college4'];

    $year1=$_REQUEST['yearofcompletion1'];
    $year2=$_REQUEST['yearofcompletion2'];
    $year3=$_REQUEST['yearofcompletion3'];
    $year4=$_REQUEST['yearofcompletion4'];

    $username=$_SESSION['username'];
    $profile_id=$pro_des['profile_id'];
    $user_id=$pro_des['user_id'];

    $selectDoctorProfile=$con->query("select * from doctorprofile where profile_id='$profile_id'");
    $counterRecord=mysqli_num_rows($selectDoctorProfile);


    if ($counterRecord==0){
        mysqli_query($con,"insert into doctorprofile values ('','$biography','$addressLine','$city','$province','$fees','$services','$specializations','$user_id')");
        header("location:outside-doctor-profile-setting.php");
        return;
    }else{

        mysqli_query($con,"update doctorprofile set profile_biography='$biography',contact='$addressLine',profile_city='$city',profile_province='$province',profile_fees='$fees',profile_services='$services',profile_specilizations='$specializations',user_id='$user_id' where profile_id='$profile_id'");


        header("location:outside-doctor-profile-setting.php");
        return;

    }


}elseif ((isset($_REQUEST['saveme']))){

    $biography=$_REQUEST['biography'];


    $addressLine=$_REQUEST['addressLine'];
    $city=$_REQUEST['city'];
    $province=$_REQUEST['province'];
    $block=$_REQUEST['block'];

    $location=$block.",".$city.",".$province;




    $fees=$_REQUEST['fees'];
    $services=$_REQUEST['services'];
    $specializations=$_REQUEST['specializations'];

    $username=$_SESSION['username'];
    $profile_id=$pro_des['profile_id'];
    $user_id=$con->query("select user_id from users where user_username='$username'")->fetch_array()['user_id'];


    $selectDoctorProfile=$con->query("select * from doctorprofile where profile_id='$profile_id'");
    $counterRecord=mysqli_num_rows($selectDoctorProfile);

    $chckBiography=true;
    $chckAddressLine=true;
    $chckP=true;
    $chckServices=true;
    $chckSpecialization=true;
    $chckDigits=true;



    if (strlen($biography)<300){
        $msgBiography=true;
        $chckBiography=false;
        $failMessage=true;
    }if (!preg_match('/^[0-9]{14}+$/',$addressLine)){
        $msgAdressLine=true;
        $chckAddressLine=false;
        $failMessage=true;
        $chckDigits=false;

    }if ($chckDigits==true){

        $subDigit=substr($addressLine,0,4);
        $other=substr($addressLine,4,7);

        if ($subDigit=="0092"){
            $msgAdressLine=false;
            $chckAddressLine=true;

        }else{
            $msgAdressLine=true;
            $chckAddressLine=false;
        }

    }if ($province=="Select"){
        $msgSelectP=true;
        $chckP=false;

    }if($services!=null){
        $list=explode(",",$services);

        for ($i=0;$i<sizeof($list);$i++){
            if ((!preg_match("/^[a-zA-Z ]*$/",$list[$i])) || (strlen($list[$i])<3)){
                $msgServices=true;
                $chckServices=false;
            }
        }

    }if($specializations!=null){
        $list=explode(",",$specializations);

        for ($i=0;$i<sizeof($list);$i++){
            if ((!preg_match("/^[a-zA-Z ]*$/",$list[$i])) || (strlen($list[$i])<3)){
                $msgSpecialization=true;
                $chckSpecialization=false;
            }
        }

    }if (($chckBiography==true) && ($chckAddressLine==true) && ($chckP==true) && ($chckServices==true) && ($chckSpecialization==true)) {
        $selectDoctorProfile=$con->query("select * from doctorprofile where profile_id='$profile_id'");
        $counterRecord=mysqli_num_rows($selectDoctorProfile);
        if ($counterRecord ==0) {

            mysqli_query($con,"update outsidedoctor set contact='$addressLine',location='$location' where email='$username'");
            mysqli_query($con, "insert into doctorprofile values ('','$biography','$addressLine',null ,null ,'$fees','$services','$specializations','$user_id')");
            header("location:outside-doctor-profile-setting.php?success");
            return;
        } else {
            mysqli_query($con,"update outsidedoctor set contact='$addressLine',location='$location' where email='$username'");
            mysqli_query($con, "update doctorprofile set profile_biography='$biography',contact='$addressLine',profile_city=null ,profile_province=null ,profile_fees='$fees',profile_services='$services',profile_specilizations='$specializations',user_id='$user_id' where profile_id='$profile_id'");
            header("location:outside-doctor-profile-setting.php?success");
            return;
        }
    }

}elseif (isset($_REQUEST['saveclinicdetails'])){

    if (isset($_REQUEST['firstClinic'])){
        $clinicName=$_REQUEST['cliName'];
        $clinicAddress=$_REQUEST['cliAddress'];

        $profile_id=$pro_des['profile_id'];

        $con->query("insert into doctorclinics values ('','$clinicName','$clinicAddress','$profile_id')");

    }

    if (isset($_REQUEST['clinicID'][0])){
        $docClinicId=$_REQUEST['clinicID'][0];
        $clinicName=$_REQUEST['clinicName'][0];
        $clinicAddress=$_REQUEST['clinicAddress'][0];
        $profileID=$_REQUEST['profileID'];

        $clinicRow=$con->query("select * from doctorclinics where doc_clinic_id='$docClinicId'");
        $counterClinicRecord=mysqli_num_rows($clinicRow);

        if ($counterClinicRecord==0){
            mysqli_query($con,"insert into doctorclinics values ('','$docClinicId','$clinicName','$clinicAddress','$profileID')");

        }else{
            mysqli_query($con,"update doctorclinics set clinic_name='$clinicName',clinic_address='$clinicAddress' where doc_clinic_id='$docClinicId'");

        }
    }
    if (isset($_REQUEST['clinicID'][1])){
        $docClinicId=$_REQUEST['clinicID'][1];
        $clinicName=$_REQUEST['clinicName'][1];
        $clinicAddress=$_REQUEST['clinicAddress'][1];
        $profileID=$_REQUEST['profileID'];

        $clinicRow=$con->query("select * from doctorclinics where doc_clinic_id='$docClinicId'");
        $counterClinicRecord=mysqli_num_rows($clinicRow);

        if ($counterClinicRecord==0){
            mysqli_query($con,"insert into doctorclinics values ('','$docClinicId','$clinicName','$clinicAddress','$profileID')");

        }else{
            mysqli_query($con,"update doctorclinics set clinic_name='$clinicName',clinic_address='$clinicAddress' where doc_clinic_id='$docClinicId'");

        }
    }
    if (isset($_REQUEST['clinicID'][2])){
        $docClinicId=$_REQUEST['clinicID'][2];
        $clinicName=$_REQUEST['clinicName'][2];
        $clinicAddress=$_REQUEST['clinicAddress'][2];
        $profileID=$_REQUEST['profileID'];

        $clinicRow=$con->query("select * from doctorclinics where doc_clinic_id='$docClinicId'");
        $counterClinicRecord=mysqli_num_rows($clinicRow);

        if ($counterClinicRecord==0){
            mysqli_query($con,"insert into doctorclinics values ('','$docClinicId','$clinicName','$clinicAddress','$profileID')");

        }else{
            mysqli_query($con,"update doctorclinics set clinic_name='$clinicName',clinic_address='$clinicAddress' where doc_clinic_id='$docClinicId'");

        }
    }
    if (isset($_REQUEST['clinicID'][3])){
        $docClinicId=$_REQUEST['clinicID'][3];
        $clinicName=$_REQUEST['clinicName'][3];
        $clinicAddress=$_REQUEST['clinicAddress'][3];
        $profileID=$_REQUEST['profileID'];

        $clinicRow=$con->query("select * from doctorclinics where doc_clinic_id='$docClinicId'");
        $counterClinicRecord=mysqli_num_rows($clinicRow);

        if ($counterClinicRecord==0){
            mysqli_query($con,"insert into doctorclinics values ('','$docClinicId','$clinicName','$clinicAddress','$profileID')");

        }else{
            mysqli_query($con,"update doctorclinics set clinic_name='$clinicName',clinic_address='$clinicAddress' where doc_clinic_id='$docClinicId'");

        }
    }
    if (isset($_REQUEST['newclinic'])){
        $profileID=$_REQUEST['profileID'];

        $clinicNames=$_REQUEST['newclinicName'];
        $clinicAddress=$_REQUEST['newclinicAddress'];

        for($i=0;$i<sizeof($clinicNames);$i++){
            mysqli_query($con,"insert into doctorclinics values ('','$clinicNames[$i]','$clinicAddress[$i]','$profileID')");
        }


    }


    header("location:outside-doctor-profile-setting.php?success");
    return;

}elseif (isset($_REQUEST['savedoceducation'])){
    $profile_id=$pro_des['profile_id'];

    if (isset($_REQUEST['newEducation'])){
        $degree=$_REQUEST['docDegree'];
        $college=$_REQUEST['docCollege'];
        $completion=$_REQUEST['docCompletion'];
        $profile_id=$pro_des['profile_id'];

        $con->query("insert into doctoreducation values ('','$degree','$college','$completion','$profile_id')");

    }
    if (isset($_REQUEST['edu_id'])){

        $edu_id=$_REQUEST['edu_id'];
        $docDegree=$_REQUEST['doctorDegree'];
        $docCollege=$_REQUEST['doctorCollege'];
        $docCompletion=$_REQUEST['doctorCompletion'];


        for ($i=0;$i<sizeof($edu_id);$i++){
            $doc_edu_id=$edu_id[$i];
            $degree=$docDegree[$i];
            $college=$docCollege[$i];
            $completion=$docCompletion[$i];

            $con->query("update doctoreducation set degree='$degree',college='$college',yearofcompletion='$completion' where doc_edu_id='$doc_edu_id'");

        }
    }
    if (isset($_REQUEST['addNewDegrees'])){

        $degree=$_REQUEST['degree'];
        $college=$_REQUEST['college'];
        $completion=$_REQUEST['completion'];

        for($i=0;$i<sizeof($degree);$i++){
            mysqli_query($con,"insert into doctoreducation values ('','$degree[$i]','$college[$i]','$completion[$i]','$profile_id')");
        }





    }


    header("location:outside-doctor-profile-setting.php?success");
    return;
}elseif (isset($_REQUEST['savedocexperience'])){
    $profile_id=$pro_des['profile_id'];
    if (isset($_REQUEST['firstExperience'])){
        $hosName=$_REQUEST['hosName'];
        $startDate=$_REQUEST['startDate'];
        $endDate=$_REQUEST['endDate'];


        $con->query("insert into doctorexpierence values ('','$hosName','$startDate','$endDate','$profile_id')");




    }
    if (isset($_REQUEST['exp_id'])){

        $exp_id=$_REQUEST['exp_id'];
        $hospitalName=$_REQUEST['hospital'];
        $start=$_REQUEST['start'];
        $end=$_REQUEST['end'];


        for ($i=0;$i<sizeof($exp_id);$i++){
            $doc_exp_id=$exp_id[$i];
            $name=$hospitalName[$i];
            $startDate=$start[$i];
            $endDate=$end[$i];

            $con->query("update doctorexpierence set hospitalName='$name',startFrom='$startDate',endDate='$endDate' where doc_exp_id='$doc_exp_id'");

        }
    }
    if (isset($_REQUEST['addNewExpierence'])){
        $hosName=$_REQUEST['hospitalName'];
        $startDate=$_REQUEST['docStart'];
        $endDate=$_REQUEST['docEnd'];

        for($i=0;$i<sizeof($hosName);$i++){
            $con->query("insert into doctorexpierence values ('','$hosName[$i]','$startDate[$i]','$endDate[$i]','$profile_id')");
        }

    }

    header("outside-location:doctor-profile-setting.php?success");
    return;
}


/*
 * Messages Counter
 */
$doc_user_id=$con->query("select user_id from users where user_username='$username'")->fetch_array()['user_id'];
$counterMessages=$con->query("select * from chat_message where to_user_id='$doc_user_id' and status='not seen'");
$counter=mysqli_num_rows($counterMessages);



?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Doctor Profile Setting - Health Guide</title>

    <link href="assets/img/favicon.png" rel="icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">




    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<!-- Main Wrapper -->
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
									<img class="rounded-circle" src="assets/img/doctors/<?=$doc_image?>" width="31" alt="image">
								</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="assets/img/doctors/<?=$doc_image?>" alt="User Image" class="avatar-img rounded-circle">
                            </div>
                            <div class="user-text">
                                <h6><?php echo $doctorRecordRow['firstname'];  ?></h6>
                                <p class="text-muted mb-0">Doctor</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="outside-doctor-dashboard.php">Dashboard</a>
                        <a class="dropdown-item" href="outside-doctor-profile-setting.php">Profile Settings</a>
                        <a class="dropdown-item" href="logout.php?doctor">Logout</a>
                    </div>
                </li>
                <!-- /User Menu -->

            </ul>
        </nav>


    </header>
    <!--/Header-->


    <!---Page Content-->
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    <!-- Dashboard Sidebar -->
                    <div class="profile-sidebar">
                        <div class="widget-profile pro-widget-content">
                            <div class="profile-info-widget">
                                <a href="#" class="booking-doc-img">
                                    <img src="assets/img/doctors/<?=$doc_image?>" alt="Doctor Image">
                                </a>
                                <div class="profile-det-info">
                                    <h3>Dr. <?php echo $doctorRecordRow['firstname']." ".$doctorRecordRow['lastname']; ?> </h3>

                                    <div class="patient-details">
                                        <h5 class="mb-0"><?php
                                            echo $doctorRecordRow['specialization'];
                                            ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-widget">
                            <nav class="dashboard-menu">
                                <ul>
                                    <li id="dashTab">
                                        <a href="outside-doctor-dashboard.php">
                                            <i class="fas fa-columns"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li >
                                        <a href="outside-doctor-appointments.php">
                                            <i class="fas fa-calendar-check"></i>
                                            <span>Appointments</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-doctor-patients.php">
                                            <i class="fas fa-user-injured"></i>
                                            <span>My Patients</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-schedule-timings.php">
                                            <i class="fas fa-hourglass-start"></i>
                                            <span>Schedule Timings</span>
                                        </a>
                                    </li>

                                    <li id="profile" class="active">
                                        <a class="active" href="outside-doctor-profile-setting.php">
                                            <i class="fas fa-user-cog"></i>
                                            <span>Profile Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-doctor-chats.php">
                                            <i class="fas fa-comments"></i>
                                            <span>Message</span>
                                            <small class="unread-msg"><?=$counter?></small>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-doctor-change-password.php">
                                            <i class="fas fa-lock"></i>
                                            <span>Change Password</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="outside-delete-doctor-account.php">
                                            <i class="fas fa-trash"></i>
                                            <span>Delete Account</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="logout.php?doctor">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- /Dashboard Sidebar -->

                <!---Profile Setting-->
                <div class="col-md-7 col-lg-8 col-xl-9">

                    <div class="row" id="">
                        <div class="col-md-12">
                            <!-- Basic Information -->
                            <div class="card">
                                <form action="outside-doctor-profile-setting.php" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <h4 class="card-title">Basic Information<small class="btn btn-sm bg-danger-light float-right <?php if ($failMessage==false){echo "d-none"; }?> ">Your profile setting has been not saved, go down to see the causes</small><small class="btn btn-sm bg-success-light float-right <?php if (!isset($_REQUEST['success'])){echo "d-none"; }?> ">Your profile setting updated successfully</small>
                                            <small class="btn btn-sm bg-success-light float-right <?php if (!isset($_REQUEST['uploaded'])){echo "d-none"; }?> ">Your picture has been uploaded successfully</small>
                                        </h4>
                                        <div class="row form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="change-avatar">
                                                        <div class="profile-img">
                                                            <img src="assets/img/doctors/<?=$doc_image?>" alt="Doctor Image">
                                                        </div>
                                                        <div class="upload-img">
                                                            <div class="change-photo-btn">
                                                                <span><i class="fa fa-upload"></i> Upload Photo</span>
                                                                <input  type="file" accept="image/*" class="upload" name="doc_image">
                                                            </div>
                                                            <small class="form-text text-muted">Select your photo</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>First Name </label>
                                                    <input type="text" value="<?php echo $doctorRecordRow['firstname']; ?> " class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Last Name </label>
                                                    <input type="text" value="<?php echo $doctorRecordRow['lastname']; ?> " class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Specialization </label>
                                                    <input type="text" value="<?php echo $doctorRecordRow['specialization']; ?> " class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Country </label>
                                                    <input type="text" value="<?php echo $doctorRecordRow['country']; ?> " class="form-control" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Location</label>
                                                    <input type="text" value="<?php echo $doctorRecordRow['location']; ?> " class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email / Username</label>
                                                    <input type="text" value="<?php echo $doctorRecordRow['email']; ?> " class="form-control" readonly>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Contact</label>
                                                    <input type="text" name="contact" value="<?php  echo $doctorRecordRow['contact']; ?> " class="form-control" readonly>

                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select class="form-control" readonly>
                                                        <option >Select</option>
                                                        <option <?php if ($doctorRecordRow['gender']=='Male'){ echo "selected"; }  ?> >Male</option>
                                                        <option <?php if ($doctorRecordRow['gender']=='Female'){ echo "selected"; }  ?> >Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mt-2 float-md-right float-sm-left">
                                            <button cla type="submit" name="upload"  class="btn btn-primary submit-btn">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /Basic Information -->

                            <!-- About Me -->
                            <div class="card">
                                <form action="outside-doctor-profile-setting.php" method="get">
                                    <div class="card-body">
                                        <h4 class="card-title">About Me</h4>
                                        <div class="form-group mb-0">
                                            <label>Biography</label>
                                            <textarea class="form-control" name="biography" rows="7"><?php if (isset($_REQUEST['saveme'])){echo $_REQUEST['biography'];}else{echo $pro_des['profile_biography'];} ?></textarea>
                                            <div class="d-flex justify-content-between mt-1 ml-2"><small class="text-muted"><span>Your biography must have more than 300 characters</span> </small></div>
                                            <small class="mt-1 ml-2 bg-danger-light <?php if ($msgBiography==false){echo 'd-none';} ?>">Type more then 300 characters</small>



                                        </div>
                                        <div class="border-top mt-3"></div>

                                        <div class="mt-4">
                                            <!-- Cotact Details   -->
                                            <h4 class="card-title">Contact Details</h4>
                                            <div class="row form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Contact </label>

                                                        <input type="text" class="form-control" name="addressLine"
                                                               value="<?php if (isset($_REQUEST['saveme'])) {
                                                                   echo $_REQUEST['addressLine'];
                                                               } else {
                                                                   echo $doctorRecordRow['contact'];
                                                               } ?>" required>
                                                        <small class="mt-1 ml-2 bg-danger-light <?php if ($msgAdressLine == false) {
                                                            echo 'd-none';
                                                        } ?>">Enter Valid Contact Number
                                                        </small>


                                                    </div>
                                                </div>


                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">Clinic Location</label>
                                                        <?php
                                                        $location=$doctorRecordRow['location'];
                                                        $list=explode(",",$location);

                                                        ?>
                                                        <select class="form-control select" name="province"
                                                                id="province">

                                                            <option <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['province'] == "Peshawar") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[2]=="Peshawar"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Peshawar
                                                            </option>


                                                        </select>
                                                        <small>Country</small>


                                                    </div>
                                                </div>


                                                <div class="col-md-2" style="margin-top: 30px">
                                                    <div class="form-group">


                                                        <select class="form-control select" name="city">
                                                            <option  <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['province'] == "Hayatabad") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[1]=="Hayatabad"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Hayatabad
                                                            </option>
                                                            <option  <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['city'] == "Dabgar e garden") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[1]=="Dabgar e garden"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Dabgar e garden
                                                            </option>
                                                            <option  <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['city'] == "Ring Road") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[1]=="Ring Road"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Ring Road
                                                            </option>
                                                            <option  <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['city'] == "Abdara Road") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[1]=="Abdara Road"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Abdara Road
                                                            </option>
                                                        </select>
                                                        <small>City</small>


                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="margin-top: 30px">
                                                    <div class="form-group">
                                                        <select class="form-control select" name="block"
                                                        >

                                                            <option <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['block'] == "Phase 1") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[0]=="Phase 1"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Phase 1
                                                            </option>
                                                            <option <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['block'] == "Phase 2") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[0]=="Phase 2"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Phase 2
                                                            </option>
                                                            <option <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['block'] == "Phase 3") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[0]=="Phase 3"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Phase 3
                                                            </option>

                                                            <option <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['block'] == "Phase 4") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[0]=="Phase 4"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Phase 4
                                                            </option>
                                                            <option <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['block'] == "Phase 5") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[0]=="Phase 5"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Phase 5
                                                            </option>
                                                            <option <?php if (isset($_REQUEST['saveme'])) {
                                                                if ($_REQUEST['block'] == "Phase 6") {
                                                                    echo "selected";
                                                                }
                                                            } elseif (!isset($_REQUEST['saveme'])) {
                                                                if ($list[0]=="Phase 6"){
                                                                    echo "selected";}
                                                            }
                                                            ?>>Phase 6
                                                            </option>

                                                        </select>
                                                        <small>Phase</small>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>


                                        <!-- /Cotact Details   -->
                                        <div class="border-top mt-3"></div>
                                        <!--- Pricing  --->
                                        <div class="mt-4">
                                            <h4 class="card-title">Fees</h4>

                                            <div class="form-group mb-0">
                                                <div id="pricing_select">

                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="price_custom" name="rating_option" value="custom_price" class="custom-control-input">
                                                        <label class="custom-control-label" for="price_custom">Adding Fees</label>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row custom_price_cont" id="custom_price_cont" style="display: none;">
                                                <div class="col-md-4">
                                                    <input type="number" class="form-control" id="custom_rating_input" value="<?php if (isset($_REQUEST['saveme'])){echo $_REQUEST['fees']; }else{ echo $pro_des['profile_fees'];} ?>" min="500" max="5000" name="fees" required>
                                                    <small class="form-text text-muted">Enter your fees amount in <?php if ($contactDetails==true){echo "AFG";}else{echo "PKR";} ?></small>
                                                </div>
                                            </div>

                                        </div>

                                        <!--- /Pricing --->
                                        <div class="border-top mt-3"></div>
                                        <!--- Services and Specialization ---->
                                        <div class="mt-4">
                                            <h4 class="card-title">Services and Specialization</h4>
                                            <div class="form-group">
                                                <label>Services</label>
                                                <input type="text" data-role="tagsinput" class="input-tags form-control" value="<?php if (isset($_REQUEST['saveme'])){echo $_REQUEST['services']; }else{ echo $pro_des['profile_services']; }?>" minlength="3" maxlength="50" placeholder="Enter Services" name="services">
                                                <small class="form-text text-muted">Type & Press enter to add new services (no minimum 3 characters)</small>
                                                <small class="mt-1 ml-2 bg-danger-light <?php if ($msgServices==false){echo 'd-none';} ?>">Only letters, white spaces and no minimum 3 characters</small>


                                            </div>
                                            <div class="form-group mb-0">
                                                <label>Specialization </label>
                                                <input class="input-tags form-control" type="text" data-role="tagsinput" placeholder="Enter Specialization" value="<?php if (isset($_REQUEST['saveme'])){echo $_REQUEST['specializations']; } else{echo $pro_des['profile_specilizations'];} ?>" name="specializations"  id="specialist">
                                                <small class="form-text text-muted">Type & Press  enter to add new specialization (no minimum 3 characters)</small>
                                                <small class="mt-1 ml-2 bg-danger-light <?php if ($msgSpecialization==false){echo 'd-none';} ?>">Only letters, white spaces and no minimum 3 characters</small>

                                            </div>
                                        </div>

                                        <!--- /Services and Specializations --->
                                        <div class="mt-2 float-md-right float-sm-left">
                                            <button cla type="submit" name="saveme"  class="btn btn-primary submit-btn">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /About Me -->


                            <!-- Clinic Info -->

                            <div class="card">
                                <form action="outside-doctor-profile-setting.php" method="get">
                                    <div class="card-body">
                                        <h4 class="card-title">Clinic Details</h4>

                                        <div class="clinic-info">
                                            <?php
                                            while($row=$doc_clinics->fetch_array()) {

                                                ?>
                                                <div class="row form-row clinic-cont">
                                                    <div class="col-12 col-md-10 col-lg-11">

                                                        <div class="row form-row">
                                                            <div class="col-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Clinic Name</label>
                                                                    <input type="hidden" name="clinicID[]" value="<?=$row['doc_clinic_id'] ?>">
                                                                    <input type="text" name="clinicName[]"
                                                                           value="<?=$row['clinic_name']?>"     class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Clinic Address</label>
                                                                    <input type="text" name="clinicAddress[]"
                                                                           value="<?=$row['clinic_address']?>"   class="form-control">
                                                                    <input type="hidden" name="profileID" value="<?=$row['profile_id']?>">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>


                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="add-more">
                                            <small class="form-text text-muted d-none mb-1 cliCounter">Sorry, you are not allowed to enter more than four clinic details</small>
                                            <a href="" class="add-clinic"><i class="fa fa-plus-circle"></i> Add More</a>


                                        </div>
                                        <div class="mt-2 float-md-right float-sm-left">
                                            <button cla type="submit" name="saveclinicdetails"  class="btn btn-primary submit-btn">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- /Clinic Info -->


                            <!-- Education -->
                            <div class="card">
                                <form action="outside-doctor-profile-setting.php" method="get">
                                    <div class="card-body">
                                        <h4 class="card-title">Education</h4>
                                        <div class="education-info">
                                            <?php
                                            while($row=$doc_education->fetch_array()) {

                                                ?>

                                                <div class="row form-row education-cont">
                                                    <div class="col-12 col-md-10 col-lg-11">
                                                        <div class="row form-row">
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Degree</label>
                                                                    <input type="hidden" name="edu_id[]" value="<?=$row['doc_edu_id']?>">
                                                                    <input type="text" name="doctorDegree[]" value="<?=$row['degree']?>" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <div class="form-group">
                                                                    <label>College/Institute</label>
                                                                    <input type="text" name="doctorCollege[]" value="<?=$row['college']?>" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Year of Completion</label>
                                                                    <input type="number" name="doctorCompletion[]"
                                                                           value="<?=$row['yearofcompletion']?>"      class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="add-more">
                                            <small class="form-text text-muted d-none mb-1 eduCounter">Sorry, you are not allowed to enter more than four degrees</small>
                                            <a href="" class="add-education"><i class="fa fa-plus-circle"></i> Add More</a>
                                        </div>
                                        <div class="mt-2 float-md-right float-sm-left">
                                            <button  type="submit" name="savedoceducation"  class="btn btn-primary submit-btn">Save Changes</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <!-- /Education -->

                            <!-- Experience -->
                            <div class="card">
                                <form action="outside-doctor-profile-setting.php" method="get">
                                    <div class="card-body">
                                        <h4 class="card-title">Experience</h4>
                                        <div class="experience-info">
                                            <?php
                                            while($row=$doc_experience->fetch_array()) {


                                                ?>
                                                <div class="row form-row experience-cont">
                                                    <div class="col-12 col-md-10 col-lg-11">
                                                        <div class="row form-row">
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Hospital Name</label>
                                                                    <input type="hidden" name="exp_id[]" value="<?=$row['doc_exp_id']?>">
                                                                    <input type="text" name="hospital[]"
                                                                           value="<?=$row['hospitalName']?>"  class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <div class="form-group">
                                                                    <label>From</label>
                                                                    <input type="date" name="start[]"  value="<?=$row['startFrom']?>" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <div class="form-group">
                                                                    <label>To</label>
                                                                    <input type="date"  value="<?=$row['endDate']?>" name="end[]" class="form-control">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>

                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="add-more">
                                            <small class="form-text text-muted d-none mb-1 hosCounter">Sorry, you are not allowed to enter more than three experience skills</small>
                                            <a href="#" class="add-experience"><i class="fa fa-plus-circle"></i> Add More</a>
                                        </div>
                                        <div class="mt-2 float-md-right float-sm-left">
                                            <button  type="submit" name="savedocexperience"  class="btn btn-primary submit-btn">Save Changes</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <!-- /Experience -->


                        </div>
                    </div>

                </div>
                <!--/Profile Setting-->


            </div>
        </div>
    </div>






</div>
<!-- /Main Wrapper -->

<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>





<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>

<!-- Bootstrap Tagsinput JS -->
<script src="assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>

<!-- Profile Settings JS -->
<script src="assets/js/profile-setting.js"></script>

<script type="text/javascript">
    $(document).ready(function () {


        $("#province").change(function () {
            var val = $(this).val();
            if (val == "Kabul") {
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Bagrami') {echo 'selected';}} ?>>Bagrami</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Chahar Asyab') {
                        echo 'selected';
                    }
                } ?>>Chahar Asyab</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Deh Sabz') {
                        echo 'selected';
                    }
                } ?>>Deh Sabz</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Guldara') {
                        echo 'selected';
                    }
                } ?>>Guldara</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Istalif') {
                        echo 'selected';
                    }
                } ?>>Istalif</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'kalakan') {
                        echo 'selected';
                    }
                } ?>>Kalakan</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Kabul') {
                        echo 'selected';
                    }
                } ?>>Kabul</option> ");


            }if (val=="Nangarhar"){
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Achin') {echo 'selected';}} ?>>Achin</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Batikot') {
                        echo 'selected';
                    }
                } ?>>Batikot</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Behsood') {
                        echo 'selected';
                    }
                } ?>>Behsood</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Chaparhar') {
                        echo 'selected';
                    }
                } ?>>Chaparhar</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Dahbala') {
                        echo 'selected';
                    }
                } ?>>Dahbala</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Dara Noor') {
                        echo 'selected';
                    }
                } ?>>Dara Noor</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Jalalabad') {echo 'selected';}} ?>>Jalalabad</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'kama') {echo 'selected';}} ?>>kama</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Lalpoor') {echo 'selected';}} ?>>Lalpoor</option>   ");
            }if (val=="Laghman") {
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Dawlat Shah') {echo 'selected';}} ?>>Dawlat Shah</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Mihtarlam') {
                        echo 'selected';
                    }
                } ?>>Mihtarlam</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Qarghayi') {
                        echo 'selected';
                    }
                } ?>>Qarghayi</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Badpash') {
                        echo 'selected';
                    }
                } ?>>Badpash</option>");

            }if (val=="Konar") {
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Asadabad') {echo 'selected';}} ?>>Asadabad</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Dara Noor') {
                        echo 'selected';
                    }
                } ?>>Dara Noor</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Chapa Dara') {
                        echo 'selected';
                    }
                } ?>>Chapa Dara</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Dangam') {echo 'selected';}} ?>>Dangam</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Khas Konar') {echo 'selected';}} ?>>Khas Konar</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Nurgal') {echo 'selected';}} ?>>Nurgal</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Wata Pur') {echo 'selected';}} ?>>Wata Pur</option>");
            }if (val=="Logar") {
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Mohhamad Agha') {echo 'selected';}} ?>>Mohammad Agha</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Charkh') {
                        echo 'selected';
                    }
                } ?>>Charkh</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Baraki Barak') {
                        echo 'selected';
                    }
                } ?>>Baraki Barak</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Azra') {echo 'selected';}} ?>>Azra</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Khushi') {echo 'selected';}} ?>>Khushi</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Kharwar') {echo 'selected';}} ?>>Kharwar</option>");
            }if (val=="Paktia") {
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Chamkani') {echo 'selected';}} ?>>Chamkani</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Ghardaz') {
                        echo 'selected';
                    }
                } ?>>Ghardaz</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Said Karam') {
                        echo 'selected';
                    }
                } ?>>Said Karam</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Zazai') {echo 'selected';}} ?>>Zazai</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Zadran') {echo 'selected';}} ?>>Zadran</option>");
            }if (val=="Ghazni") {
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Deh Yak') {echo 'selected';}} ?>>Deh Yak</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Gelan') {
                        echo 'selected';
                    }
                } ?>>Gelan</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Ghazni') {
                        echo 'selected';
                    }
                } ?>>Ghazni</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Giro') {echo 'selected';}} ?>>Giro</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Jaghori') {echo 'selected';}} ?>>Jaghori</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Nawa') {echo 'selected';}} ?>>Nawa</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Qarabagh') {echo 'selected';}} ?>>Qarabagh</option>");
            }if (val=="Herat") {
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Ghoryan') {echo 'selected';}} ?>>Ghoryan</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Gulran') {
                        echo 'selected';
                    }
                } ?>>Gulran</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Guzara') {
                        echo 'selected';
                    }
                } ?>>Guzara</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Herat') {echo 'selected';}} ?>>Herat</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Kohsan') {echo 'selected';}} ?>>Kohsan</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Shindand') {echo 'selected';}} ?>>Shindand</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Zinda Jan') {echo 'selected';}} ?>>Zinda Jan</option>");
            }if (val=="Kandahar") {
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Spinboldak') {echo 'selected';}} ?>>Spinboldak</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Arghistan') {
                        echo 'selected';
                    }
                } ?>>Arghistan</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Shah Walikot') {
                        echo 'selected';
                    }
                } ?>>Shah Walikot</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Arghandab') {echo 'selected';}} ?>>Arghandab</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Maroof') {echo 'selected';}} ?>>Maroof</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Daman') {echo 'selected';}} ?>>Daman</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Zherai') {echo 'selected';}} ?>>Zherai</option>");
            }if (val=="Balkh") {
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Mazar-i-sharif') {echo 'selected';}} ?>>Mazar-i-sharif</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Hairatan') {
                        echo 'selected';
                    }
                } ?>>Hairatan</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Nahra-i-shahi') {
                        echo 'selected';
                    }
                } ?>>Nahra-i-shahi</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Balkh') {echo 'selected';}} ?>>Balkh</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Chamtal') {echo 'selected';}} ?>>Chamtal</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Sholgar') {echo 'selected';}} ?>>Sholgar</option><option <?php if (isset($_REQUEST['district'])) {if ($_REQUEST['district'] == 'Kaldar') {echo 'selected';}} ?>>Kaldar</option>");
            }if (val=="Peshawar") {
                $('#district').html("<option <?php if (isset($_REQUEST['district'])){if ($_REQUEST['district'] == 'Hayatabad') {echo 'selected';}} ?>>Hayatabad</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Dabgar e Garden') {
                        echo 'selected';
                    }
                } ?>>Dabgar e Garden</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['district'] == 'Ring Road') {
                        echo 'selected';
                    }
                } ?>>Ring Road</option>");
            }

        });
    });
</script>



</body>
</html>



