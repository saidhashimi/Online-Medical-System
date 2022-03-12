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
$medicalRecordRow=null;
$viewMedicalRecord=false;
$viewMedicalRecordEmpty=false;
$viewMedicalRecord=false;
$chkRowsCount=0;

$msgN=false;
$msgP=false;




$medicalList=$con->query("select * from medicals");
$checkRows=mysqli_num_rows($medicalList);

if(isset($_REQUEST['viewbyid'])){


    $view=true;
    $medicalID=$_REQUEST['med_id'];
    $medicalRecordRow=$con->query("select * from medicals where medical_id='$medicalID'");
    $chkRowsCount=mysqli_num_rows($medicalRecordRow);



    if ($chkRowsCount==0){
        $viewMedicalRecordEmpty=true;
    }
    else {
        $viewMedicalRecord = true;
        $viewMedicalRecord=true;
    }


}
elseif (isset($_REQUEST['viewbyname'])){
    $view=true;
    $medName=$_REQUEST['medName'];
    $medicalRecordRow=$con->query("select * from medicals where medical_name like '%$medName%'");
    $chkRowsCount=mysqli_num_rows($medicalRecordRow);


    if (!preg_match("/^[a-zA-Z ]*$/",$medName)){
        $msgN=true;

    }
    elseif ($chkRowsCount==0){
        $viewMedicalRecordEmpty=true;
    }
    else {
        $viewMedicalRecord = true;
        $viewMedicalRecord=true;
    }

}


elseif (isset($_REQUEST['viewbylocation'])){
    $view=true;
    $medLocation=$_REQUEST['medLocation'];
    $medicalRecordRow=$con->query("select * from medicals where medical_location like '%$medLocation%'");
    $chkRowsCount=mysqli_num_rows($medicalRecordRow);


    if ($medLocation=="View by a location"){
        $msgP=true;
    }elseif ($chkRowsCount==0){
        $viewMedicalRecordEmpty=true;
    }
    else {
        $viewMedicalRecord = true;
        $viewMedicalRecord=true;
    }
}
elseif (isset($_REQUEST['cancel'])){
    $view=true;
}





?>


