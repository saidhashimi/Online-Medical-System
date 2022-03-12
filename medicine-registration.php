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




//Register doctor
    $msgN=false;
    $msgC=false;

    if(isset($_POST['submit'])){
        $medicineName=$_POST['name'];
        $companyName=$_POST['companyName'];

        $status=$_POST['status'];
       
        $chckN=true;
        $chckC=true;

        if (!preg_match("/^[a-zA-Z ]*$/",$medicineName)){
            $msgN=true;
            $chckN=false;

        }if (!preg_match("/^[a-zA-Z ]*$/",$companyName)){
            $msgC=true;
            $chckC=false;
        }if (($chckN==true) && ($chckC==true)) {

            $insert = "insert into medicineindustry values ('','$medicineName','$companyName','$status') ";

            $result = mysqli_query($con, $insert);

            if (!$result) {
                die ("Not registered");
            } else {
                header("location:register-successfuly.php?doctor=&hospital=&clinic=&medical=&medicine=medicine");
            }
        }
	   
	}
       ?>


<html>
<head>
    <meta charset="utf-8">
		<title>Medicine Registration - MOHA</title>


    <link href="assets/img/favicon.png" rel="icon">

    <!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
        

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
				<li class="subMenu2 active">
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
				<li  class="active">
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

<!--Medicine Industry Registration Area-->
<div class="mohaForms" id="medicineRegistration">
				
				<form action="medicine-registration.php" method="post">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Medicine Industry Registration</h4>
						<div class="row form-row">
							
							
							<div class="col-md-6">
								<div class="form-group">
									<label>Medicine Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="name" value="<?php if (isset($_REQUEST['name'])){echo $_REQUEST['name'];}?>" required>
                                    <small class=" text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Company Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="companyName" value="<?php if (isset($_REQUEST['companyName'])){echo $_REQUEST['companyName'];} ?>" required>
                                    <small class="text-muted bg-danger-light msgFirstName <?php if ($msgC==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Status</label>
									<select class="form-control select" name="status">
									
										<option>Approved</option>
										<option>Unapproved</option>
									</select>
								</div>
							</div>
							
							<div class="submit-section" style="position: relative; margin-left: 400px; margin-right: 400px;">
								<button type="submit"name="submit" class="btn btn-primary submit-btn">Register Medicine</button>
								
							</div>
							
							<div class="login-or">
								
								<span class="or-line"></span>
								<span class="span-or">or</span>
							</div>

							<div class="doctor-actions">
								<a href="delete-medicine.php" class="btn btn-sm bg-success-light">
									<i class="fas fa-trash-alt"></i> Delete Medicine Records
								</a>
								<a href="view-medicine-records.php" class="btn btn-sm bg-info-light">
									<i class="far fa-eye"></i> View Medicine Records
								</a>
								<a href="update-medicine-records.php" class="btn btn-sm bg-default-light">
									<i class="fas fa-edit"></i> Update Medicine Records
								</a>
								
								<a href="medicine-registration.php" class="btn btn-sm bg-danger-light">
									<i class="fas fa-times"></i> Cancel Medicine Registration
								</a>

							</div>


						</div>
					</div>
				</div>
			</form>

			</div>

			<!--/Medicine Industry Registration Area-->
		

			

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


<!-- Select2 JS -->
<script src="assets/plugins/select2/js/select2.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>
<script src="assets/js/MOHA.js"></script>



		


</body>
</html>