<!------------------------------------------>
<!------      PHP Source Code      --------->
<!------------------------------------------>

<?php
//Database Connection
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


$view=false;
$hospitalRecordRow=null;
$viewHospitalRecord=false;
$viewHospitalRecordEmpty=false;
$viewHospitalRecord=false;
$chkRowsCount=0;

$updateRecordArea=false;
$updateRecordValues=null;
$updateSuccess=false;
$updateNotSuccess=false;
$updateHospitalRecordSuccess=false;
$updateHospitalRecordNotSuccess=false;


$hospitalList=$con->query("select * from hospital");
$checkRows=mysqli_num_rows($hospitalList);

$msgHN=false;
$msgD=false;
$msgL=false;
$msgName=false;
$msgLocation=false;

//////////////////////
$msgLP=false;
$msgLC=false;
$msgLB=false;
$msgE=false;

if ((isset($_REQUEST['update'])) ){


    $updateRecordArea=true;
    $hospitalID=$_REQUEST['update'];
    $doctorRecordRow=$con->query("select * from hospital where hos_id='$hospitalID'");


    $updateRecordValues=$doctorRecordRow->fetch_array();

}

elseif (isset($_REQUEST['viewbyid'])){


    $view=true;
    $hospitalID=$_REQUEST['hos_id'];
    $hospitalRecordRow=$con->query("select * from hospital where hos_id='$hospitalID'");
    $chkRowsCount=mysqli_num_rows($hospitalRecordRow);



    if ($chkRowsCount==0){
        $viewHospitalRecordEmpty=true;
    }
    else {
        $viewHospitalRecord = true;
        $viewHospitalRecord=true;
    }


}
elseif (isset($_REQUEST['viewbyname'])){
    $view=true;
    $hosName=$_REQUEST['hosName'];
    $hospitalRecordRow=$con->query("select * from hospital where hos_name='$hosName'");
    $chkRowsCount=mysqli_num_rows($hospitalRecordRow);


    if (!preg_match("/^[a-zA-Z ]*$/",$hosName)){
        $msgName=true;

    }elseif ($chkRowsCount==0){
        $viewHospitalRecordEmpty=true;
    }
    else {
        $viewHospitalRecord = true;
        $viewHospitalRecord=true;
    }

}

elseif (isset($_REQUEST['viewbylocation'])){
    $view=true;
    $hosLocation=$_REQUEST['hosLocation'];
    $hospitalRecordRow=$con->query("select * from hospital where hos_location like '%$hosLocation%'");
    $chkRowsCount=mysqli_num_rows($hospitalRecordRow);



    if (!preg_match("/^[a-zA-Z ]*$/",$hosLocation)){
        $msgLocation=true;

    }
    elseif ($chkRowsCount==0){
        $viewHospitalRecordEmpty=true;
    }
    else {
        $viewHospitalRecord = true;
        $viewHospitalRecord=true;
    }
}
elseif (isset($_REQUEST['cancel'])){
    $view=true;
}
elseif (isset($_REQUEST['updateRecord'])){

    $id=$_REQUEST['id'];
    $name=$_REQUEST['name'];

    $numberofdept=$_REQUEST['numberofdepartments'];
    $numberofdoctors=$_REQUEST['numberofdoctors'];
    $deptdesc=$_REQUEST['departmentdescription'];

    //////////////////////////////////////////
    $locprovince=$_REQUEST['locprovince'];
    $loccity=$_REQUEST['loccity'];
    $locblock=$_REQUEST['locblock'];
    $location=$locblock.",".$loccity.",".$locprovince;


    $chckH=true;
    $chckD=true;
    $chckL=true;

    //////////////////////////////////////////
    $chckLP=true;
    $chckLC=true;
    $chckLB=true;
    $chckE=true;

    $updateRecordArea=true;


    if (!preg_match("/^[a-zA-Z ]*$/",$name)){
        $msgHN=true;
        $chckH=false;
    }if ($deptdesc!=null){
        $list=explode(",",$deptdesc);

        for ($i=0;$i<sizeof($list);$i++){
            if (!preg_match("/^[a-zA-Z ]*$/",$list[$i])){
                $msgD=true;
                $chckD=false;
            }
        }

    }
    /////////////////////////////////////////////////
    if ($locprovince=="Select"){
        $msgLP=true;
        $chckLP=false;

    }if ($loccity=="Select"){
        $msgLC=true;
        $chckLC=false;

    }if ($locblock=="Select"){
        $msgLB=true;
        $chckLB=false;

    }if (($chckH==true) && ($chckD==true) && ($chckL==true) && ($chckLP==true) && ($chckLB==true) && ($chckLC==true)) {
        $updateQuery = "update hospital set hos_name='$name',hos_numOfDept='$numberofdept',hos_numOfDoctors='$numberofdoctors',hos_deptDesc='$deptdesc',hos_location='$location',hos_status='Approved' where hos_id='$id'";

        if ($con->query($updateQuery) == true) {
            header("location: update-hospital-records.php?success");
        } else {
            header("location: update-hospital-records.php?notsuccess");

        }
    }
}
elseif (isset($_REQUEST['updatebyView'])){
    $updateRecordArea=true;
    $view=true;
    $hospitalID=$_REQUEST['updatebyView'];
    $hospitalRecordRow=$con->query("select * from hospital where hos_id='$hospitalID'");





    $updateRecordValues=$hospitalRecordRow->fetch_array();

}
elseif (isset($_REQUEST['success'])){
    $updateHospitalRecordSuccess=true;
}
elseif(isset($_REQUEST['notsuccess'])){
    $updateHospitalRecordNotSuccess=true;
}
elseif (isset($_REQUEST['cancelRecord'])){
    $updateRecordArea=false;
}



