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
    $msgL=false;
//////////////////////
$msgLP=false;
$msgLC=false;
$msgLB=false;
$msgSelectCon=false;



    if(isset($_POST['submit'])){
        $medicalName=$_POST['name'];

        $status=$_POST['status'];
        $contact=$_REQUEST['contact'];

        //////////////////////////////////////////
        $locprovince=$_REQUEST['locprovince'];
        $loccity=$_REQUEST['loccity'];
        $locblock=$_REQUEST['locblock'];
        $medicalLocation=$locblock.",".$loccity.",".$locprovince;
       
     $chckN=true;
     $chckL=true;

        //////////////////////////////////////////
        $chckLP=true;
        $chckLC=true;
        $chckLB=true;
        $chckcon=true;
        $chckDigits=true;

        if (!preg_match("/^[a-zA-Z ]*$/",$medicalName)){
            $msgN=true;
            $chckN=false;
        }/////////////////////////////////////////////////
        if ($locprovince=="Select"){
            $msgLP=true;
            $chckLP=false;

        }if ($loccity=="Select"){
            $msgLC=true;
            $chckLC=false;

        }if ($locblock=="Select"){
            $msgLB=true;
            $chckLB=false;

        }if (!preg_match('/^[0-9]{10}+$/',$contact)){
            $msgSelectCon=true;
            $chckcon=false;
            $chckDigits=false;


        }if ($chckDigits==true){

            $subDigit=substr($contact,0,3);

            if (($subDigit=="078") || ($subDigit=="077") || ($subDigit=="076") || ($subDigit=="079") || ($subDigit=="072") || ($subDigit=="070")){
                $msgSelectCon=false;
                $chckcon=true;


            }else{
                $msgSelectCon=true;
                $chckcon=false;

            }

        }if (($chckN==true) && ($chckLP==true) && ($chckLC==true) && ($chckLB==true)) {

            $insert = "insert into medicals values ('','$medicalName','$medicalLocation','$contact','$status') ";

            $result = mysqli_query($con, $insert);

            if (!$result) {
                die ("Not registered");
            } else {
                header("location:register-successfuly.php?doctor=&hospital=&clinic=&medical=medical&medicine=");
            }
        }
	   
	}
       ?>


<html>
<head>
    <meta charset="utf-8">
		<title>Medical Registration - MOHA</title>

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
				  <li class="active">
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

