<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 17-May-20
 * Time: 1:26 AM
 */

/*    Database Connection          */
require_once ("database-connection.php");
session_start();



date_default_timezone_set("Asia/Kabul");
$userAvaliability=false;
$doctorAvaliability=false;
$signupSuccess=false;
$signupNotSuccess=false;
$registerLink=false;
$loginLink=true;

$loginUserNotAvaliable=false;

$doctorNotAprroved=false;
$doctorSend=false;

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

////////////////////////////////////////////////////////////////////
    if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$username)){
        $invalidEmail=true;
        $loginUserNotAvaliable=true;
    }if (strlen($password)<8){
        $invalidPassword=true;
        $loginUserNotAvaliable=true;
    }
///////////////////////////////////////////////////////////////////////
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
            }elseif ($getLogin['user_status']=='send'){
                $doctorSend=true;
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

/*    SignUp Request          */




/*    Counting           */
$numberOfDoctors=null;
$numberOfHospitals=null;
$numberOfClinics=null;
$numberOfMedicals=null;
$loginShow=true;
$short=false;
$dirImage=null;
$dashboard=null;
$profile=null;
$logout=null;
$type=null;

$doctor=$con->query("select * from doctor");
$hospital=$con->query("select * from hospital");
$clinic=$con->query("select * from clinics");
$medical=$con->query("select * from medicals");

$numberOfDoctors=mysqli_num_rows($doctor);
$numberOfHospitals=mysqli_num_rows($hospital);
$numberOfClinics=mysqli_num_rows($clinic);
$numberOfMedicals=mysqli_num_rows($medical);

$doctor=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id");

if (isset($_COOKIE['username'])){
    $loginShow=false;
    $short=true;
    $_SESSION['username']=$_COOKIE['username'];
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
    }elseif ($type=='moha'){
        $dirImage="profiles";
        $dashboard="moha-dashboard.php";
        $profile="moha-profile-setting.php";
        $logout="logout.php?doctor";
        $type="MOHA";
    }elseif ($type=='super admin'){
        $dirImage="profiles";
        $dashboard="super admin/index.php";
        $profile="super admin/profile.php";
        $logout="logout.php?doctor";
        $type="Administrator";
        $userImage="super.jpg";
    }


}

$chckUsername=false;
$sendEmail=false;
$sendnotEmail=false;
$showForgot=false;
if (isset($_REQUEST['reset'])){
    $username=$_REQUEST['username'];

    if ($query=mysqli_query($con,"select user_username from users where user_username='$username'")){
        if (mysqli_num_rows($query)==0){
            $chckUsername=true;
        }else{

            $to=$username;
            $subject="Reset Account Password";


// Message
            $message = "
<html>
<head>
  <title>Reset Your Account Password</title>
</head>
<body>
  <h3>Here is the link to reset your health guide account password:</h3>
  <strong> <a href='http://localhost/fyp%20project/reset-password.php?username=$to&reset'>Click Here To Reset Your Account Password</strong></a>
   <br><br>
 
   <strong>Health Guide Admin</strong>
</body>
</html>
";

            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

            // Additional headers

            $headers[] = 'From: Health Guide <saidmuqeemhashimi@gmail.com>';


            if(mail($to,$subject,$message,implode("\r\n", $headers))){
                $sendEmail=true;
                $showForgot=true;
            }else{
                $sendnotEmail=true;
                $showForgot=true;
            }

        }
    }else{
        echo "not avaliale";
    }

}

