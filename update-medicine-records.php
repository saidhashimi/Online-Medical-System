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
$medicineRecordRow=null;
$viewMedicineRecord=false;
$viewMedicineRecordEmpty=false;
$viewMedicineRecord=false;
$chkRowsCount=0;

$updateRecordArea=false;
$updateRecordValues=null;
$updateSuccess=false;
$updateNotSuccess=false;
$updateMedicineRecordSuccess=false;
$updateMedicineRecordNotSuccess=false;


$medicineList=$con->query("select * from medicineindustry");
$checkRows=mysqli_num_rows($medicineList);

$msgN=false;
$msgC=false;
$msgName=false;
$msgCompany=false;


if ((isset($_REQUEST['update'])) ){


    $updateRecordArea=true;
    $medicineID=$_REQUEST['update'];
    $doctorRecordRow=$con->query("select * from medicineindustry where medicine_id='$medicineID'");


    $updateRecordValues=$doctorRecordRow->fetch_array();

}

elseif (isset($_REQUEST['viewbyid'])){


    $view=true;
    $medicineID=$_REQUEST['med_id'];
    $medicineRecordRow=$con->query("select * from medicineindustry where medicine_id='$medicineID'");
    $chkRowsCount=mysqli_num_rows($medicineRecordRow);



    if ($chkRowsCount==0){
        $viewMedicineRecordEmpty=true;
    }
    else {
        $viewMedicineRecord = true;
        $viewMedicineRecord=true;
    }


}
elseif (isset($_REQUEST['viewbymedicinename'])){
    $view=true;
    $medName=$_REQUEST['medName'];
    $medicineRecordRow=$con->query("select * from medicineindustry where medicine_name='$medName'");
    $chkRowsCount=mysqli_num_rows($medicineRecordRow);


    if (!preg_match("/^[a-zA-Z ]*$/",$medName)){
        $msgName=true;
    }
    elseif ($chkRowsCount==0){
        $viewMedicineRecordEmpty=true;
    }
    else {
        $viewMedicineRecord = true;
        $viewMedicineRecord=true;
    }

}

elseif (isset($_REQUEST['viewbycompanyname'])){
    $view=true;
    $comName=$_REQUEST['comName'];
    $medicineRecordRow=$con->query("select * from medicineindustry where company_name='$comName'");
    $chkRowsCount=mysqli_num_rows($medicineRecordRow);


    if (!preg_match("/^[a-zA-Z ]*$/",$comName)){
        $msgCompany=true;
    }
    elseif ($chkRowsCount==0){
        $viewMedicineRecordEmpty=true;
    }
    else {
        $viewMedicineRecord = true;
        $viewMedicineRecord=true;
    }
}
elseif (isset($_REQUEST['cancel'])){
    $view=true;
}
elseif (isset($_REQUEST['updateRecord'])){

    $id=$_REQUEST['id'];
    $medicinename=$_REQUEST['medicinename'];

    $companyname=$_REQUEST['companyname'];
    $updateRecordArea=true;

    $chckN=true;
    $chckC=true;

    if (!preg_match("/^[a-zA-Z ]*$/",$medicinename)){
        $msgN=true;
        $chckN=false;

    }if (!preg_match("/^[a-zA-Z ]*$/",$companyname)){
        $msgC=true;
        $chckC=false;
    }if (($chckN==true) && ($chckC==true)) {


        $updateQuery = "update medicineindustry set medicine_name='$medicinename',company_name='$companyname',medicine_status='Approved' where medicine_id='$id'";

        if ($con->query($updateQuery) == true) {
            header("location: update-medicine-records.php?success");
        } else {
            header("location: update-medicine-records.php?notsuccess");

        }
    }

}
elseif (isset($_REQUEST['updatebyView'])){
    $updateRecordArea=true;
    $view=true;
    $medicineID=$_REQUEST['updatebyView'];
    $medicineRecordRow=$con->query("select * from medicineindustry where medicine_id='$medicineID'");





    $updateRecordValues=$medicineRecordRow->fetch_array();

}
elseif (isset($_REQUEST['success'])){
    $updateMedicineRecordSuccess=true;
}
elseif(isset($_REQUEST['notsuccess'])){
    $updateMedicineRecordNotSuccess=true;
}
elseif (isset($_REQUEST['cancelRecord'])){
    $updateRecordArea=false;
}



?>