<!--Medical Stores Registration Area-->
<div class="mohaForms" id="medicalRegistration">
				
				<form action="medical-registration.php" method="post">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Medical Stores Registration</h4>
						<div class="row form-row">

							
							
							<div class="col-md-6">
								<div class="form-group">
									<label>Medical Store Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="name" value="<?php if (isset($_REQUEST['name'])){echo $_REQUEST['name'];} ?>" required>
                                    <small class="ml-2 text-muted bg-danger-light msgFirstName <?php if ($msgN==false){echo 'd-none'; } ?>">Only letters and white space allowed</small>

                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Location <span class="text-danger">*</span></label>
                                    <select class="form-control select" name="locprovince" id="locprovince">
                                        <option <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Select'){echo 'selected';}} ?>>Select</option>
                                        <option value="Kabul" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Kabul'){echo 'selected';}} ?>>Kabul</option>
                                        <option value="Nangarhar" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Nangarhar'){echo 'selected';}} ?>>Nangarhar</option>
                                        <option value="Konar" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Konar'){echo 'selected';}} ?>>Konar</option>
                                        <option value="Nuristan" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Nuristan'){echo 'selected';}} ?>>Nuristan</option>
                                        <option value="Laghman" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Laghman'){echo 'selected';}} ?>>Laghman</option>
                                        <option value="Balkh" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Balkh'){echo 'selected';}} ?>>Balkh</option>
                                        <option value="Bamyan" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Bamyan'){echo 'selected';}} ?>>Bamyan</option>
                                        <option value="Farah" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Farah'){echo 'selected';}} ?>>Farah</option>
                                        <option value="Ghazni" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Ghazni'){echo 'selected';}} ?>>Ghazni</option>
                                        <option value="Herat" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Herat'){echo 'selected';}} ?>>Herat</option>
                                        <option value="Kandahar" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Kandahar'){echo 'selected';}} ?>>Kandahar</option>
                                        <option value="Khost" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Khost'){echo 'selected';}} ?>>Khost</option>
                                        <option value="Logar" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Logar'){echo 'selected';}} ?>>Logar</option>
                                        <option value="Paktia" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Paktia'){echo 'selected';}} ?>>Paktia</option>
                                        <option value="Paktika" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Paktika'){echo 'selected';}} ?>>Paktika</option>
                                        <option value="Panjshir" <?php if (isset($_REQUEST['locprovince'])){  if ($_REQUEST['locprovince']=='Panjshir'){echo 'selected';}} ?>>Panjshir</option>

                                    </select>
                                    <small class="text-muted ml-2">Province</small>
                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgLP==false){echo 'd-none';} ?>">select one</small>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 30px">
                                    <select class="form-control select" name="loccity" id="loccity">
                                        <option <?php if (isset($_REQUEST['loccity'])){  if ($_REQUEST['loccity']=='Select'){echo 'selected';}} ?>>Select</option>
                                        <?php
                                        if (isset($_REQUEST['loccity'])){
                                            ?>
                                            <option <?php if (isset($_REQUEST['loccity'])){  echo 'selected';} ?>><?=$_REQUEST['loccity']?></option>

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
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='Select'){echo 'selected';}} ?>>Select</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='01 Block'){echo 'selected';}} ?>>01 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='02 Block'){echo 'selected';}} ?>>02 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='03 Block'){echo 'selected';}} ?>>03 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='04 Block'){echo 'selected';}} ?>>04 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='05 Block'){echo 'selected';}} ?>>05 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='06 Block'){echo 'selected';}} ?>>06 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='07 Block'){echo 'selected';}} ?>>07 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='08 Block'){echo 'selected';}} ?>>08 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='09 Block'){echo 'selected';}} ?>>09 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='10 Block'){echo 'selected';}} ?>>10 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='11 Block'){echo 'selected';}} ?>>11 Block</option>
                                        <option <?php if (isset($_REQUEST['locblock'])){  if ($_REQUEST['locblock']=='12 Block'){echo 'selected';}} ?>>12 Block</option>


                                    </select>
                                    <small class="text-muted ml-2">Block No</small>
                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgLB==false){echo 'd-none';} ?>">Select a block</small>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="contact" value="<?php if (isset($_REQUEST['contact'])){echo $_REQUEST['contact'];} ?>" maxlength="10" required>
                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgSelectCon==false){echo 'd-none';} ?>">Enter a valid Phone Number</small>

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
								<button type="submit" class="btn btn-primary submit-btn" name="submit">Register Medical</button>
								
							</div>
							
							<div class="login-or">
								
								<span class="or-line"></span>
								<span class="span-or">or</span>
							</div>

							<div class="doctor-actions">
								<a href="delete-medical.php" class="btn btn-sm bg-success-light">
									<i class="fas fa-trash-alt"></i> Delete Medical Records
								</a>
								<a href="view-medical-records.php" class="btn btn-sm bg-info-light">
									<i class="far fa-eye"></i> View Medical Records
								</a>
								<a href="update-medical-records.php" class="btn btn-sm bg-default-light">
									<i class="fas fa-edit"></i> Update Medical Records
								</a>
								
								<a href="medical-registration.php" class="btn btn-sm bg-danger-light">
									<i class="fas fa-times"></i> Cancel Medical Registration
								</a>

							</div>


						</div>
					</div>
				</div>
			</form>

			</div>

			<!--/Medical Stores Registration Area-->
			
		

			

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