?>


<html>
<head>
    <meta charset="utf-8">
    <title>Update Hospital Records - MOHA</title>


    <link href="assets/img/favicon.png" rel="icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">



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

                    <li class="subMenu5 active">
                        <a href="#updateSubmenu" data-toggle="collapse"  class="dropdown-toggle"><i class="fas fa-edit" style="position: relative; margin-right: 12px;"></i>Update Records</a>
                        <ul class="collapse list-unstyled" id="updateSubmenu">
                            <li>
                                <a href="update-doctor-records.php">Doctor Records</a>
                            </li>
                            <li class="active">
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

    <!--Doctor Update Area-->
    <div class="mohaForms" id="doctorUpdate">

        <div class="card doctor-update">
            <div class="card-body">
                <div class="user-tabs">
                    <div style="margin-left: 30%;color: green;font-weight: 700; display: <?php if ($updateHospitalRecordSuccess==false){ echo "none";}  ?>">
                        <span>  <i class="fas fa-check" style="margin-right: 3px"></i>
                            Hospital Record Updated Successfully!!
                        </span>
                    </div>
                    <div style="margin-left: 35%;color: red;font-weight: 700; ;display: <?php if ($updateHospitalRecordNotSuccess==false){ echo "none";}  ?>">
                        <span>  <i class="far fa-window-close" style="margin-right: 3px"></i>

                            Hospital Record Not Updated !!

                        </span>
                    </div>
                    <div style="margin-left: 30%;color: green;font-weight: 700; display: <?php if ($viewHospitalRecord==false){ echo "none";}  ?>">


                        <span>  <i class="fas fa-check" style="margin-right: 3px"></i><?php if (isset($_REQUEST['hospitalID'])){?> Hospital Record By  Search ID = <?php echo $_REQUEST['hos_id']; } ?>
                            <?php if (isset($_REQUEST['hospitalName'])){?> Hospital Record Search  By  Name = <?php echo $_REQUEST['hosName']; ?>   <?php } ?>
                            <?php if (isset($_REQUEST['hospitalLocation'])){?> Hospital Record   Search By Location = <?php echo $_REQUEST['hosLocation']; ?>   <?php } ?>
                        </span>
                    </div>
                    <div style="margin-left: 30%;color: red;font-weight: 700; ;display: <?php if ($viewHospitalRecordEmpty==false){ echo "none";}  ?>">
                        <span>  <i class="far fa-window-close" style="margin-right: 3px"></i>

                            <?php if (isset($_REQUEST['hospitalID'])){?>  No Hospital Record Avaliable By ID = <?php echo $_REQUEST['hos_id']; } ?>
                            <?php if (isset($_REQUEST['hospitalName'])){?>  No Hospital Record Avaliable By Name = <?php echo $_REQUEST['hosName']; } ?>
                            <?php if (isset($_REQUEST['hospitalLocation'])){?>  No Hospital Record Avaliable By Location = <?php echo $_REQUEST['hosLocation']; } ?>

                        </span>
                    </div>
                    <!--Hospital Update Record-->
                    <div class="container-fluid" style="display: <?php if ($updateRecordArea==false){ echo 'none';}  ?>">

                        <div class="row">
                            <form action="update-hospital-records.php" method="post">

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Hospital Updation</h4>
                                        <div class="row form-row">



                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="id" value="<?php echo $updateRecordValues['hos_id']; if (isset($_REQUEST['updateRecord'])){echo $_REQUEST['id'];}   ?>">

                                                    <label>Hospital Name <span class="text-danger">*</span></label>

                                                    <input type="text" class="form-control" name="name" value="<?php echo $updateRecordValues['hos_name'];  if (isset($_REQUEST['updateRecord'])){echo $_REQUEST['name'];} ?>" maxlength="70" required>
                                                    <div class="d-flex justify-content-between mt-1 ml-2"><small class="text-muted"><span>70</span> characters only</small></div>

                                                    <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgHN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Number of Departments <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="numberofdepartments" value="<?php echo $updateRecordValues['hos_numOfDept'];if (isset($_REQUEST['updateRecord'])){echo $_REQUEST['numberofdepartments'];}   ?>" min="2" max="100" required>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Number of Doctors <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="numberofdoctors" min="5" value="<?php echo $updateRecordValues['hos_numOfDoctors'];if (isset($_REQUEST['updateRecord'])){echo $_REQUEST['numberofdoctors'];}   ?>" required>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Department Description <span class="text-danger">*</span></label>
                                                    <input type="text" data-role="tagsinput" class="input-tags form-control" value="<?php echo $updateRecordValues['hos_deptDesc']; if (isset($_REQUEST['updateRecord'])){echo $_REQUEST['departmentdescription'];}   ?>" name="departmentdescription">
                                                    <small class="form-text text-muted">Note : Type & Press enter to add departments</small>
                                                    <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgD==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                                </div>
                                            </div>


                                            <?php
                                            $llocation=$updateRecordValues['hos_location'];
                                            $list=explode(",",$llocation);

                                            ?>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Location <span class="text-danger">*</span></label>
                                                    <select class="form-control select" name="locprovince" id="locprovince">
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[2]=="Select"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Select'){echo 'selected';}} ?>>Select</option>
                                                        <option value="Kabul" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Kabul"){echo "Selected";}}    if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Kabul'){echo 'selected';}} ?>>Kabul</option>
                                                        <option value="Nangarhar" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Nangarhar"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Nangarhar'){echo 'selected';}} ?>>Nangarhar</option>
                                                        <option value="Konar" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Konar"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Konar'){echo 'selected';}} ?>>Konar</option>
                                                        <option value="Nuristan" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Nuristan"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Nuristan'){echo 'selected';}} ?>>Nuristan</option>
                                                        <option value="Laghman" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Laghman"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Laghman'){echo 'selected';}} ?>>Laghman</option>
                                                        <option value="Balkh" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Balkh"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Balkh'){echo 'selected';}} ?>>Balkh</option>
                                                        <option value="Bamyan" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Bamyan"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Bamyan'){echo 'selected';}} ?>>Bamyan</option>
                                                        <option value="Farah" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Farah"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Farah'){echo 'selected';}} ?>>Farah</option>
                                                        <option value="Ghazni" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Ghazni"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Ghazni'){echo 'selected';}} ?>>Ghazni</option>
                                                        <option value="Herat" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Herat"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Herat'){echo 'selected';}} ?>>Herat</option>
                                                        <option value="Kandahar" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Kandahar"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Kandahar'){echo 'selected';}} ?>>Kandahar</option>
                                                        <option value="Khost" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Khost"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Khost'){echo 'selected';}} ?>>Khost</option>
                                                        <option value="Logar" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Logar"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Logar'){echo 'selected';}} ?>>Logar</option>
                                                        <option value="Paktia" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Paktia"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Paktia'){echo 'selected';}} ?>>Paktia</option>
                                                        <option value="Paktika" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Paktika"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Paktika'){echo 'selected';}} ?>>Paktika</option>
                                                        <option value="Panjshir" <?php if (isset($_REQUEST['update'])){if ($list[2]=="Panjshir"){echo "Selected";}} if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Panjshir'){echo 'selected';}} ?>>Panjshir</option>
















                                                    </select>
                                                    <small class="text-muted ml-2">Province</small>
                                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgLP==false){echo 'd-none';} ?>">select one</small>

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group" style="margin-top: 30px">
                                                    <select class="form-control select" name="loccity" id="loccity">
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="Select"){echo "Selected";}} if (isset($_REQUEST['loccity'])){  if ($_REQUEST['loccity']=='Select'){echo 'selected';}} ?>>Select</option>
                                                        <?php
                                                        if ((isset($_REQUEST['update'])) || (isset($_REQUEST['loccity']))){
                                                            ?>
                                                            <option <?php if (isset($_REQUEST['update'])){echo "Selected";} if (isset($_REQUEST['loccity'])){  echo 'selected';} ?>><?php if (isset($_REQUEST['update'])){echo $list[1];}else {echo $_REQUEST['loccity'];}?></option>

                                                            <?php
                                                        }
                                                        ?>

                                                    </select>
                                                    <small class="text-muted ml-2">City</small>
                                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgLC==false){echo 'd-none';} ?>">Select a city</small>

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group" style="margin-top: 30px">
                                                    <select class="form-control select  " name="locblock">
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="Select"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='Select'){echo 'selected';}} ?>>Select</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="01 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='01 Block'){echo 'selected';}} ?>>01 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="02 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='02 Block'){echo 'selected';}} ?>>02 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="03 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='03 Block'){echo 'selected';}} ?>>03 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="04 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='04 Block'){echo 'selected';}} ?>>04 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="05 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='05 Block'){echo 'selected';}} ?>>05 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="06 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='06 Block'){echo 'selected';}} ?>>06 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="07 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='07 Block'){echo 'selected';}} ?>>07 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="08 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='08 Block'){echo 'selected';}} ?>>08 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="09 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='09 Block'){echo 'selected';}} ?>>09 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="10 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='10 Block'){echo 'selected';}} ?>>10 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="11 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='11 Block'){echo 'selected';}} ?>>11 Block</option>
                                                        <option <?php if (isset($_REQUEST['update'])){if ($list[0]=="12 Block"){echo "Selected";}} if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='12 Block'){echo 'selected';}} ?>>12 Block</option>


                                                    </select>
                                                    <small class="text-muted ml-2">Block No</small>
                                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgLB==false){echo 'd-none';} ?>">Select a block</small>

                                                </div>
                                            </div>




                                            <div class="submit-section" style="position: relative; margin-left: 335px;">
                                                <button type="submit" name="updateRecord" class="btn bg-success-light submit-btn">Update</button>
                                                <a href="update-hospital-records.php" class="btn submit-btn bg-danger-light"> Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!--View Button Records-->
                    <div class="table-responsive hospitalList2Upadate"  style="display: <?php if($viewHospitalRecord==false){ echo "none"; }  ?>">
                        <form action="update-hospital-records.php" method="post">
                            <table class="table table-hover table-center mb-0">
                                <thead>

                                <tr>
                                    <th>Hospital Name</th>

                                    <th>No. of Depts</th>
                                    <th>No. of Doctors</th>
                                    <th>Dept. Desc.</th>
                                    <th>Location</th>

                                    <th>Hospital Status</th>
                                    <th></th>
                                </tr>

                                </thead>

                                <tbody>
                                <?php
                                if ($chkRowsCount==1) {
                                    $hospitalRecordRow = $hospitalRecordRow->fetch_array();
                                    ?>
                                    <tr class="hospitalRowUpdate">
                                        <td>
                                            <h2 class="table-avatar">

                                                <a href="doctor-profile.html"> <?php echo $hospitalRecordRow['hos_name'] ?>
                                                    <span> <?php echo $hospitalRecordRow['hos_id'] ?> </span></a>
                                            </h2>
                                        </td>
                                        <td> <?php echo $hospitalRecordRow['hos_numOfDept'] ?></td>
                                        <td> <?php echo $hospitalRecordRow['hos_numOfDoctors'] ?> </td>
                                        <td> <?php echo $hospitalRecordRow['hos_deptDesc'] ?> </td>
                                        <td> <?php echo $hospitalRecordRow['hos_location'] ?> </td>

                                        <td>
                                            <span class="badge badge-pill bg-success-light"> <?php echo $hospitalRecordRow['hos_status'] ?></span>
                                        </td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <button  name="updatebyView" value=" <?php  echo $hospitalRecordRow['hos_id'];  ?> "  class="btn btn-sm bg-success-light">
                                                    <i class="fas fa-edit"></i> Update
                                                </button>

                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                }
                                elseif ($chkRowsCount>1) {

                                    while ($row = $hospitalRecordRow->fetch_array()) {

                                        ?>
                                        <tr class="hospitalRowView">
                                            <td>
                                                <h2 class="table-avatar">

                                                    <a href="doctor-profile.html">Dr. <?php echo $row['hos_name']; ?>
                                                        <span> <?php echo $row['hos_id'] ?> </span></a>
                                                </h2>
                                            </td>
                                            <td> <?php echo $row['hos_numOfDept'] ?></td>
                                            <td> <?php echo $row['hos_numOfDoctors'] ?> </td>
                                            <td> <?php echo $row['hos_deptDesc'] ?> </td>
                                            <td> <?php echo $row['hos_location'] ?> </td>

                                            <td>
                                                <span class="badge badge-pill bg-success-light"> <?php echo $row['hos_status'] ?></span>
                                            </td>
                                            <td class="text-right">
                                                <div class="table-action">
                                                    <button  name="updatebyView" value=" <?php  echo $row['hos_id'];  ?> "  class="btn btn-sm bg-success-light">
                                                        <i class="fas fa-edit"></i> Update
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                                <tr></tr>

                            </table>


                            <button name="cancel" type="submit" class="btn btn-md bg-primary cancelButton" style="width: 78%;margin:10px 100px;">Cancel</button>
                        </form>
                    </div>
                    <!--/View Button Records-->
                    <ul class="nav nav-tabs nav-tabs-bottom nav-justified flex-wrap">
                        <li class="nav-item">
                            <a class="nav-link <?php if($view==false){ echo "active"; } ?>" href="#hos-update" data-toggle="tab" >Update Clinics Records</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($view==true){ echo "active"; } ?> " href="#hos-update-by" data-toggle="tab"><span>Update Hospital Record By</span></a>
                        </li>


                    </ul>
                </div>

                <div class="tab-content">
                    <!--Update hospital Record Tab-->
                    <div id="hos-update" class="tab-pane fade show <?php  if ($view==false){ echo "active"; }  ?>">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive hospitalListUpdate">
                                    <form action="update-hospital-records.php" method="get">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>Hospital Name</th>

                                            <th>No. of Depts</th>
                                            <th>No. of Doctors</th>
                                            <th>Dept. Desc.</th>
                                            <th>Location</th>

                                            <th>Hospital Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        while($row=$hospitalList->fetch_array()) {
                                            ?>
                                            <tr class="hospitalRowView">
                                                <td>
                                                    <h2 class="table-avatar">

                                                        <a href="doctor-profile.html"> <?php echo $row['hos_name']; ?>
                                                            <span> <?php echo $row['hos_id'] ?> </span></a>
                                                    </h2>
                                                </td>
                                                <td> <?php echo $row['hos_numOfDept'] ?></td>
                                                <td> <?php echo $row['hos_numOfDoctors'] ?> </td>
                                                <td> <?php echo $row['hos_deptDesc'] ?> </td>
                                                <td> <?php echo $row['hos_location'] ?> </td>

                                                <td>
                                                    <span class="badge badge-pill bg-success-light"> <?php echo $row['hos_status'] ?></span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="table-action">
                                                        <button type="submit"  name="update" value=" <?php  echo $row['hos_id'];  ?> "  class="btn btn-sm bg-success-light">
                                                            <i class="fas fa-edit"></i> Update
                                                        </button>

                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>


                                        </tbody>

                                    </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/Update Hospital Record Tab-->

                    <!--Hospital View By-->
                    <div id="hos-update-by" class="tab-pane fade show hospitalListUpdate <?php if ($view==true){ echo "active"; }  ?>">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <form method="post" action="update-hospital-records.php?hospitalID" style="position: relative; margin-top: 20px;">
                                    <div class="row form-row">

                                        <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                            <div class="form-group">

                                                <input type="number" class="form-control" placeholder="enter hospital id here.." name="hos_id" required>

                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group" style="position: relative;margin-top: 4px;">
                                                <button name="viewbyid" class="btn btn-md bg-success-light">
                                                    <i class="far fa-eye"></i> View Record
                                                </button>



                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!---View Hospital Record by name-->
                                <form action="update-hospital-records.php?hospitalName" method="post">
                                    <div class="row form-row">

                                        <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                            <div class="form-group">

                                                <input type="text" class="form-control <?php if ($msgName==true){echo 'bg-danger-light'; } ?>" placeholder="enter hospital name here.." value="<?php if (isset($_REQUEST['viewbyname'])){echo $_REQUEST['hosName'];} ?>" name="hosName" required>
                                                <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgName==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group" style="position: relative;margin-top: 4px;">
                                                <button  name="viewbyname" class="btn btn-md bg-success-light">
                                                    <i class="far fa-eye"></i> View Record
                                                </button>



                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <!---View Doctor Record by Location-->
                                <form action="update-hospital-records.php?hospitalLocation" method="post">
                                    <div class="row form-row">

                                        <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                            <div class="form-group">

                                                <input type="text" class="form-control <?php if ($msgLocation==true){echo 'bg-danger-light'; } ?>" placeholder="enter hospital location here.." value="<?php if (isset($_REQUEST['hosLocation'])){echo $_REQUEST['hosLocation'];} ?>" name="hosLocation" required>
                                                <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgLocation==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group" style="position: relative;margin-top: 4px;">
                                                <button name="viewbylocation" class="btn btn-md bg-success-light">
                                                    <i class="far fa-eye"></i> View Record
                                                </button>



                                            </div>
                                        </div>
                                    </div>
                                </form>




                            </div>
                        </div>
                    </div>
                    <!--/Hospital View by-->
                </div>

            </div>
        </div>
    </div>
    <!--/Hospital Update Area-->



</div>
<!--/Main Wrapper-->

<!---------------------------------------->
<!--        MODAL AREA                  -->
<!---------------------------------------->




<!---------------------------------------->
<!--        EXTERNAL SOURCES            -->
<!---------------------------------------->

<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>



<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>
<script src="assets/js/MOHA.js"></script>

<!-- Bootstrap Tagsinput JS -->
<script src="assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>


<script type="text/javascript">
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $("#locprovince").change(function () {
            var val = $(this).val();

            if (val == "Kabul") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Bagrami') {echo 'selected';}} ?>>Bagrami</option>                                        <option <?php if (isset($_REQUEST['district'])) {
                    if ($_REQUEST['loccity'] == 'Chahar Asyab') {
                        echo 'selected';
                    }
                } ?>>Chahar Asyab</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Deh Sabz') {
                        echo 'selected';
                    }
                } ?>>Deh Sabz</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Guldara') {
                        echo 'selected';
                    }
                } ?>>Guldara</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Istalif') {
                        echo 'selected';
                    }
                } ?>>Istalif</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'kalakan') {
                        echo 'selected';
                    }
                } ?>>Kalakan</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Kabul') {
                        echo 'selected';
                    }
                } ?>>Kabul</option> ");


            }if (val=="Nangarhar"){
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Achin') {echo 'selected';}} ?>>Achin</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Batikot') {
                        echo 'selected';
                    }
                } ?>>Batikot</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Behsood') {
                        echo 'selected';
                    }
                } ?>>Behsood</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Chaparhar') {
                        echo 'selected';
                    }
                } ?>>Chaparhar</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Dahbala') {
                        echo 'selected';
                    }
                } ?>>Dahbala</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Dara Noor') {
                        echo 'selected';
                    }
                } ?>>Dara Noor</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Jalalabad') {echo 'selected';}} ?>>Jalalabad</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'kama') {echo 'selected';}} ?>>kama</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Lalpoor') {echo 'selected';}} ?>>Lalpoor</option>   ");
            }if (val=="Laghman") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Dawlat Shah') {echo 'selected';}} ?>>Dawlat Shah</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Mihtarlam') {
                        echo 'selected';
                    }
                } ?>>Mihtarlam</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Qarghayi') {
                        echo 'selected';
                    }
                } ?>>Qarghayi</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Badpash') {
                        echo 'selected';
                    }
                } ?>>Badpash</option>");

            }if (val=="Konar") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Asadabad') {echo 'selected';}} ?>>Asadabad</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Dara Noor') {
                        echo 'selected';
                    }
                } ?>>Dara Noor</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Chapa Dara') {
                        echo 'selected';
                    }
                } ?>>Chapa Dara</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Dangam') {echo 'selected';}} ?>>Dangam</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Khas Konar') {echo 'selected';}} ?>>Khas Konar</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Nurgal') {echo 'selected';}} ?>>Nurgal</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Wata Pur') {echo 'selected';}} ?>>Wata Pur</option>");
            }if (val=="Logar") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Mohhamad Agha') {echo 'selected';}} ?>>Mohammad Agha</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Charkh') {
                        echo 'selected';
                    }
                } ?>>Charkh</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Baraki Barak') {
                        echo 'selected';
                    }
                } ?>>Baraki Barak</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Azra') {echo 'selected';}} ?>>Azra</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Khushi') {echo 'selected';}} ?>>Khushi</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Kharwar') {echo 'selected';}} ?>>Kharwar</option>");
            }if (val=="Paktia") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Chamkani') {echo 'selected';}} ?>>Chamkani</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Ghardaz') {
                        echo 'selected';
                    }
                } ?>>Ghardaz</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Said Karam') {
                        echo 'selected';
                    }
                } ?>>Said Karam</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Zazai') {echo 'selected';}} ?>>Zazai</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Zadran') {echo 'selected';}} ?>>Zadran</option>");
            }if (val=="Ghazni") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Deh Yak') {echo 'selected';}} ?>>Deh Yak</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Gelan') {
                        echo 'selected';
                    }
                } ?>>Gelan</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Ghazni') {
                        echo 'selected';
                    }
                } ?>>Ghazni</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Giro') {echo 'selected';}} ?>>Giro</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Jaghori') {echo 'selected';}} ?>>Jaghori</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Nawa') {echo 'selected';}} ?>>Nawa</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Qarabagh') {echo 'selected';}} ?>>Qarabagh</option>");
            }if (val=="Herat") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Ghoryan') {echo 'selected';}} ?>>Ghoryan</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Gulran') {
                        echo 'selected';
                    }
                } ?>>Gulran</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Guzara') {
                        echo 'selected';
                    }
                } ?>>Guzara</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Herat') {echo 'selected';}} ?>>Herat</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Kohsan') {echo 'selected';}} ?>>Kohsan</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Shindand') {echo 'selected';}} ?>>Shindand</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Zinda Jan') {echo 'selected';}} ?>>Zinda Jan</option>");
            }if (val=="Kandahar") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Spinboldak') {echo 'selected';}} ?>>Spinboldak</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Arghistan') {
                        echo 'selected';
                    }
                } ?>>Arghistan</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Shah Walikot') {
                        echo 'selected';
                    }
                } ?>>Shah Walikot</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Arghandab') {echo 'selected';}} ?>>Arghandab</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Maroof') {echo 'selected';}} ?>>Maroof</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Daman') {echo 'selected';}} ?>>Daman</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Zherai') {echo 'selected';}} ?>>Zherai</option>");
            }if (val=="Balkh") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Mazar-i-sharif') {echo 'selected';}} ?>>Mazar-i-sharif</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Hairatan') {
                        echo 'selected';
                    }
                } ?>>Hairatan</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Nahra-i-shahi') {
                        echo 'selected';
                    }
                } ?>>Nahra-i-shahi</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Balkh') {echo 'selected';}} ?>>Balkh</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Chamtal') {echo 'selected';}} ?>>Chamtal</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Sholgar') {echo 'selected';}} ?>>Sholgar</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Kaldar') {echo 'selected';}} ?>>Kaldar</option>");
            }if (val=="Nuristan") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Barq-i Matal') {echo 'selected';}} ?>>Barq-i Matal</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'kamdesh') {
                        echo 'selected';
                    }
                } ?>>Kamdesh</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Mandol') {
                        echo 'selected';
                    }
                } ?>>Mandol</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Nurgram') {echo 'selected';}} ?>>Nurgram</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Parun') {echo 'selected';}} ?>>Parun</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Wama') {echo 'selected';}} ?>>Wama</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Waygal') {echo 'selected';}} ?>>Waygal</option>");
            }if (val=="Bamyan") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Bamyan') {echo 'selected';}} ?>>Bamyan</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'kahmard') {
                        echo 'selected';
                    }
                } ?>>Kahmard</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Panjab') {
                        echo 'selected';
                    }
                } ?>>Panjab</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Sayghan') {echo 'selected';}} ?>>Sayghan</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Shibar') {echo 'selected';}} ?>>Shibar</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Waras') {echo 'selected';}} ?>>Waras</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Yakawlang') {echo 'selected';}} ?>>Yakawlang</option>");
            }if (val=="Farah") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Anar Dara') {echo 'selected';}} ?>>Anar Dara</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Bakwa') {
                        echo 'selected';
                    }
                } ?>>Bakwa</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Farah') {
                        echo 'selected';
                    }
                } ?>>Farah</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Gulistan') {echo 'selected';}} ?>>Gulistan</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Lash Wa') {echo 'selected';}} ?>>Lash Wa</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Khaki Safed') {echo 'selected';}} ?>>Khaki Safed</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Qala i Koh') {echo 'selected';}} ?>>Qala i Koh</option>");
            }if (val=="Khost") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Bak') {echo 'selected';}} ?>>Bak</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Gurbaz') {
                        echo 'selected';
                    }
                } ?>>Gurbaz</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Zazi Miadan') {
                        echo 'selected';
                    }
                } ?>>Zazi Miadan</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Khost Matun') {echo 'selected';}} ?>>Khost Matun</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Mandozayi') {echo 'selected';}} ?>>Mandozayi</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Qalandar') {echo 'selected';}} ?>>Qalandar</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Sabari') {echo 'selected';}} ?>>Sabari</option>");
            }if (val=="Paktika") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Urgon') {echo 'selected';}} ?>>Urgon</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Zarghon') {
                        echo 'selected';
                    }
                } ?>>Zarghon</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Tarwe') {
                        echo 'selected';
                    }
                } ?>>Tarwe</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Naka') {echo 'selected';}} ?>>Naka</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Jani Khil') {echo 'selected';}} ?>>Jani Khil</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Mata Khan') {echo 'selected';}} ?>>Mata Khan</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Saroza') {echo 'selected';}} ?>>Saroza</option>");
            }if (val=="Panjshir") {
                $('#loccity').html("<option <?php if (isset($_REQUEST['loccity'])){if ($_REQUEST['loccity'] == 'Khenj') {echo 'selected';}} ?>>Khenj</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Paryan') {
                        echo 'selected';
                    }
                } ?>>Paryan</option>                                        <option <?php if (isset($_REQUEST['loccity'])) {
                    if ($_REQUEST['loccity'] == 'Rokha') {
                        echo 'selected';
                    }
                } ?>>Rokha</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Anaba') {echo 'selected';}} ?>>Anaba</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Bazarak') {echo 'selected';}} ?>>Bazarak</option><option <?php if (isset($_REQUEST['loccity'])) {if ($_REQUEST['loccity'] == 'Dara') {echo 'selected';}} ?>>Dara</option>");
            }



        });

    });


</script>


</body>
</html>