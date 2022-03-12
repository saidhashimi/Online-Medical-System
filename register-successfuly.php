

<?php


    $doc=$_REQUEST['doctor'];
    $hos=$_REQUEST['hospital'];
    $clinic=$_REQUEST['clinic'];
    $medical=$_REQUEST['medical'];
    $medicine=$_REQUEST['medicine'];





?>
<html lang="en">
	

    <head>
            <meta charset="utf-8">
            <title>Registered - Health Guide</title>

        <link href="assets/img/favicon.ico" rel="icon">



        <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
            
            <!-- Fontawesome CSS -->
            <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
            <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
            
            <!-- Main CSS -->
            <link rel="stylesheet" href="assets/css/style.css">
            
        </head>
        <body>
            <!--------------------------------------------->
            <!--            Main Wrapper                 -->
            <!--------------------------------------------->
    
                 <!-- Main Wrapper -->
          <div class="main-wrapper">
           
    
           <!-- Page Content -->
                <div class="content success-page-cont">
                    <div class="container-fluid">
                    
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                            
                                <!-- Success Card -->
                                <div class="card success-card">
                                    <div class="card-body">
                                        <div class="success-cont">
                                            <i class="fas fa-check"></i>
                                            <h3><?php   if($doc){ ?> Doctor <?php } 
                                            elseif($hos){ ?> Hospital <?php } 
                                            elseif($clinic){ ?> Clinic <?php  }  
                                            elseif($medical){ ?> Medical <?php } 
                                            elseif($medicine){
                                            ?> Medicine  <?php }   ?>
                                            
                                            Register Successfully!</h3>

                                      
                                      
                <a <?php  if($doc){  ?> href="doctor-registration.php" <?php  } ?> 
                <?php  if($hos){  ?> href="hospital-registration.php" <?php  } ?>
                <?php  if($clinic){  ?> href="clinic-registration.php" <?php  } ?>
                <?php  if($medical){  ?> href="medical-registration.php" <?php  } ?>
                <?php  if($medicine){  ?> href="medicine-registration.php" <?php  } ?>
                class="btn btn-primary view-inv-btn" style="margin-top: 20px;">Done</a>
                                        </div>
                                        
                                        <!--- OR Line    ---->
                                        <div class="login-or">
								
								        <span class="or-line"></span>
								        <span class="span-or">or</span>
                                        </div>
                                        
                                    <!--    Extra Button   ----->
                                <div class="doctor-actions regDatabase" style=";margin-left:5px">
                                <a  href="doctor-registration.php" class="btn btn-sm bg-success-light" style="width:150px">
									<i class="fas fa-edit"></i> Register Doctors 
								</a>
                                <a style="width:140px" href="delete-doctor.php" class="btn btn-sm bg-danger-light">
									<i class="fas fa-trash-alt"></i> Delete  Doctors 
								</a>
								<a style="width:130px" href="view-doctor-records.php" class="btn btn-sm bg-info-light">
									<i class="far fa-eye"></i> View Doctors 
								</a>
								<a style="width:150px" href="update-doctor-records.php" class="btn btn-sm bg-default-light">
									<i class="fas fa-edit"></i> Update Doctors 
								</a>
        
                            </div>
                            <div class="doctor-actions regDatabase" style="margin-top:20px;margin-left:5px">
                                <a  href="hospital-registration.php" class="btn btn-sm bg-success-light" style="width:150px">
									<i class="fas fa-edit"></i> Register Hospital 
								</a>
                                <a style="width:140px" href="delete-hospital.php" class="btn btn-sm bg-danger-light">
									<i class="fas fa-trash-alt"></i> Delete  Hospital 
								</a>
								<a style="width:130px" href="view-hospital-records.php" class="btn btn-sm bg-info-light" >
									<i class="far fa-eye"></i> View Hospital 
								</a>
								<a style="width:150px" href="update-hospital-records.php" class="btn btn-sm bg-default-light" >
									<i class="fas fa-edit"></i> Update Hospital 
								</a>
        
                            </div>
                            <div class="doctor-actions regDatabase" style="margin-top:20px;margin-left:5px">
                                <a  href="clinic-registration.php" class="btn btn-sm bg-success-light" style="width:150px;">
									<i class="fas fa-edit"></i> Register Clinics.. 
								</a>
                                <a style="width:140px" href="delete-clinic.php" class="btn btn-sm bg-danger-light">
									<i class="fas fa-trash-alt"></i> Delete  Clinics.. 
								</a>
								<a style="width:130px" href="view-clinic-records.php" class="btn btn-sm bg-info-light">
									<i class="far fa-eye"></i> View Clinics.. 
								</a>
								<a style="width:150px" href="update-clinic-records.php" class="btn btn-sm bg-default-light">
									<i class="fas fa-edit"></i> Update Clinics.. 
								</a>
        
                            </div>
                            <div class="doctor-actions regDatabase" style="margin-top:20px;margin-left:5px">
                                <a  href="medical-registration.php" class="btn btn-sm bg-success-light" style="width:150px">
									<i class="fas fa-edit"></i> Register Medical 
								</a>
                                <a style="width:140px" href="delete-medical.php" class="btn btn-sm bg-danger-light">
									<i class="fas fa-trash-alt"></i> Delete  Medical 
								</a>
								<a style="width:130px" href="view-medical-records.php" class="btn btn-sm bg-info-light">
									<i class="far fa-eye"></i> View Medical 
								</a>
								<a style="width:150px" href="update-medical-records.php" class="btn btn-sm bg-default-light">
									<i class="fas fa-edit"></i> Update Medical 
								</a>
        
                            </div>
                            <div class="doctor-actions regDatabase" style="margin-top:20px;margin-left:5px">
                                <a  href="medicine-registration.php" class="btn btn-sm bg-success-light" style="width:150px">
									<i class="fas fa-edit"></i> Register Medicine 
								</a>
                                <a style="width:140px" href="delete-medicine.php" class="btn btn-sm bg-danger-light">
									<i class="fas fa-trash-alt"></i> Delete  Medicine 
								</a>
								<a style="width:130px" href="view-medicine-records.php" class="btn btn-sm bg-info-light">
									<i class="far fa-eye"></i> View Medicine 
								</a>
								<a style="width:150px" href="update-medicine-records.php" class="btn btn-sm bg-default-light">
									<i class="fas fa-edit"></i> Update Medicine 
								</a>
        
                            </div>


                                    </div>
                                </div>
                                <!-- /Success Card -->
                                
                            </div>
                        </div>
                        
                    </div>
                </div>		
                <!-- /Page Content -->
    
           </div>
           <!--/Main Wrapper-->
           
    
    
            <!--------------------------------------------->
            <!--           Modal Parts                   -->
            <!--------------------------------------------->
    
    
    
    
            <!--------------------------------------------->
            <!--            External Sources             -->
            <!--------------------------------------------->
    
            <!-- jQuery -->
            <script src="assets/js/jquery.min.js"></script>
            
            <!-- Bootstrap Core JS -->
            <script src="assets/js/popper.min.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>
            
            <!-- Custom JS -->
            <script src="assets/js/script.js"></script>
        </body>
        </html>