<html>
<head>
    <meta charset="utf-8">
    <title>View Medical Records - MOHA</title>

    <link href="assets/img/favicon.png" rel="icon">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">


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
                            <li>
                                <a href="view-doctor-records.php">Doctor Records</a>
                            </li>
                            <li class="active">
                                <a href="view-hospital-records.php">Hospital Records</a>
                            </li>
                            <li>
                                <a href="view-clinic-records.php">Clinic Records</a>
                            </li>
                            <li>
                                <a href="view-medical-record.php">Medical Stores Rec</a>
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

    <!--Doctor View Area-->
    <div class="mohaForms" id="doctorView">

        <div class="card doctor-view">
            <div class="card-body">
                <div class="user-tabs">
                    <div style="margin-left: 30%;color: green;font-weight: 700; display: <?php if ($viewMedicalRecord==false){ echo "none";}  ?>">
                        <span>  <i class="fas fa-check" style="margin-right: 3px"></i><?php if (isset($_REQUEST['medicalID'])){?> Medical Record By  Search ID = <?php echo $_REQUEST['med_id']; } ?>
                            <?php if (isset($_REQUEST['medicalName'])){?> Medical Record Search  By  Name = <?php echo $_REQUEST['medName']; ?>   <?php } ?>
                            <?php if (isset($_REQUEST['medicalLocation'])){?> Medical Record   Search By Location = <?php echo $_REQUEST['medLocation']; ?>   <?php } ?>

                        </span>
                    </div>
                    <div style="margin-left: 30%;color: red;font-weight: 700; ;display: <?php if ($viewMedicalRecordEmpty==false){ echo "none";}  ?>">
                        <span>  <i class="far fa-window-close" style="margin-right: 3px"></i>

                            <?php if (isset($_REQUEST['medicalID'])){?>  No Medical Record Avaliable By ID = <?php echo $_REQUEST['med_id']; } ?>
                            <?php if (isset($_REQUEST['medicalName'])){?>  No Medical Record Avaliable By Name = <?php echo $_REQUEST['medName']; } ?>
                            <?php if (isset($_REQUEST['medicalLocation'])){?>  No Medical Record Avaliable By Location = <?php echo $_REQUEST['medLocation']; } ?>

                        </span>
                    </div>
                    <!--View Button Records-->
                    <div class="table-responsive medicalList2View"  style="display: <?php if($viewMedicalRecord==false){ echo "none"; }  ?>">
                        <form action="view-medical-records.php" method="post">
                            <table class="table table-hover table-center mb-0">
                                <thead>

                                <tr>
                                    <th>Medical Store Name</th>


                                    <th>Medical Store Location</th>


                                    <th>Status</th>
                                    <th></th>
                                </tr>

                                </thead>

                                <tbody>
                                <?php
                                if ($chkRowsCount==1) {
                                    $medicalRecordRow = $medicalRecordRow->fetch_array();
                                    ?>
                                    <tr class="medicalRowView">
                                        <td>
                                            <h2 class="table-avatar">

                                                <a href="doctor-profile.html"> <?php echo $medicalRecordRow['medical_name'] ?>
                                                    <span> <?php echo $medicalRecordRow['medical_id'] ?> </span></a>
                                            </h2>
                                        </td>

                                        <td> <?php echo $medicalRecordRow['medical_location'] ?> </td>

                                        <td>
                                            <span class="badge badge-pill bg-success-light"> <?php echo $medicalRecordRow['medical_status'] ?></span>
                                        </td>
                                        <td class="text-right">
                                            <div class="table-action">


                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                }
                                elseif ($chkRowsCount>1) {

                                    while ($row = $medicalRecordRow->fetch_array()) {

                                        ?>
                                        <tr class="medicalRowView">
                                            <td>
                                                <h2 class="table-avatar">

                                                    <a href="doctor-profile.html">Dr. <?php echo $row['medical_name']; ?>
                                                        <span> <?php echo $row['medical_id'] ?> </span></a>
                                                </h2>
                                            </td>

                                            <td> <?php echo $row['medical_location'] ?> </td>


                                            <td>
                                                <span class="badge badge-pill bg-success-light"> <?php echo $row['medical_status'] ?></span>
                                            </td>
                                            <td class="text-right">
                                                <div class="table-action">


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
                            <a class="nav-link <?php if($view==false){ echo "active"; } ?>" href="#med-view" data-toggle="tab" >View Medicals Records</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($view==true){ echo "active"; } ?> " href="#med-view-by" data-toggle="tab"><span>View Medical Record By</span></a>
                        </li>


                    </ul>
                </div>

                <div class="tab-content">
                    <!--View Medical Record Tab-->
                    <div id="med-view" class="tab-pane fade show <?php  if ($view==false){ echo "active"; }  ?>">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive medicalListView">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>Medical Store Name</th>


                                            <th>Medical Store Location</th>


                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        while($row=$medicalList->fetch_array()) {
                                            ?>
                                            <tr class="medicalRowView">
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="doctor-profile.html"> <?php echo $row['medical_name']; ?>
                                                            <span> <?php echo $row['medical_id'] ?> </span></a>
                                                    </h2>
                                                </td>


                                                <td> <?php echo $row['medical_location'] ?> </td>

                                                <td>
                                                    <span class="badge badge-pill bg-success-light"> <?php echo $row['medical_status'] ?></span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="table-action">


                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>


                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/View Medical Record Tab-->

                    <!--Medical View By-->
                    <div id="med-view-by" class="tab-pane fade show medicalListView <?php if ($view==true){ echo "active"; }  ?>">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <form method="post" action="view-medical-records.php?medicalID" style="position: relative; margin-top: 20px;">
                                    <div class="row form-row">

                                        <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                            <div class="form-group">

                                                <input type="number" class="form-control" placeholder="enter medical id here.." name="med_id" required>

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
                                <!---View Medical Record by name-->
                                <form action="view-medical-records.php?medicalName" method="post">
                                    <div class="row form-row">

                                        <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                            <div class="form-group">

                                                <input type="text" class="form-control <?php if ($msgN==true){echo "bg-danger-light";} ?>" placeholder="enter medical name here.." value="<?php  if (isset($_REQUEST['medName'])){echo $_REQUEST['medName'];}?>" name="medName" required>
                                                <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">only letters and white spaces allowed</small>

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
                                <form action="view-medical-records.php?medicalLocation" method="post">
                                    <div class="row form-row">

                                        <div class="col-md-6" style="position: relative;margin-left: 20px;">
                                            <div class="form-group">

                                                <select class="form-control select" name="medLocation">
                                                    <option>View by a location</option>
                                                    <option>Kabul</option>
                                                    <option>Nangarhar</option>
                                                    <option>Konar</option>
                                                    <option>Nuristan</option>
                                                    <option>Laghman</option>
                                                    <option>Kabul</option>
                                                    <option>Paktia</option>
                                                    <option>Paktika</option>
                                                    <option>Khost</option>
                                                    <option>Logar</option>
                                                    <option>Ghazni</option>
                                                    <option>Balkh</option>
                                                    <option>Herat</option>
                                                    <option>Panjshir</option>


                                                </select>
                                                <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgP==false){echo 'd-none'; } ?>">Select a location</small>

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
                    <!--/Medical View by-->
                </div>

            </div>
        </div>
    </div>
    <!--/Medical View Area-->



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