if ((isset($_REQUEST['bblocation'])) && (isset($_REQUEST['type'])) && (isset($_REQUEST['searchtwo']))){
  $getlocation=$_REQUEST['bblocation'];
  $type=$_REQUEST['type'];


    if ($getlocation=="Kabul"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Kabul"){
            header("location:search.php?province=Kabul&search=");
            return;
        }elseif ($type=="Hospitals in kabul"){
            header("location:search-hospitals.php?name=&province=Kabul&search=");
            return;
        }elseif ($type=="Clinics in kabul"){
            header("location:search-clinics.php?name=&type=Select&province=Kabul&search=");
            return;
        }elseif ($type=="Medical Stores in kabul"){
            header("loction:search-medicals.php?name=&province=Kabul&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Kabul&search=");
            return;
        }

    }elseif ($getlocation=="Nangarhar"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Nangarhar"){
            header("location:search.php?province=Nangarhar&search=");
            return;
        }elseif ($type=="Hospitals in Nangarhar"){
            header("location:search-hospitals.php?name=&province=Nangarhar&search=");
            return;
        }elseif ($type=="Clinics in Nangarhar"){
            header("location:search-clinics.php?name=&type=Select&province=Nangarhar&search=");
            return;
        }elseif ($type=="Medical Stores in Nangarhar"){
            header("loction:search-medicals.php?name=&province=Nangarhar&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Nangarhar&search=");
            return;
        }

    }elseif ($getlocation=="Kandahar"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Kandahar"){
            header("location:search.php?province=Kandahar&search=");
            return;
        }elseif ($type=="Hospitals in Kandahar"){
            header("location:search-hospitals.php?name=&province=Kandahar&search=");
            return;
        }elseif ($type=="Clinics in Kandahar"){
            header("location:search-clinics.php?name=&type=Select&province=Kandahar&search=");
            return;
        }elseif ($type=="Medical Stores in Kandahar"){
            header("loction:search-medicals.php?name=&province=Kandahar&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Kandahar&search=");
            return;
        }

    }elseif ($getlocation=="Konar"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Konar"){
            header("location:search.php?province=Konar&search=");
            return;
        }elseif ($type=="Hospitals in Konar"){
            header("location:search-hospitals.php?name=&province=Konar&search=");
            return;
        }elseif ($type=="Clinics in Konar"){
            header("location:search-clinics.php?name=&type=Select&province=Konar&search=");
            return;
        }elseif ($type=="Medical Stores in Konar"){
            header("loction:search-medicals.php?name=&province=Konar&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Konar&search=");
            return;
        }

    }elseif ($getlocation=="Paktia"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Paktia"){
            header("location:search.php?province=Paktia&search=");
            return;
        }elseif ($type=="Hospitals in Paktia"){
            header("location:search-hospitals.php?name=&province=Paktia&search=");
            return;
        }elseif ($type=="Clinics in Paktia"){
            header("location:search-clinics.php?name=&type=Select&province=Paktia&search=");
            return;
        }elseif ($type=="Medical Stores in Paktia"){
            header("loction:search-medicals.php?name=&province=Paktia&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Paktia&search=");
            return;
        }

    }elseif ($getlocation=="Logar"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Logar"){
            header("location:search.php?province=Logar&search=");
            return;
        }elseif ($type=="Hospitals in Logar"){
            header("location:search-hospitals.php?name=&province=Logar&search=");
            return;
        }elseif ($type=="Clinics in Logar"){
            header("location:search-clinics.php?name=&type=Select&province=Logar&search=");
            return;
        }elseif ($type=="Medical Stores in Logar"){
            header("loction:search-medicals.php?name=&province=Logar&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Logar&search=");
            return;
        }

    }elseif ($getlocation=="Ghazni"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Ghazni"){
            header("location:search.php?province=Ghazni&search=");
            return;
        }elseif ($type=="Hospitals in Ghazni"){
            header("location:search-hospitals.php?name=&province=Ghazni&search=");
            return;
        }elseif ($type=="Clinics in Ghazni"){
            header("location:search-clinics.php?name=&type=Select&province=Ghazni&search=");
            return;
        }elseif ($type=="Medical Stores in Ghazni"){
            header("loction:search-medicals.php?name=&province=Ghazni&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Ghazni&search=");
            return;
        }

    }elseif ($getlocation=="Balkh"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Balkh"){
            header("location:search.php?province=Balkh&search=");
            return;
        }elseif ($type=="Hospitals in Balkh"){
            header("location:search-hospitals.php?name=&province=Balkh&search=");
            return;
        }elseif ($type=="Clinics in Balkh"){
            header("location:search-clinics.php?name=&type=Select&province=Balkh&search=");
            return;
        }elseif ($type=="Medical Stores in Balkh"){
            header("loction:search-medicals.php?name=&province=Balkh&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Balkh&search=");
            return;
        }

    }elseif ($getlocation=="Khost"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Khost"){
            header("location:search.php?province=Khost&search=");
            return;
        }elseif ($type=="Hospitals in Khost"){
            header("location:search-hospitals.php?name=&province=Khost&search=");
            return;
        }elseif ($type=="Clinics in Khost"){
            header("location:search-clinics.php?name=&type=Select&province=Khost&search=");
            return;
        }elseif ($type=="Medical Stores in Khost"){
            header("loction:search-medicals.php?name=&province=Khost&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Khost&search=");
            return;
        }

    }elseif ($getlocation=="Laghman"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Laghman"){
            header("location:search.php?province=Laghman&search=");
            return;
        }elseif ($type=="Hospitals in Laghman"){
            header("location:search-hospitals.php?name=&province=Laghman&search=");
            return;
        }elseif ($type=="Clinics in Laghman"){
            header("location:search-clinics.php?name=&type=Select&province=Laghman&search=");
            return;
        }elseif ($type=="Medical Stores in Laghman"){
            header("loction:search-medicals.php?name=&province=Laghman&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Laghman&search=");
            return;
        }

    }elseif ($getlocation=="Paktika"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Paktika"){
            header("location:search.php?province=Paktika&search=");
            return;
        }elseif ($type=="Hospitals in Paktika"){
            header("location:search-hospitals.php?name=&province=Paktika&search=");
            return;
        }elseif ($type=="Clinics in Paktika"){
            header("location:search-clinics.php?name=&type=Select&province=Paktika&search=");
            return;
        }elseif ($type=="Medical Stores in Paktika"){
            header("loction:search-medicals.php?name=&province=Paktika&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Paktika&search=");
            return;
        }

    }elseif ($getlocation=="Herat"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Herat"){
            header("location:search.php?province=Herat&search=");
            return;
        }elseif ($type=="Hospitals in Herat"){
            header("location:search-hospitals.php?name=&province=Herat&search=");
            return;
        }elseif ($type=="Clinics in Herat"){
            header("location:search-clinics.php?name=&type=Select&province=Herat&search=");
            return;
        }elseif ($type=="Medical Stores in Herat"){
            header("loction:search-medicals.php?name=&province=Herat&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Herat&search=");
            return;
        }

    }elseif ($getlocation=="Nuristan"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Nuristan"){
            header("location:search.php?province=Nuristan&search=");
            return;
        }elseif ($type=="Hospitals in Nuristan"){
            header("location:search-hospitals.php?name=&province=Nuristan&search=");
            return;
        }elseif ($type=="Clinics in Nuristan"){
            header("location:search-clinics.php?name=&type=Select&province=Nuristan&search=");
            return;
        }elseif ($type=="Medical Stores in Nuristan"){
            header("loction:search-medicals.php?name=&province=Nuristan&search=");
            return;
        }else{
            header("location:search.php?specialist=$type&province=Nuristan&search=");
            return;
        }

    }elseif ($getlocation=="Peshawar"){
        if ($type=="Select Doctors, Clinics, Hospitals, Diseases in Peshawar"){
            header("location:search.php?province=Nuristan&search=");
            return;
        }else{
            header("location:search-outside-doctor.php?specialist=$type&country=Select&search=");
            return;
        }

    }

}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Health Guide</title>

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


    <!---Home Banner Search Area-->

    <section class="section section-search">
        <div class="container-fluid">
            <div class="banner-wrapper">
                <div class="banner-header text-center">
                    <h1 id="m1"> </h1>

                    <p>Discover the best doctors, hospitals & clinics the city nearest  to you.</p>
                </div>

                <!---Search-->

                <div class="search-box">
                    <form action="index.php" method="get">
                        <div class="form-group search-location">

                            <select name="bblocation" id="bblocation" class="form-control">
                                <option>Select a province</option>
                                <option value="Kabul">Kabul</option>
                                <option value="Nangarhar">Nangarhar</option>
                                <option value="Kandahar">Kandahar</option>
                                <option value="Konar">Konar</option>
                                <option value="Paktia">Paktia</option>
                                <option value="Logar">Logar</option>
                                <option value="Ghazni">Ghazni</option>
                                <option value="Balkh">Balkh</option>
                                <option value="Khost">Khost</option>
                                <option value="Laghman">Laghman</option>
                                <option value="Paktika">Paktika</option>
                                <option value="Herat">Herat</option>
                                <option value="Nuristan">Nuristan</option>
                                <option value="Peshawar">Peshawar (Pakistan)</option>

                            </select>
                            <span class="form-text">Based on your Location</span>
                        </div>
                        <div class="form-group search-info">
                            <select id="searchvalue" class="form-control" name="type" placeholder="">
                                <option>Select Doctors, Clinics, Hospitals, Diseases Etc</option>
                            </select>
                            <span class="form-text">Ex : Dental or Sugar Check up etc</span>


                        </div>
                        <button type="submit" class="btn btn-default btn-chevron" name="searchtwo"  id="searchIcon"><i class="fas fa-search"></i></button>




                    </form>
                    <datalist id="searchContents"></datalist>


                    <template id="templateContent">
                        <option>Doctors</option>
                        <option>Hospitals</option>
                        <option>Clinics</option>
                        <option>Medical Stores</option>
                        <option>Medicine Industries</option>
                        <option>Medical Stores</option>
                        <option>Primary Care Doctors</option>
                        <option>Dentist Doctors</option>
                        <option>Eye Doctors</option>
                        <option>Dermatologist Doctors</option>
                        <option>Urology Doctors</option>
                        <option>Neurology Doctors</option>
                        <option>Cardiologist Doctors</option>

                        <option>Dentists in Kabul</option>
                        <option>Eye Specialist in Kabul</option>
                        <option>Skin Specialist in Kabul</option>
                        <option>Child Specialist in Kabul</option>
                        <option>Doctors in Kabul</option>

                        <option>Dentists in Nangarhar</option>
                        <option>Eye Specialist in Nangarhar</option>
                        <option>Skin Specialist in Nangarhar</option>
                        <option>Child Specialist in Nangarhar</option>
                        <option>Doctors in Nangarhar</option>

                        <option>Dentists in Kandahar</option>
                        <option>Eye Specialist in Kandahar</option>
                        <option>Skin Specialist in Kandahar</option>
                        <option>Child Specialist in Kanadahar</option>
                        <option>Doctors in Kandahar</option>

                        <option>Eye Specialist in Logar</option>
                        <option>Primary Care</option>
                        <option>Primary</option>

                    </template>




                </div>

            </div>
        </div>

        <!---/Search-->
    </section>
    <!---Models Counters Area-->
    <section class="section section-counter">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <p>
                        <span class="icon"><i class="fas fa-user-md"></i></span>
                        <span class="label-counter"> <?php echo $numberOfDoctors;  ?> </span>

                    </p>
                    <span class="label">Approved Doctors</span>
                </div>
                <div class="col-md-3 col-sm-6">
                    <p>
                        <span class="icon"><i class="fas fa-hospital"></i></span>
                        <span class="label-counter"> <?php echo $numberOfHospitals;  ?> </span>

                    </p>
                    <span class="label">Approved Hospitals</span>
                </div>
                <div class="col-md-3 col-sm-6">
                    <p>
                        <span class="icon"><i class="fas fa-clinic-medical"></i></span>
                        <span class="label-counter"> <?php echo $numberOfClinics;  ?> </span>

                    </p>
                    <span class="label">Approved Clinics</span>
                </div>
                <div class="col-md-3 col-sm-6">
                    <p>
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span class="label-counter"> <?php echo $numberOfMedicals;  ?> </span>

                    </p>
                    <span class="label">Medical Stores</span>
                </div>


            </div>

        </div>





    </section>
    <!--/Models Counter Area-->
    <!--/Header Part-->

    <!----Specialities Section-->

    <section class="section section-specialities">
        <div class="container-fluid">
            <div class="section-header">
                <h2>Top specailities on HealthGuide:</h2>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="speicality-item">

                        <div class="speicality-img primary-care">
                            <img  src="assets/img/specialities/primary care.svg" class="img-fluid"  alt="Primary Care">
                            <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                        </div>
                        <a href="search.php?specialist=primary care&province=Select&search=">Primary Care</a>

                    </div>



                </div>
                <div class="col-12 col-md-3">
                    <div class="speicality-item">
                        <div class="speicality-img dentist">
                            <img src="assets/img/specialities/dentist.svg" class="img-fluid"  alt="Dentist">
                            <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                        </div>
                        <a href="search.php?specialist=dentist&province=Select&search=">Dentist</a>
                    </div>



                </div>
                <div class="col-12 col-md-3">
                    <div class="speicality-item">
                        <div class="speicality-img eye">
                            <img src="assets/img/specialities/eye.svg" class="img-fluid"  alt="Eye">
                            <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                        </div>
                        <a href="search.php?specialist=eye&province=Select&search=">Eye</a>
                    </div>



                </div>
                <div class="col-12 col-md-3">
                    <div class="speicality-item">
                        <div class="speicality-img der">
                            <img src="assets/img/specialities/dermatologist.svg" class="img-fluid"  alt="Dermatologist">
                            <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                        </div>
                        <a href="search.php?specialist=dermatologist&province=Select&search=">Dermatologist</a>
                    </div>



                </div>
            </div>

            <div class="row specialities-row">
                <div class="col-12 col-md-3">
                    <div class="speicality-item">
                        <div class="speicality-img urology">
                            <img src="assets/img/specialities/urology.png" class="img-fluid"  alt="Urology">
                            <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                        </div>
                        <a href="search.php?specialist=urology&province=Select&search=">Urology</a>
                    </div>



                </div>
                <div class="col-12 col-md-3">
                    <div class="speicality-item">
                        <div class="speicality-img neurology">
                            <img src="assets/img/specialities/neurology.png" class="img-fluid"  alt="Neurology">
                            <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                        </div>
                        <a href="search.php?specialist=neurology&province=Select&search=">Neurology</a>
                    </div>



                </div>
                <div class="col-12 col-md-3">
                    <div class="speicality-item">
                        <div class="speicality-img orthopedic">
                            <img src="assets/img/specialities/orthopedic.png" class="img-fluid"  alt="Orthopedic">
                            <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                        </div>
                        <a href="search.php?specialist=orthopedic&province=Select&search=">Orthopedic</a>
                    </div>



                </div>

                <div class="col-12 col-md-3">
                    <div class="speicality-item">
                        <div class="speicality-img cardiologist">
                            <img src="assets/img/specialities/cardiologist.png" class="img-fluid"  alt="Cardiologist">
                            <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                        </div>
                        <a href="search.php?specialist=cardiologist&province=Select&search=">Cardiologist</a>
                    </div>



                </div>


            </div>
            <div class="row"><br><br></div>
        </div>

    </section>
    <!---/Specialities Section-->

    <!--Profile Sections--->
    <section class="section section-doctor">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#doctors-widget" role="tab" aria-controls="nav-home" aria-selected="true">Doctors</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#hospitals-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Hospitals</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#clinics-profile" role="tab" aria-controls="nav-contact" aria-selected="false">Clinics</a>
                            <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#medicals-profile" role="tab" aria-controls="nav-about" aria-selected="false">Medical</a>

                        </div>

                    </nav>
                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                        <!---Doctors Profiles Section-->
                        <div class="doctor-slider slider tab-pane fade show active" id="doctors-widget" role="tabpanel" aria-labelledby="nav-home-tab">
                            <?php

                            while ($row=$doctor->fetch_assoc()) {
                                $user_id=$row['user_id'];
                                $doctorImage=$con->query("select * from pictures where user_id='$user_id'")->fetch_array()['file_name'];
                                ?>
                                <!-- Doctor Widget -->
                                <div class="profile-widget">
                                    <div class="doc-img">
                                        <a href="#">
                                            <img  class="img-fluid" alt="Doctor Image"
                                                  src="assets/img/doctors/<?=$doctorImage?>">
                                        </a>

                                    </div>
                                    <div class="pro-content">
                                        <h3 class="title">
                                            <a href="doctor-profile.php?doc_id=<?php echo $row['doc_id'];   ?>">Dr. <?php echo $row['doc_firstName'].' '.$row['doc_lastName']; ?> </a>
                                            <i class="fas fa-check-circle verified"></i>
                                        </h3>
                                        <p class="speciality"><?php echo $row['doc_specialization'].' Specialist'; ?></p>

                                        <ul class="available-info">
                                            <li>
                                                <i class="fas fa-check-circle"></i><?php echo $row['doc_status']; ?> By MOHA
                                            </li>

                                            <li>
                                                <i class="fas fa-map-marker-alt"></i> <?php echo $row['doc_location']; ?>
                                            </li>
                                            <li>
                                                <i class="far fa-clock"></i> Available on <?php echo date("D, d M")   ?>
                                            </li>

                                        </ul>
                                        <div class="row row-sm">
                                            <div class="col-6">
                                                <a href="doctor-profile.php?doc_id=<?php echo $row['doc_id'];   ?>" class="btn view-btn">View
                                                    Profile</a>
                                            </div>
                                            <div class="col-6">
                                                <a href="appointmentBooking.php?doc_id=<?php echo $row['doc_id'];   ?>" class="btn book-btn">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Doctor Widget -->
                                <?php
                            }
                            ?>

                        </div>
                        <!---/Doctors Profiles Section-->

                        <!---Hospitals Profiles Section-->
                        <div class="doctor-slider slider tab-pane fade" id="hospitals-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <?php
                            while ($row=$hospital->fetch_array()) {
                                ?>
                                <!-- Hospital Widget -->
                                <div class="profile-widget">
                                    <div class="doc-img">
                                        <a>
                                            <img src="assets/img/services/hos.png" class="img-fluid" alt="Hospital Image">
                                        </a>

                                    </div>
                                    <div class="pro-content">
                                        <h3 class="title">
                                            <a><?php echo $row['hos_name']; ?> Hospital</a>
                                            <i class="fas fa-check-circle verified"></i>
                                        </h3>
                                        <p class="speciality"><?php echo $row['hos_deptDesc']; ?></p>

                                        <ul class="available-info">
                                            <li>
                                                <i class="fas fa-map-marker-alt"></i> <?php echo $row['hos_location']; ?>
                                            </li>
                                            <li>
                                                <i class="far fa-clock"></i> Available on <?php echo date("D, d M")   ?>
                                            </li>

                                        </ul>
                                        <div class="row row-sm">
                                            <div class="col-6">
                                                <a class="btn book-btn">Approved</a>
                                            </div>
                                            <div class="col-6">
                                                <a href="search-hospitals.php" class="btn view-btn">View List
                                                    </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                            ?>

                        </div>
                        <!-- /Hospital Widget -->

                        <!---Clinics Profiles Section-->
                        <div class="doctor-slider slider tab-pane fade" id="clinics-profile" role="tabpanel" >
                            <?php
                            while ($row=$clinic->fetch_array()) {
                                ?>
                                <!-- Hospital Widget -->
                                <div class="profile-widget">
                                    <div class="doc-img">
                                        <a>
                                            <img src="assets/img/services/cli.png" class="img-fluid" alt="Clinic Image"
                                            >
                                        </a>

                                    </div>
                                    <div class="pro-content">
                                        <h3 class="title">
                                            <a><?php echo $row['clinic_name']; ?> Clinic</a>

                                            <i class="fas fa-check-circle verified"></i>
                                        </h3>
                                        <p class="speciality"><?php echo $row['clinic_type']; ?></p>

                                        <ul class="available-info">
                                            <li>
                                                <i class="fas fa-map-marker-alt"></i> <?php echo $row['clinic_location']; ?>
                                            </li>


                                        </ul>
                                        <div class="row row-sm">
                                            <div class="col-6">
                                                <a class="btn book-btn">Approved</a>
                                            </div>
                                            <div class="col-6">
                                                <a href="search-clinics.php" class="btn view-btn">View List
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                            ?>

                        </div>
                        <!-- /Clinic Widget -->
                        <!---Medicals Profiles Section-->
                        <div class="doctor-slider slider tab-pane fade" id="medicals-profile" role="tabpanel" aria-labelledby="nav-profile-tab" >
                            <?php
                            while ($row=$medical->fetch_array()) {
                                ?>
                                <!-- Medical Widget -->
                                <div class="profile-widget">
                                    <div class="doc-img">
                                        <a >
                                            <img src="assets/img/services/med.png" class="img-fluid" alt="Clinic Image"
                                            >
                                        </a>
                                        <a href="javascript:void(0)">
                                            <a><?php echo $row['medical_name']; ?> Medical Store</a><i class="fas fa-check-circle verified"></i>


                                        </a>
                                    </div>
                                    <div class="pro-content">
                                        <h3 class="title">


                                        </h3>


                                        <ul class="available-info">
                                            <li>
                                                <i class="fas fa-map-marker-alt"></i> <?php echo $row['medical_location']; ?>
                                            </li>
                                            <li>

                                            </li>

                                        </ul>
                                        <div class="row row-sm">

                                            <div class="col-6">
                                                <a class="btn book-btn">Approved</a>
                                            </div>
                                            <div class="col-6">
                                                <a href="search-medicals.php" class="btn view-btn">View List
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                            ?>

                        </div>
                        <!-- /Medical Widget -->
                    </div>

                </div>


            </div>


        </div>

    </section>




    <!--Service Carousal-->
    <section class="section section-service d-xs-none" id="section-service">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="service-header"><h2 class="display-5">Are you looking for?</h2></div>
                    <div id="services" class="carousel slide service-slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#services" data-slide-to="0" class="active" style="background-color:  #0de0fe;"></li>
                            <li data-target="#services" data-slide-to="1" style="background-color:  #072881;"></li>
                            <li data-target="#services" data-slide-to="2" style="background-color:  #fe1d0d;"></li>
                            <li data-target="#services" data-slide-to="3" style="background-color:  #6e007c;"></li>
                            <li data-target="#services" data-slide-to="4" style="background-color:  #1a0283;"></li>
                            <li data-target="#services" data-slide-to="5" style="background-color:  #131212;"></li>
                        </ol>

                        <div class="carousel-inner" role="listbox">

                            <!--Doctor Slide-->
                            <div class="carousel-item active" style="background-image: url('assets/img/services/doctor.png')">
                                <div class="carousel-caption d-none d-md-block">
                                    <h2 class="display-5" style="color: #0de0fe;">Approved Doctors in Afghanistan</h2>
                                    <p class="lead" style="color: black;">Here you can <span style="color: #0de0fe;position: relative;left: 3px;">  find approved doctors</span> <span style="position: relative;margin-left: 3px;">  in Afghanistan.</span></p>


                                    <a href="search.php" class="btn check-btn">Check Doctors</a>


                                </div>
                            </div>
                            <!--Outside Doctors Slide-->
                            <div class="carousel-item" style="background-image: url('assets/img/services/outside.png')" >
                                <div class="carousel-caption d-none d-md-block">
                                    <h2 class="display-5" style="color: #072881;">Outside Doctors</h2>
                                    <p class="lead" style="color: black;">Here you can <span style="color: #072881;">  find outside doctors</span> in other countries.</p>
                                    <a href="search-outside-doctor.php" class="btn check-btn-outsidedr">Check Outside Doctors</a>

                                </div>
                            </div>
                            <!--Hospital Slide-->
                            <div class="carousel-item" style="background-image: url('assets/img/services/hospital.jpg')" >
                                <div class="carousel-caption d-none d-md-block">
                                    <h2 class="display-5" style="color: #fe1d0d;">Approved Hospitals in Afghanistan</h2>
                                    <p class="lead" style="color: black;">Here you can <span style="color: #fe1d0d;">find approved hospitals</span> in Afghanistan.</p>
                                    <a href="search-hospitals.php" class="btn check-btn-hospital">Check Hospitals</a>
                                </div>
                            </div>
                            <!--Clinics Slide-->
                            <div class="carousel-item" style="background-image: url('assets/img/services/clinic.jpg')">
                                <div class="carousel-caption d-none d-md-block">
                                    <h2 class="display-5" style="color: #6e007c;">Approved Clinics in Afghanistan</h2>
                                    <p class="lead" style="color: black;">Here you can <span style="color: #6e007c;"> find approved clinics </span>in Afghanistan.</p>
                                    <a href="search-clinics.php" class="btn check-btn-clinic">Check Clinics</a>
                                </div>
                            </div>
                            <!--Medical Stores Slides-->
                            <div class="carousel-item" style="background-image: url('assets/img/services/medical.jpg')">
                                <div class="carousel-caption d-none d-md-block">
                                    <h2 class="display-5" style="color: #1a0283;">Approved Medical Stores in Afghanistan</h2>
                                    <p class="lead" style="color: black;">Here you can <span style="color: #1a0283;"> find approved medical stores </span> in Afghanistan.</p>
                                    <a href="search-medicals.php" class="btn check-btn-medical">Check Medical Stores</a>
                                </div>
                            </div>
                            <!--Pharmacy Slides-->
                            <div class="carousel-item" style="background-image: url('assets/img/services/medicine.jpg')">
                                <div class="carousel-caption d-none d-md-block">
                                    <h2 class="display-5" style="color: #131212;">Approved Medicine Industries in Afghanistan</h2>
                                    <p class="lead" style="color: black;">Here you can <span style="color: #131212;">find approved medicine industries</span>  in Afghanistan.</p>
                                    <a href="search-medicines.php" class="btn check-btn-medicine">Check Medicine Industries</a>
                                </div>
                            </div>


                        </div>
                        <a class="carousel-control-prev" href="#services" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#services" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>


                    </div>

                </div>

            </div>

        </div>


    </section>

    <!--/Service Carousal-->


    <!---City Names Section-->

    <section class="section section-city">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="city-header">
                        <a href="search.php?kabuldoctors"><h4 style="color: #09e5ab;">Doctors in Kabul</h4></a>
                        <ul class="subtitles">
                            <li><a href="search.php?kabul=dentist" target="blank"> <i class="fas fa-angle-double-right"></i> Dentists in Kabul</a></li>
                            <li><a href="search.php?kabul=eye" target="blank"> <i class="fas fa-angle-double-right"></i> Eye	Specialist in Kabul</a></li>
                            <li><a href="search.php?kabul=skin" target="blank"> <i class="fas fa-angle-double-right"></i> Skin Specialist in Kabul</a></li>
                            <li><a href="search.php?kabul=gynecologists" target="blank"> <i class="fas fa-angle-double-right"></i> Gynecologists in Kabul</a></li>
                            <li><a href="search.php?kabul=plasticsurgeon" target="blank"> <i class="fas fa-angle-double-right"></i> Plastic surgeons in Kabul</a></li>
                            <li><a href="search.php?kabul=cardiologist" target="blank"> <i class="fas fa-angle-double-right"></i> Cardiologist in Kabul</a></li>
                            <li><a href="search-hospitals.php?name=&province=Kabul&search=" target="blank"> <i class="fas fa-angle-double-right"></i> Hospital in Kabul</a></li>
                            <li><a href="search.php?kabul=ent" target="blank"> <i class="fas fa-angle-double-right"></i> ENT Specialist in Kabul</a></li>
                            <li><a href="search.php?kabul=child" target="blank"> <i class="fas fa-angle-double-right"></i> Child Specialist in Kabul</a></li>
                            <li><a href="search.php?kabul=orthopedic" target="blank"> <i class="fas fa-angle-double-right"></i> Orthopedic surgeons in Kabul</a></li>

                        </ul>
                    </div>

                </div>
                <div class="col-lg-3">
                    <div class="city-header">
                        <a href="search.php?doctornangarhar"><h4 style="color: #09e5ab;">Doctors in Nangarhar</h4></a>
                        <ul class="subtitles">
                            <li><a href="search.php?nan=dentist" target="blank"> <i class="fas fa-angle-double-right"></i> Dentists in Nangarhar</a></li>
                            <li><a href="search.php?nan=eye" target="blank"> <i class="fas fa-angle-double-right"></i> Eye	Specialist in Nangarhar</a></li>
                            <li><a href="search.php?nan=skin" target="blank"> <i class="fas fa-angle-double-right"></i> Skin Specialist in Nangarhar</a></li>
                            <li><a href="search.php?nan=gynecologists" target="blank"> <i class="fas fa-angle-double-right"></i> Gynecologists in Nangarhar</a></li>
                            <li><a href="search.php?nan=plastic" target="blank"> <i class="fas fa-angle-double-right"></i> Plastic surgeons in Nangarhar</a></li>
                            <li><a href="search.php?nan=cardiologist" target="blank"> <i class="fas fa-angle-double-right"></i> Cardiologist in Nangarhar</a></li>
                            <li><a href="search-hospitals.php?name=&province=Nangarhar&search=" target="blank"> <i class="fas fa-angle-double-right"></i> Hospital in Nangarhar</a></li>
                            <li><a href="search.php?nan=ent" target="blank"> <i class="fas fa-angle-double-right"></i> ENT Specialist in Nangarhar</a></li>
                            <li><a href="search.php?nan=child" target="blank"> <i class="fas fa-angle-double-right"></i> Child Specialist in Nangarhar</a></li>
                            <li><a href="search.php?nan=orthopedic" target="blank"> <i class="fas fa-angle-double-right"></i> Orthopedic surgeons in Nangarhar</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="city-header">
                        <a href="search.php?doctorkandahar"><h4 style="color: #09e5ab;">Doctors in Kandahar</h4></a>
                        <ul class="subtitles">
                            <li><a href="search.php?kan=dentist" target="blank"> <i class="fas fa-angle-double-right"></i> Dentists in Kandahar</a></li>
                            <li><a href="search.php?kan=eye" target="blank"> <i class="fas fa-angle-double-right"></i> Eye	Specialist in Kandahar</a></li>
                            <li><a href="search.php?kan=skin" target="blank"> <i class="fas fa-angle-double-right"></i> Skin Specialist in Kandahar</a></li>
                            <li><a href="search.php?kan=gynecologist" target="blank"> <i class="fas fa-angle-double-right"></i> Gynecologists in Kandahar</a></li>
                            <li><a href="search.php?kan=plastic" target="blank"> <i class="fas fa-angle-double-right"></i> Plastic surgeons in Kandahar</a></li>
                            <li><a href="search.php?kan=cardiologist" target="blank"> <i class="fas fa-angle-double-right"></i> Cardiologist in Kandahar</a></li>
                            <li><a href="search-hospitals.php?name=&province=Kandahar&search=" target="blank"> <i class="fas fa-angle-double-right"></i> Hospital in Kandahar</a></li>
                            <li><a href="search.php?kan=ent" target="blank"> <i class="fas fa-angle-double-right"></i> ENT Specialist in Kandahar</a></li>
                            <li><a href="search.php?kan=child" target="blank"> <i class="fas fa-angle-double-right"></i> Child Specialist in Kandahar</a></li>
                            <li><a href="search.php?kan=orthopedic" target="blank"> <i class="fas fa-angle-double-right"></i> Orthopedic surgeons in Kandahar</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="city-header">
                        <a><h4 style="color: #09e5ab;">Doctors in Other Cities</h4></a>
                        <ul class="subtitles">
                            <li><a href="search.php"><i class="fas fa-angle-double-right"></i> Search for Doctors</a></li>
                            <li><a href="search.php?eyelogar" target="blank">  <i class="fas fa-angle-double-right"></i> Eye	Specialist in Logar</a></li>
                            <li><a href="search.php?skinherat" target="blank">  <i class="fas fa-angle-double-right"></i> Skin Specialist in Herat</a></li>
                            <li><a href="search.php?gynecologistkhost" target="blank">  <i class="fas fa-angle-double-right"></i> Gynecologists in Khost</a></li>
                            <li><a href="search.php?hospitalspaktia" target="blank">  <i class="fas fa-angle-double-right"></i> Hospitals in Paktia</a></li>
                            <li><a href="search.php?cardiologistghazni" target="blank">  <i class="fas fa-angle-double-right"></i> Cardiologist in Ghazni</a></li>
                            <li><a href="search-hospitals.php?name=&province=Logar&search=" target="blank">  <i class="fas fa-angle-double-right"></i> Hospital in Logar</a></li>
                            <li><a href="search.php?entlaghman" target="blank">  <i class="fas fa-angle-double-right"></i> ENT Specialist in Laghman</a></li>
                            <li><a href="search.php?childpaktia" target="blank">  <i class="fas fa-angle-double-right"></i> Child Specialist in Paktia</a></li>
                            <li><a href="search.php?orthopedicpaktia" target="blank">  <i class="fas fa-angle-double-right"></i> Orthopedic surgeons in Paktia</a></li>

                        </ul>
                    </div>
                </div>

            </div>

        </div>




    </section>

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

<!--/Main Wrapper-->






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
                                                <div style="; display: <?php if ($doctorSend==false){echo 'none';}  ?>">
                                                    <span style="color: darkred" class="forgot-link"> <i class="fas fa-check-circle" style="margin-right: 3px"></i> An email send to your account, to activate your health guide account click on link in the email </span>

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
                                            <form action="index.php" method="post">
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




<!--/Login/Sigup Modal-->
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
<script src="assets/js/form-validation.js"></script>


<script type="text/javascript">
    var search = document.querySelector('#search');
    var results = document.querySelector('#searchContents');
    var templateContent = document.querySelector('#templateContent').content;

    search.addEventListener('keyup', function handler(event) {
        while (results.children.length) results.removeChild(results.firstChild);
        var inputVal = new RegExp(search.value.trim(), 'i');
        var set = Array.prototype.reduce.call(templateContent.cloneNode(true).children, function searchFilter(frag, item, i) {
            if (inputVal.test(item.textContent) && frag.children.length < 6) frag.appendChild(item);
            return frag;
        }, document.createDocumentFragment());
        results.appendChild(set);
    });



</script>

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
elseif (($doctorNotAprroved==true) || ($doctorSend==true)){
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

