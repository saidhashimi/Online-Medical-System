<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 18-May-20
 * Time: 3:03 PM
 */
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
    }
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
if (isset($_REQUEST['signupforpatient'])){
    $name=$_REQUEST['name'];
    $contact=$_REQUEST['contact'];
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];
    $address=$_REQUEST['address'];


    $password=password_hash($password,PASSWORD_DEFAULT);




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

    $password=password_hash($password,PASSWORD_DEFAULT);




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



/*    Search Area          */


    $doctorProfileRecords=null;
    $selectAllDoctorRecords=null;
    $breadCumpShow=false;
    $counter=null;
    $genderText=false;
    $specialistText=false;
    $provinceText=false;
    $maleSpecialist=false;
    $maleSpecialistText=false;
    $maleprovince=false;
    $maleProvinceText=false;
    $maleSpecialistProvince=false;
    $primaryCareText=false;
    $dentistText=false;
    $eyeText=false;
    $dermatoligistText=false;
    $urologyText=false;
    $neurologyText=false;
    $orthopedicText=false;
    $cardiologistText=false;
    $doctorKabulText=false;
    $dentistKabulText=false;
    $eyeKabulText=false;
    $skinKabulText=false;
    $gyneKabulTezt=false;
    $plasticKabulText=false;
    $cardiologistKabulText=false;
    $hospitalsKabulText=false;
    $entKabulText=false;
    $childKabulText=false;
    $orthopedicKabulText=false;

    $doctornangarharText=false;
    $dentistNangarharText=false;
    $eyeNangarharText=false;
    $skinNangarharText=false;
    $gyneNangarharTezt=false;
    $plasticNangarharText=false;
    $cardiologistNangarharText=false;
    $hospitalsNangarharText=false;
    $entNangarharText=false;
    $childNangarharText=false;
    $orthopedicNangarharText=false;

    $doctorkandaharText=false;
    $dentistKandaharText=false;
    $eyeKandaharText=false;
    $skinKandaharText=false;
    $gyneKandaharTezt=false;
    $plasticKandaharText=false;
    $cardiologistKandaharText=false;
    $hospitalsKandaharText=false;
    $entKandaharText=false;
    $childKandaharText=false;
    $orthopedicKandaharText=false;

    $eyeLogarText=false;
    $skinHeratText=false;
    $gyneKhostText=false;
    $hospitalPaktiaText=false;
    $cardiologistGhazniText=false;
    $hospitalsLogarText=false;
    $entLaghmanText=false;
    $childPaktiaText=false;
    $orthopedicPaktiaText=false;
