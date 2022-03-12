<?php
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
				<li class="active">
					
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

		<!--Dashboard Comonents List-->
		<div class="listOfComponents" id="listOfComponents">
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Looking for ?</h3>
					
					</div>
				</div>
			</div>
        </div>

    <!--Doctor View Area-->
    <div class="mohaForms" id="doctorView">

        <div class="card doctor-view">
            <div class="card-body">
                <div class="user-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom nav-justified flex-wrap">
                        <li class="nav-item">
                            <a class="nav-link active" href="#doc-view" data-toggle="tab">Doctor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#hos-view" data-toggle="tab"><span>Hospitals</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#cli-view" data-toggle="tab"><span>Clinics</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#med-view" data-toggle="tab"><span>Medical Stores</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#medi-view" data-toggle="tab"><span>Medicine Industry</span></a>
                        </li>


                    </ul>
                </div>

                <div class="tab-content">
                    <!--View Doctor Record Tab-->
                    <div id="doc-view" class="tab-pane fade show active">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive doctorListView">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>Doctor</th>
                                            <th style="position: relative;margin-left: 0px;">Spec.</th>
                                            <th>Province</th>
                                            <th>District</th>

                                            <th>Location</th>
                                            <th>Email</th>
                                            <th>Qualification</th>
                                            <th>University</th>
                                            <th>Contact</th>
                                            <th>Gender</th>
                                            <th>Birth</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($row = $selectDoctors->fetch_array()) {

                                        ?>
                                        <tr class="doctorRow">
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="doctor-profile.php?doc_id=<?=$row['doc_id']?>">Dr. <?php echo $row['doc_firstName'] . ' ' . $row['doc_lastName'] ?>
                                                        <span> <?php echo $row['doc_id'] ?> </span></a>
                                                </h2>
                                            </td>
                                            <td> <?php echo $row['doc_specialization'] ?></td>
                                            <td> <?php echo $row['doc_province'] ?> </td>
                                            <td> <?php echo $row['doc_district'] ?> </td>
                                            <td> <?php echo $row['doc_location'] ?> </td>
                                            <td> <?php echo $row['doc_email'] ?> </td>
                                            <td> <?php echo $row['doc_qualification'] ?> </td>
                                            <td> <?php echo $row['doc_university'] ?> </td>
                                            <td> <?php echo $row['doc_contact'] ?> </td>
                                            <td> <?php echo $row['doc_gender'] ?> </td>
                                            <td> <?php echo $row['doc_birth'] ?> </td>
                                            <td>
                                                <span class="badge badge-pill bg-success-light"> <?php echo $row['doc_status'] ?></span>
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
                    <!--/View Doctor Record Tab-->
                    <!--View Hospital Record Tab-->
                    <div id="hos-view" class="tab-pane fade show">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive doctorListView">
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
                                        while ($row = $selectHospitals->fetch_array()) {

                                        ?>
                                        <tr class="hospitalRowView">
                                            <td>
                                                <h2 class="table-avatar">

                                                    <a> <?php echo $row['hos_name']; ?>
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
                    <!--/View Hospital Record Tab-->

                    <!--View Clincs Record Tab-->
                    <div id="cli-view" class="tab-pane fade show">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive doctorListView">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>Clinic Name</th>

                                            <th>Clinic Type</th>
                                            <th>Clinic Location</th>


                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($row = $selectClincs->fetch_array()) {

                                        ?>
                                        <tr class="clinicRowView">
                                            <td>
                                                <h2 class="table-avatar">

                                                    <a> <?php echo $row['clinic_name']; ?>
                                                        <span> <?php echo $row['clinic_id'] ?> </span></a>
                                                </h2>
                                            </td>
                                            <td> <?php echo $row['clinic_type'] ?></td>
                                            <td> <?php echo $row['clinic_location'] ?> </td>


                                            <td>
                                                <span class="badge badge-pill bg-success-light"> <?php echo $row['clinic_status'] ?></span>
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
                    <!--/View Clincs Record Tab-->
                    <!--View Medicals Record Tab-->
                    <div id="med-view" class="tab-pane fade show">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive doctorListView">
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
                                        while ($row = $selectMedicals->fetch_array()) {

                                        ?>
                                        <tr class="medicalRowView">
                                            <td>
                                                <h2 class="table-avatar">

                                                    <a> <?php echo $row['medical_name']; ?>
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
                    <!--/View Medicals Record Tab-->

                    <!--View Medicine Industry Record Tab-->
                    <div id="medi-view" class="tab-pane fade show">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive doctorListView">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>

                                        <tr>
                                            <th>Medicine  Name</th>


                                            <th>Company Name</th>


                                            <th>Medicine Status</th>
                                            <th></th>
                                        </tr>

                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($row = $selectMedicines->fetch_array()) {

                                        ?>
                                        <tr class="medicineRowView">
                                            <td>
                                                <h2 class="table-avatar">

                                                    <a><?php echo $row['medicine_name']; ?>
                                                        <span> <?php echo $row['medicine_id'] ?> </span></a>
                                                </h2>
                                            </td>

                                            <td> <?php echo $row['company_name'] ?> </td>


                                            <td>
                                                <span class="badge badge-pill bg-success-light"> <?php echo $row['medicine_status'] ?></span>
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
                    <!--/View Medicine Industry Record Tab-->
                </div>

            </div>
        </div>
    </div>
    <!--/Doctor View Area-->
			




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