<html>
<head>
    <meta charset="utf-8">
    <title>Update Medicine Records - MOHA</title>


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
                            <li>
                                <a href="update-hospital-records.php">Hospital Records</a>
                            </li>
                            <li>
                                <a href="update-clinic-records.php">Clinic Records</a>
                            </li>
                            <li>
                                <a href="update-medical-records.php">Medical Stores Rec</a>
                            </li>
                            <li class="active">
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
                    <div style="margin-left: 30%;color: green;font-weight: 700; display: <?php if ($updateMedicineRecordSuccess==false){ echo "none";}  ?>">
                        <span>  <i class="fas fa-check" style="margin-right: 3px"></i>
                            Medicine Record Updated Successfully!!
                        </span>
                    </div>
                    <div style="margin-left: 35%;color: red;font-weight: 700; ;display: <?php if ($updateMedicineRecordNotSuccess==false){ echo "none";}  ?>">
                        <span>  <i class="far fa-window-close" style="margin-right: 3px"></i>

                            Medicine Record Not Updated !!

                        </span>
                    </div>
                    <div style="margin-left: 30%;color: green;font-weight: 700; display: <?php if ($viewMedicineRecord==false){ echo "none";}  ?>">


                        <span>  <i class="fas fa-check" style="margin-right: 3px"></i><?php if (isset($_REQUEST['medicineID'])){?> Medicine Record By  Search ID = <?php echo $_REQUEST['med_id']; } ?>
                            <?php if (isset($_REQUEST['medicineName'])){?> Medicine Record Search  By  Name = <?php echo $_REQUEST['medName']; ?>   <?php } ?>
                            <?php if (isset($_REQUEST['medicineLocation'])){?> Medicine Record   Search By Location = <?php echo $_REQUEST['comName']; ?>   <?php } ?>
                        </span>
                    </div>
                    <div style="margin-left: 30%;color: red;font-weight: 700; ;display: <?php if ($viewMedicineRecordEmpty==false){ echo "none";}  ?>">
                        <span>  <i class="far fa-window-close" style="margin-right: 3px"></i>

                            <?php if (isset($_REQUEST['medicineID'])){?>  No Medicine Record Avaliable By ID = <?php echo $_REQUEST['med_id']; } ?>
                            <?php if (isset($_REQUEST['medicineName'])){?>  No Medicine Record Avaliable By Name = <?php echo $_REQUEST['medName']; } ?>
                            <?php if (isset($_REQUEST['medicineLocation'])){?>  No Medicine Record Avaliable By Location = <?php echo $_REQUEST['comName']; } ?>

                        </span>
                    </div>
                    <!--Medicine Update Record-->
                    <div class="container-fluid" style="display: <?php if ($updateRecordArea==false){ echo 'none';}  ?>">

                        <div class="row">
                            <form action="update-medicine-records.php" method="post">

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Medicine Updation</h4>
                                        <div class="row form-row">



                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="id" value="<?php echo $updateRecordValues['medicine_id']; if (isset($_REQUEST['updateRecord'])){echo $_REQUEST['id'];}  ?>">
                                                    <label>Medicine Name <span class="text-danger">*</span></label>

                                                    <input type="text" class="form-control" name="medicinename" value="<?php echo $updateRecordValues['medicine_name']; if (isset($_REQUEST['updateRecord'])){echo $_REQUEST['medicinename'];}   ?>" minlength="5" required>
                                                    <small class=" text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Company Name <span class="text-danger">*</span></label>

                                                    <input type="text" class="form-control" name="companyname" value="<?php echo $updateRecordValues['company_name']; if (isset($_REQUEST['updateRecord'])){echo $_REQUEST['companyname'];}  ?>" minlength="3" required>
                                                    <small class="text-muted bg-danger-light msgFirstName <?php if ($msgC==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                                </div>
                                            </div>




                                            <div class="submit-section" style="position: relative; margin-left: 335px;">
                                                <button type="submit" name="updateRecord" class="btn bg-success-light submit-btn">Update</button>
                                                <button type="submit" name="cancelRecord" class="btn bg-danger-light submit-btn">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!--View Button Records-->
                    <div class="table-responsive medicineList2Upadate"  style="display: <?php if($viewMedicineRecord==false){ echo "none"; }  ?>">
                        <form action="update-medicine-records.php" method="post">
                            <table class="table table-hover table-center mb-0">
                                <thead>

                                <tr>
                                    <th>Medicine Name</th>


                                    <th>Company Name</th>

                                    <th>Medicine Status</th>
                                    <th></th>
                                </tr>

                                </thead>

                                <tbody>
                                <?php
                                if ($chkRowsCount==1) {
                                    $medicineRecordRow = $medicineRecordRow->fetch_array();
                                    ?>
                                    <tr class="medicineRowUpdate">
                                        <td>
                                            <h2 class="table-avatar">

                                                <a href="doctor-profile.html"> <?php echo $medicineRecordRow['medicine_name'] ?>
                                                    <span> <?php echo $medicineRecordRow['medicine_id'] ?> </span></a>
                                            </h2>
                                        </td>


                                        <td> <?php echo $medicineRecordRow['company_name'] ?> </td>

                                        <td>
                                            <span class="badge badge-pill bg-success-light"> <?php echo $medicineRecordRow['medicine_status'] ?></span>
                                        </td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <button  name="updatebyView" value=" <?php  echo $medicineRecordRow['medicine_id'];  ?> "  class="btn btn-sm bg-success-light">
                                                    <i class="fas fa-edit"></i> Update
                                                </button>

                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                }
                                elseif ($chkRowsCount>1) {

                                    while ($row = $medicineRecordRow->fetch_array()) {

                                        ?>
                                        <tr class="medicineRowView">
                                            <td>
                                                <h2 class="table-avatar">

                                                    <a href="doctor-profile.html"> <?php echo $row['medicine_name']; ?>
                                                        <span> <?php echo $row['medicine_id'] ?> </span></a>
                                                </h2>
                                            </td>
                                            <td> <?php echo $row['company_name'] ?> </td>

                                            <td>
                                                <span class="badge badge-pill bg-success-light"> <?php echo $row['medicine_status'] ?></span>
                                            </td>
                                            <td class="text-right">
                                                <div class="table-action">
                                                    <button  name="updatebyView" value=" <?php  echo $row['medicine_id'];  ?> "  class="btn btn-sm bg-success-light">
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
                            <a class="nav-link <?php if($view==false){ echo "active"; } ?>" href="#med-update" data-toggle="tab" >Update Medicine Records</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($view==true){ echo "active"; } ?> " href="#med-update-by" data-toggle="tab"><span>Update Medicine Record By</span></a>
                        </li>


                    </ul>
                </div>

                <div class="tab-content">
                    <!--Update medicine Record Tab-->
                    <div id="med-update" class="tab-pane fade show <?php  if ($view==false){ echo "active"; }  ?>">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive medicineListUpdate">
                                    <form action="update-medicine-records.php" method="get">
                                        <table class="table table-hover table-center mb-0">
                                            <thead>
                                            <tr>
                                                <th>Medicine Name</th>
                                                <th>Company Name</th>
                                                <th>Medicine Status</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            while($row=$medicineList->fetch_array()) {
                                                ?>
                                                <tr class="medicineRowView">
                                                    <td>
                                                        <h2 class="table-avatar">

                                                            <a href="doctor-profile.html"> <?php echo $row['medicine_name']; ?>
                                                                <span> <?php echo $row['medicine_id'] ?> </span></a>
                                                        </h2>
                                                    </td>


                                                    <td> <?php echo $row['company_name'] ?> </td>

                                                    <td>
                                                        <span class="badge badge-pill bg-success-light"> <?php echo $row['medicine_status'] ?></span>
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="table-action">
                                                            <button type="submit"  name="update" value=" <?php  echo $row['medicine_id'];  ?> "  class="btn btn-sm bg-success-light">
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
                    <!--/Update Medicine Record Tab-->

                    <!--Medicine View By-->
                    <div id="med-update-by" class="tab-pane fade show medicineListUpdate <?php if ($view==true){ echo "active"; }  ?>">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <form method="post" action="update-medicine-records.php?medicineID" style="position: relative; margin-top: 20px;">
                                    <div class="row form-row">

                                        <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                            <div class="form-group">

                                                <input type="number" class="form-control" placeholder="enter medicine id here.." name="med_id" required>

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
                                <!---View Medicine Record by name-->
                                <form action="update-medicine-records.php?medicineName" method="post">
                                    <div class="row form-row">

                                        <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                            <div class="form-group">

                                                <input type="text" class="form-control <?php if ($msgName==true){echo 'bg-danger-light'; } ?>" placeholder="enter medicine name here.."  value="<?php if (isset($_REQUEST['viewbymedicinename'])){echo $_REQUEST['medName'];} ?>"  name="medName" required>
                                                <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgName==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group" style="position: relative;margin-top: 4px;">
                                                <button  name="viewbymedicinename" class="btn btn-md bg-success-light">
                                                    <i class="far fa-eye"></i> View Record
                                                </button>



                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <!---View Company Record by Name-->
                                <form action="update-medicine-records.php?medicineLocation" method="post">
                                    <div class="row form-row">

                                        <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                            <div class="form-group">

                                                <input type="text" class="form-control <?php if ($msgCompany==true){echo 'bg-danger-light'; } ?>" value="<?php if (isset($_REQUEST['viewbycompanyname'])){echo $_REQUEST['comName'];} ?>"  placeholder="enter company name here.." name="comName" required>
                                                <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgCompany==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group" style="position: relative;margin-top: 4px;">
                                                <button name="viewbycompanyname" class="btn btn-md bg-success-light">
                                                    <i class="far fa-eye"></i> View Record
                                                </button>



                                            </div>
                                        </div>
                                    </div>
                                </form>




                            </div>
                        </div>
                    </div>
                    <!--/Medicine View by-->
                </div>

            </div>
        </div>
    </div>
    <!--/Medicine Update Area-->



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






</body>
</html>