$specialistProvince=false;




    $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id");




    if (isset($_REQUEST['search'])){
        $breadCumpShow=true;
        if (isset($_REQUEST['gender'])){
            $gender=$_REQUEST['gender'];

            if (isset($_REQUEST['specialist'])){

                if ($_REQUEST['province']!='Select') {

                        $maleSpecialistProvince=true;
                    }

                else {
                    $maleSpecialist = true;
                }
            }
            elseif ($_REQUEST['province']!='Select'){
                $maleprovince=true;
            }

            else {


                $selectAllDoctorRecords = $con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_gender,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_gender='$gender'");


                $counter = mysqli_num_rows($selectAllDoctorRecords);
                $genderText = true;


            }
        }
        elseif ((isset($_REQUEST['specialist'])) && ($_REQUEST['province'])=="Select"){




                $specialist = $_REQUEST['specialist'];

                $selectAllDoctorRecords = $con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doc_specialization='$specialist'");
                $counter = mysqli_num_rows($selectAllDoctorRecords);
                $specialistText = true;

        }
        elseif ((isset($_REQUEST['province']))&& (!isset($_REQUEST['specialist'])) && (!isset($_REQUEST['gender']))){
            if ($_REQUEST['province']!='Select'){
                $province=$_REQUEST['province'];
                $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users  on users.doc_id=doctor.doc_id and doctor.doc_location LIKE '%$province%'");
                $counter=mysqli_num_rows($selectAllDoctorRecords);
                $provinceText=true;


            }
        }

        if ($maleSpecialist==true){
             $gender=$_REQUEST['gender'];
             $specialist=$_REQUEST['specialist'];

             $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_gender,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_gender='$gender' and doctor.doc_specialization='$specialist'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $maleSpecialistText=true;

        }
        if ($maleprovince==true){
            $gender=$_REQUEST['gender'];
            $province=$_REQUEST['province'];
            if ($_REQUEST['province']!='Select') {
                $selectAllDoctorRecords = $con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_gender,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_gender='$gender' and doctor.doc_location LIKE '%$province%'");
                $counter = mysqli_num_rows($selectAllDoctorRecords);
                $maleProvinceText = true;
            }
        }
        if ($maleSpecialistProvince==true){

            if ($_REQUEST['province']!='Select') {
                $gender=$_REQUEST['gender'];
                $specialist=$_REQUEST['specialist'];
                $province=$_REQUEST['province'];

                $selectAllDoctorRecords = $con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_gender,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_gender='$gender' and doctor.doc_location LIKE '%$province%' and doctor.doc_specialization='$specialist'");
                $counter = mysqli_num_rows($selectAllDoctorRecords);
                $maleSpecialistProvince=true;

            }
        }

        if ((isset($_REQUEST['specialist'])) && (($_REQUEST['province'])!="Select") && (!isset($_REQUEST['gender']))){
            $specialist=$_REQUEST['specialist'];
            $province=$_REQUEST['province'];

            $selectAllDoctorRecords = $con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_gender,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and  doctor.doc_location like '%$province%' and doctor.doc_specialization='$specialist'");
            $counter = mysqli_num_rows($selectAllDoctorRecords);
            $specialistProvince=true;
        }



    }
    elseif (isset($_REQUEST['primarycare'])){

        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact,doctorprofile.profile_province from doctor inner join users on doctor.doc_id=users.doc_id inner join doctorprofile on users.user_id=doctorprofile.user_id and doctor.doc_specialization='primary care'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $primaryCareText=true;
    }
    elseif (isset($_REQUEST['dentist'])){

        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact,doctorprofile.profile_province from doctor inner join users on doctor.doc_id=users.doc_id inner join doctorprofile on users.user_id=doctorprofile.user_id and doctor.doc_specialization='dentist'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $dentistText=true;
    }
    elseif (isset($_REQUEST['eye'])){

        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact,doctorprofile.profile_province from doctor inner join users on doctor.doc_id=users.doc_id inner join doctorprofile on users.user_id=doctorprofile.user_id and doctor.doc_specialization='eye'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $eyeText=true;
    }
    elseif (isset($_REQUEST['dermatologist'])){

        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact,doctorprofile.profile_province from doctor inner join users on doctor.doc_id=users.doc_id inner join doctorprofile on users.user_id=doctorprofile.user_id and doctor.doc_specialization='dermatologist'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $dermatoligistText=true;
    }
    elseif (isset($_REQUEST['urology'])){

        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact,doctorprofile.profile_province from doctor inner join users on doctor.doc_id=users.doc_id inner join doctorprofile on users.user_id=doctorprofile.user_id and doctor.doc_specialization='urology'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $urologyText=true;
    }
    elseif (isset($_REQUEST['neurology'])){

        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact,doctorprofile.profile_province from doctor inner join users on doctor.doc_id=users.doc_id inner join doctorprofile on users.user_id=doctorprofile.user_id and doctor.doc_specialization='neurology'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $neurologyText=true;
    }
    elseif (isset($_REQUEST['orthopedic'])){

        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact,doctorprofile.profile_province from doctor inner join users on doctor.doc_id=users.doc_id inner join doctorprofile on users.user_id=doctorprofile.user_id and doctor.doc_specialization='orthopedic'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $orthopedicText=true;
    }
    elseif (isset($_REQUEST['cardiologist'])){

        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact,doctorprofile.profile_province from doctor inner join users on doctor.doc_id=users.doc_id inner join doctorprofile on users.user_id=doctorprofile.user_id and doctor.doc_specialization='cardiologist'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $cardiologistText=true;
    }
    if (isset($_REQUEST['kabuldoctors'])){


        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Kabul%'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $doctorKabulText=true;
    }
    if (isset($_REQUEST['kabul'])){

        $getInfo=$_REQUEST['kabul'];

        if ($getInfo=='dentist'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Kabul%' and doctor.doc_specialization='Dentist'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $dentistKabulText=true;
        }elseif ($getInfo=='eye'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Kabul%' and doctor.doc_specialization='Eye'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $eyeKabulText=true;
        }
        elseif ($getInfo=='skin'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Kabul%' and doctor.doc_specialization='Skin'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $skinKabulText=true;
        }
        elseif ($getInfo=='gynecologists'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Kabul%' and doctor.doc_specialization='Gynecologist'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $gyneKabulTezt=true;
        }
        elseif ($getInfo=='plastic'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Kabul%' and doctor.doc_specialization='Plastic Surgeon'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $plasticKabulText=true;
        }
        elseif ($getInfo=='cardiologist'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Kabul%' and doctor.doc_specialization='Cardiologist'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $cardiologistKabulText=true;
        }
        elseif ($getInfo=='hospitals'){
            $selectAllDoctorRecords=$con->query("select * from hospital where hos_location='Kabul'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $hospitalsKabulText=true;
        }
        elseif ($getInfo=='ent'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Kabul%' and doctor.doc_specialization='Ent Specialist'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $entKabulText=true;
        }
        elseif ($getInfo=='child'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Kabul%' and doctor.doc_specialization='Child'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $childKabulText=true;
        }
        elseif ($getInfo=='orthopedic'){
            $selectAllDoctorRecords=$con->query("select * from doctor where doctor.doc_location like '%Kabul%' and doc_specialization='Orthopedic Surgeon'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $orthopedicKabulText=true;
        }


    }
    if (isset($_REQUEST['doctornangarhar'])){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and  doctor.doc_location like '%Nangarhar%'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $doctornangarharText=true;
    }
    if (isset($_REQUEST['nan'])){
        $getInfo=$_REQUEST['nan'];

        if ($getInfo=='dentist'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Nangarhar%' and doctor.doc_specialization='Dentist'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $dentistNangarharText=true;
        }

        elseif ($getInfo=='eye'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Nangarhar%' and doctor.doc_specialization='Eye'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $eyeNangarharText=true;
        }
        elseif ($getInfo=='skin'){
            $selectAllDoctorRecords=$con->query("select * from doctor where doc_location='Nangarhar' and doc_specialization='Skin'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $skinNangarharText=true;
        }
        elseif ($getInfo=='gynecologists'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Nangarhar%' and doctor.doc_specialization='Gynecologist'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $gyneNangarharTezt=true;
        }
        elseif ($getInfo=='plastic'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and  doctor.doc_location like '%Nangarhar%' and doctor.doc_specialization='Plastic Surgeon'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $plasticNangarharText=true;
        }
        elseif ($getInfo=='cardiologist'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Nangarhar%' and doctor.doc_specialization='Cardiologist'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $cardiologistNangarharText=true;
        }
        elseif ($getInfo=='hospitals'){
            $selectAllDoctorRecords=$con->query("select * from hospital where hos_location='Nangarhar'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $hospitalsNangarharText=true;
        }
        elseif ($getInfo=='ent'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Nangarhar%' and doctor.doc_specialization='Ent Specialist'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $entNangarharText=true;
        }
        elseif ($getInfo=='child'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Nangarhar%' and doctor.doc_specialization='Child'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $childNangarharText=true;
        }
        elseif ($getInfo=='orthopedic'){
            $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Nangarhar%' and doctor.doc_specialization='Orthopedic Surgeon'");
            $counter=mysqli_num_rows($selectAllDoctorRecords);
            $breadCumpShow=true;
            $orthopedicNangarharText=true;
        }


    }
    if (isset($_REQUEST['doctorkandahar'])){
    $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Kandahar%'");
    $counter=mysqli_num_rows($selectAllDoctorRecords);
    $breadCumpShow=true;
    $doctorkandaharText=true;
}
    if (isset($_REQUEST['kan'])){
    $getInfo=$_REQUEST['kan'];

    if ($getInfo=='dentist'){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Kandahar%' and doctor.doc_specialization='Dentist'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $dentistKandaharText=true;
    }

    elseif ($getInfo=='eye'){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Kandahar%' and doctor.doc_specialization='Eye'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $eyeKandaharText=true;
    }
    elseif ($getInfo=='skin'){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Kandahar%' and doctor.doc_specialization='Skin'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $skinKandaharText=true;
    }
    elseif ($getInfo=='gynecologists'){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Kandahar%' and doctor.doc_specialization='Gynecologist'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $gyneKandaharTezt=true;
    }
    elseif ($getInfo=='plastic'){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Kandahar%' and doctor.doc_specialization='Plastic Surgeon'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $plasticKandaharText=true;
    }
    elseif ($getInfo=='cardiologist'){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Kandahar%' and doctor.doc_specialization='Cardiologist'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $cardiologistKandaharText=true;
    }
    elseif ($getInfo=='hospitals'){
        $selectAllDoctorRecords=$con->query("select * from hospital where hos_location like '%Kandahar%'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $hospitalsKandaharText=true;
    }
    elseif ($getInfo=='ent'){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Kandahar%' and doctor.doc_specialization='Ent Specialist'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $entKandaharText=true;
    }
    elseif ($getInfo=='child'){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Kandahar%' and doctor.doc_specialization='Child'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $childKandaharText=true;
    }
    elseif ($getInfo=='orthopedic'){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Kandahar%' and doctor.doc_specialization='Orthopedic Surgeon'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $orthopedicKandaharText=true;
    }


}

    if (isset($_REQUEST['eyelogar'])){
        $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Logar%' and doctor.doc_specialization='Eye Specialist'");
        $counter=mysqli_num_rows($selectAllDoctorRecords);
        $breadCumpShow=true;
        $eyeLogarText=true;

    }
    if (isset($_REQUEST['skinherat'])){
    $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Herat%' and doctor.doc_specialization='Skin'");
    $counter=mysqli_num_rows($selectAllDoctorRecords);
    $breadCumpShow=true;
    $skinHeratText=true;

}
    if (isset($_REQUEST['gynecologistkhost'])){
    $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Khost%' and doctor.doc_specialization='Gynecologist'");
    $counter=mysqli_num_rows($selectAllDoctorRecords);
    $breadCumpShow=true;
    $gyneKhostText=true;

}
if (isset($_REQUEST['hospitalspaktia'])){
    $selectAllDoctorRecords=$con->query("select * from hospital where hos_location='Paktia'");
    $counter=mysqli_num_rows($selectAllDoctorRecords);
    $breadCumpShow=true;
    $hospitalPaktiaText=true;

}
if (isset($_REQUEST['cardiologistghazni'])){
    $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Ghazni%' and doctor.doc_specialization='Cardiologist'");
    $counter=mysqli_num_rows($selectAllDoctorRecords);
    $breadCumpShow=true;
    $cardiologistGhazniText=true;

}
if (isset($_REQUEST['hospitalslogar'])){
    $selectAllDoctorRecords=$con->query("select * from hospital where hos_location='Logar'");
    $counter=mysqli_num_rows($selectAllDoctorRecords);
    $breadCumpShow=true;
    $hospitalsLogarText=true;

}
if (isset($_REQUEST['entlaghman'])){
    $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id  and doctor.doc_location like '%Laghman%' and doctor.doc_specialization='Ent Specialist'");
    $counter=mysqli_num_rows($selectAllDoctorRecords);
    $breadCumpShow=true;
    $entLaghmanText=true;

}
if (isset($_REQUEST['childpaktia'])){
    $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Paktia%' and doctor.doc_specialization='Child'");
    $counter=mysqli_num_rows($selectAllDoctorRecords);
    $breadCumpShow=true;
    $childPaktiaText=true;

}
if (isset($_REQUEST['orthopedicpaktia'])){
    $selectAllDoctorRecords=$con->query("select doctor.doc_id,doctor.doc_firstName,doctor.doc_lastName,doctor.doc_specialization,doc_qualification,doctor.doc_location,doctor.doc_status,users.user_id,users.user_contact from doctor inner join users on doctor.doc_id=users.doc_id and doctor.doc_location like '%Paktia%' and doctor.doc_specialization='Orthopedic'");
    $counter=mysqli_num_rows($selectAllDoctorRecords);
    $breadCumpShow=true;
    $orthopedicPaktiaText=true;

}


$loginShow=true;
$short=false;
$dirImage=null;
$dashboard=null;
$profile=null;
$logout=null;
$type=null;


if (isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
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


<html>
<head>
    <meta charset="utf-8">
    <title>Health Guide-Search</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="assets/img/favicon.png" rel="icon">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.min.css">

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
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar" style="display: <?php if ($breadCumpShow==false){ echo "none"; }  ?> ">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item active" aria-current="page">Search</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title"><?php echo $counter; ?> matches found for : <?php if ($genderText==true){ echo $_REQUEST['gender']; }if ($specialistProvince==true){ echo $_REQUEST['specialist']." doctor in ".$_REQUEST['province']; }if ($specialistText==true){ echo $_REQUEST['specialist']; }elseif ($provinceText==true){ echo $_REQUEST['province']; }elseif ($maleSpecialistText==true){ echo $_REQUEST['gender']." ".$_REQUEST['specialist']; }elseif ($maleProvinceText==true){ echo $_REQUEST['gender']." doctor in ".$_REQUEST['province']; }elseif ($maleSpecialistProvince==true){ echo $_REQUEST['gender']." ".$_REQUEST['specialist'] ." doctor in ".$_REQUEST['province']; }elseif ($primaryCareText==true){ echo "primary care specialist";}elseif ($dentistText==true){ echo "dentist doctors";}elseif ($eyeText==true){ echo "eye specialist doctors";}elseif ($dentistText==true){ echo "dentist doctors";}elseif ($dermatoligistText==true){ echo "dermatologist specialist doctors";}elseif ($dentistText==true){ echo "dentist doctors";}elseif ($urologyText==true){ echo "urology specialist doctors";}elseif ($dentistText==true){ echo "dentist doctors";}elseif ($neurologyText==true){ echo "neurology specialist doctors";}elseif ($dentistText==true){ echo "dentist doctors";}elseif ($orthopedicText==true){ echo "orthopedic specialist doctors";}elseif ($dentistText==true){ echo "dentist doctors";}elseif ($cardiologistText==true){ echo "cardiologist specialist doctors";}elseif ($doctorKabulText==true){ echo "doctors in kabul";}
                        elseif ($dentistKabulText==true){ echo "dentists in kabul";}elseif ($eyeKabulText==true){ echo "eye specialists in kabul";}
                        elseif ($skinKabulText==true){ echo "skin specialists in kabul";}elseif ($gyneKabulTezt==true){ echo "gynecologists specialists in kabul";}
                        elseif ($plasticKabulText==true){ echo "plastic surgeons  in kabul";}elseif ($cardiologistKabulText==true){ echo "cardiologists in kabul";}
                        elseif ($hospitalsKabulText==true){ echo "hospitals in kabul";}elseif ($entKabulText==true){ echo "ent specialists in kabul";}
                        elseif ($childKabulText==true){ echo "child specialists in kabul";}elseif ($orthopedicText==true){ echo "orthopedic surgeons in kabul";}
                        elseif ($doctornangarharText==true){ echo "doctors in Nangarhar";}
                        elseif ($dentistNangarharText==true){ echo "dentists in Nangarhar";}
                        elseif ($eyeNangarharText==true){ echo "eye specialists in Nangarhar";}
                        elseif ($skinNangarharText==true){ echo "skin specialists in Nangarhar";}
                        elseif ($gyneNangarharTezt==true){ echo "gynecologists in Nangarhar";}
                        elseif ($plasticNangarharText==true){ echo "plastic surgeons in Nangarhar";}
                        elseif ($cardiologistNangarharText==true){ echo "cardiologists in Nangarhar";}
                        elseif ($hospitalsNangarharText==true){ echo "hospitals in Nangarhar";}
                        elseif ($entNangarharText==true){ echo "ent specialists in Nangarhar";}
                        elseif ($childNangarharText==true){ echo "child specialists in Nangarhar";}
                        elseif ($orthopedicNangarharText==true){ echo "orthopedics surgeons in Nangarhar";}

                        elseif ($doctorkandaharText==true){ echo "doctors in Kandahar";}
                        elseif ($dentistKandaharText==true){ echo "dentists in Kandahar";}
                        elseif ($eyeKandaharText==true){ echo "eye specialists in Kandahar";}
                        elseif ($skinKandaharText==true){ echo "skin specialists in Kandahar";}
                        elseif ($gyneKandaharTezt==true){ echo "gynecologists in Kandahar";}
                        elseif ($plasticKandaharText==true){ echo "plastic surgeons in Kandahar";}
                        elseif ($cardiologistKandaharText==true){ echo "cardiologists in Kandahar";}
                        elseif ($hospitalsKandaharText==true){ echo "hospitals in Kandahar";}
                        elseif ($entKandaharText==true){ echo "ent specialists in Kandahar";}
                        elseif ($childKandaharText==true){ echo "child specialists in Kandahar";}
                        elseif ($orthopedicKandaharText==true){ echo "orthopedics surgeons in Kandahar";}

                        elseif ($eyeLogarText==true){ echo "eye specialists in Logar";}
                        elseif ($skinHeratText==true){ echo "skin specialists in Herat";}
                        elseif ($gyneKhostText==true){ echo "gynecologists in Khost";}
                        elseif ($hospitalPaktiaText==true){ echo "hospitals in Paktia";}
                        elseif ($cardiologistGhazniText==true){ echo "cardiologists in Ghazni";}
                        elseif ($hospitalsLogarText==true){ echo "hospitals in Logar";}
                        elseif ($entLaghmanText==true){ echo "ent specialists in Laghman";}
                        elseif ($childPaktiaText==true){ echo "child specialists in Paktia";}
                        elseif ($orthopedicPaktiaText==true){ echo "orthopedics surgeons in Paktia";}

                        ?></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->
    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">

                        <!-- Search Filter -->
                        <form action="search.php" method="get">
                        <div class="card search-filter">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Search Filter</h4>
                            </div>
                            <div class="card-body">
                                <div class="filter-widget">

                                </div>
                                <div class="filter-widget">
                                    <h4>Gender</h4>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="gender" value="male">
                                            <span class="checkmark"></span> Male Doctor
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="gender" value="female">
                                            <span class="checkmark"></span> Female Doctor
                                        </label>
                                    </div>
                                </div>
                                <div class="filter-widget">
                                    <h4>Select Specialist</h4>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="specialist" value="primary care">
                                            <span class="checkmark"></span> Primary Care
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="specialist" value="urology">
                                            <span class="checkmark"></span> Urology
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="specialist" value="neurology">
                                            <span class="checkmark"></span> Neurology
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="specialist" value="dentist">
                                            <span class="checkmark"></span> Dentist
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="specialist" value="orthopedic">
                                            <span class="checkmark"></span> Orthopedic
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="specialist" value="cardiology">
                                            <span class="checkmark"></span> Cardiologist
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="specialist" value="eye">
                                            <span class="checkmark"></span> Eye
                                        </label>
                                    </div>
                                </div>
                                <div class="filter-widget">
                                    <h4>Province</h4>
                                    <select class="select" name="province">
                                        <option>Select</option>
                                        <option>Kabul</option>
                                        <option>Nangarhar</option>
                                        <option>Kandahar</option>
                                        <option>Logar</option>
                                        <option>Paktia</option>
                                        <option>Paktika</option>
                                        <option>Ghazni</option>
                                        <option>Mazar e shreef</option>
                                        <option>Herat</option>
                                        <option>Khoast</option>
                                        <option>Laghman</option>
                                    </select>
                                </div>
                                <div class="btn-search">
                                    <button type="submit" name="search" class="btn btn-block bg-success">Search</button>
                                </div>
                            </div>
                        </div>
                        <!-- /Search Filter -->
                    </form>
                </div>
                <div class="col-md-12 col-lg-8 col-xl-9">
                    <?php
                        while($row=$selectAllDoctorRecords->fetch_array()) {
                            $doc_id=$row['doc_id'];

                            $user_id=$row['user_id'];


                            $selectDoctorProfileDetails=$con->query("select * from doctorprofile where user_id='$user_id'");
                            $selectProfileDetails=$selectDoctorProfileDetails->fetch_array();
                            $doctorImage=$con->query("select file_name from pictures where user_id='$user_id'")->fetch_array()['file_name'];



                            ?>
                            <!-- Doctor Widget -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="doctor-widget">
                                        <div class="doc-info-left">
                                            <div class="doctor-img">
                                                <a href="doctor-profile.php?doc_id=<?php  echo $doc_id; ?>">
                                                    <img src="assets/img/doctors/<?=$doctorImage?>" class="img-fluid"
                                                         alt="Doctor Image">
                                                </a>
                                            </div>
                                            <div class="doc-info-cont">
                                                <h4 class="doc-name"><a href="doctor-profile.php?doc_id=<?php  echo $doc_id; ?>">Dr. <?php echo $row['doc_firstName']." ".$row['doc_lastName'];  ?></a></h4>
                                                <p class="doc-speciality"> <?php echo $row['doc_specialization']  ?>,
                                                    <?php  echo $row['doc_qualification']; ?> </p>
                                                <h5 class="doc-department"><?php echo $row['doc_specialization'];

                                                ?> </h5>

                                                <div class="clinic-services mt-4">
                                                    <?php  $doctorServices=$selectProfileDetails['profile_services'];
                                                            $docServices=explode(",",$doctorServices);

                                                     for ($i=0;$i<sizeof($docServices);$i++){
                                                    ?>
                                                        <span> <?php echo $docServices[$i];   ?> </span>
                                                    <?php  } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="doc-info-right">
                                            <div class="clini-infos">
                                                <ul>
                                                    <li><i class="fas fa-check"></i> <?php  echo $row['doc_status']; ?> by MOHA</li>

                                                    <li title="Location"><i class="fas fa-map-marker-alt"
                                                                            data-toggle="tooltip" title="Location"></i>
                                                        <?php
                                                            echo $row['doc_location'];
                                                        ?>
                                                    </li>
                                                    <li><i class="far fa-money-bill-alt"></i> <?php echo $selectProfileDetails['profile_fees'];  ?>-Afg <i
                                                            class="fas fa-info-circle" data-toggle="tooltip"
                                                            title="Fees"></i></li>

                                                </ul>
                                            </div>
                                            <div class="clinic-booking">
                                                <a class="view-pro-btn" href="doctor-profile.php?doc_id=<?php  echo $doc_id; ?>">View Profile</a>
                                                <a class="apt-btn" href="appointmentBooking.php?doc_id=<?php  echo $doc_id; ?>">Appointment </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Doctor Widget -->
                            <?php
                        }
                    ?>

                </div>


            </div>

        </div>
    </div>
    <!--/Page Content-->

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
                                <li><a href="search.php?haveaccount"><i class="fas fa-angle-double-right"></i> Login</a></li>
                                <li><a href="search.php?registerLink"><i class="fas fa-angle-double-right"></i> Register</a></li>
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
                                <li><a href="doctor-dashboard.html"><i class="fas fa-angle-double-right"></i>Check Appointments</a></li>

                                <li><a href="search.php?haveaccount"><i class="fas fa-angle-double-right"></i> Login</a></li>
                                <li><a href="search.php?doctorLink" ><i class="fas fa-angle-double-right"></i> Register</a></li>
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
                                            <form action="search.php" method="post">

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
                                                    <a class="forgot-link" href="search.php?forgotpassword">Forgot Password ?</a>
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
                                                <h3>Patient Register <a href="search.php?doctorLink">Are you a Doctor?</a></h3>
                                            </div>

                                            <!-- Register Form -->
                                            <form action="search.php" method="post">
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
                                                    <a class="forgot-link" href="search.php?haveaccount">Already have an account?</a>
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
                                                <h3>Doctor Register <a href="search.php?registerLink">Not a Doctor?</a></h3>
                                            </div>

                                            <!--Doctor Register Form -->
                                            <form action="search.php" method="post">
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
                                                    <a class="forgot-link" href="search.php?haveaccount">Already have an account?</a>
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
                                            <form action="search.php" method="post">
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
<!--         External Sources         -->
<!-------------------------------------->


<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Sticky Sidebar JS -->

<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

<!-- Select2 JS -->
<script src="assets/plugins/select2/js/select2.min.js"></script>

<!-- Datetimepicker JS -->
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

<!-- Fancybox JS -->
<script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>

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