<?php

    require_once ('database-connection.php');
    session_start();
    date_default_timezone_set("Asia/Kabul");
if (!isset($_COOKIE['username'])){
    header("location:index.php?haveaccount");
    return;
}if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}

    $username=$_SESSION['username'];
    $patientDetails=$con->query("select * from users where user_username='$username'")->fetch_array();

    $user_id=$patientDetails['user_id'];

    $patientImage=$con->query("select * from pictures where user_id='$user_id' ")->fetch_array()['file_name'];


    $appointments=$con->query("select * from appointments where user_id='$user_id'");
    $msgDate=false;
    $msgToday=false;
    $showRS=false;
    $messageModal=false;
    $msgBook=false;
    $msgPre=false;
    $msgS=false;



    if(isset($_REQUEST['delete'])){
        $delete=$_REQUEST['delete'];

        mysqli_query($con,"delete from appointments where id='$delete'");
        header("location:patient-dashboard.php?deleted");
        return;

    }elseif (isset($_REQUEST['rs'])){
        $showRS=true;
        $id=$_REQUEST['rs'];

        $rsAppointment=$con->query("select * from appointments where id='$id'")->fetch_array();

    }elseif (isset($_REQUEST['update'])){
        $date=$_REQUEST['date'];
        $oldDate=$_REQUEST['oldDate'];
        $time=$_REQUEST['time'];
        $id=$_REQUEST['id'];



        $todayDate=date("d M Y");
        $date=date("d M Y",strtotime($date));
        $chckDate=true;
        $chckToday=true;
        $chckBook=true;
        $chckPre=true;
        $chckS=true;
        $checkCounter=mysqli_num_rows($con->query("select * from appointments where (date='$date' and time='$time') and (status='approved' or status='unapproved')"));


        $nowTime=date("h:m A");



        if ($date<$todayDate){
            $msgDate=true;
            $chckDate=false;
        }if ($checkCounter>0){
            $endTime=explode("-",$time);
            $endTime=$endTime[1];
            if ($todayDate==$date){
                if ($nowTime<$endTime) {
                    $msgBook=true;
                    $chckBook=false;

                }elseif ($nowTime>$endTime){
                    $msgPre=true;
                    $chckPre=false;
                }

            }else{
                $msgBook=true;
                $chckBook=false;
            }
        }if (($time=="Select a time") || ($time=="No Slots avaliable")){
            $msgS=true;
            $chckS=false;
        }if (($chckDate==true) && ($chckBook==true) && ($chckPre==true) && ($chckS==true)) {
            mysqli_query($con, "update appointments set date='$date',time='$time',status='unapproved' where id='$id'");
            header("location:patient-dashboard.php?rescheduled");
            return;
        }




    }elseif (isset($_REQUEST['msg'])){

        $messageModal=true;

    }elseif (isset($_REQUEST['sendmessage'])){
        $touser=$_REQUEST['touser'];
        $from=$user_id;
        $message=$_REQUEST['message'];

        $date=date("Y-m-d h:i:s");

        if ($con->query("insert into chat_message values ('','$touser','$from','$message','$date','not seen')")){
            header("location:patient-dashboard.php?send");
            return;
        }else{
            header("location:patient-dashboard.php?notsend");
            return;
        }


    }

/*
* Messages Counter
*/
$counterMessages=$con->query("select * from chat_message where to_user_id='$user_id' and status='not seen'");
$counter=mysqli_num_rows($counterMessages);



?>

<html>
<head>
    <meta charset="utf-8">
    <title>Patient Dashboard - Health Guide</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

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
            <ul class="nav header-navbar-rht">
                <!-- User Menu -->
                <li class="nav-item dropdown has-arrow logged-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
									<img class="rounded-circle" src="assets/img/patients/<?=$patientImage?>" width="31" alt="<?=$patientDetails['user_name']?>">
								</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="assets/img/patients/<?=$patientImage?>" alt="Patient Image" class="avatar-img rounded-circle">
                            </div>
                            <div class="user-text">
                                <h6><?=$patientDetails['user_name']?></h6>
                                <p class="text-muted mb-0">Patient</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="patient-dashboard.php">Dashboard</a>
                        <a class="dropdown-item" href="patient-profile-setting.php">Profile Settings</a>
                        <a class="dropdown-item" href="logout.php?patient">Logout</a>
                    </div>
                </li>
                <!-- /User Menu -->

            </ul>
        </nav>


    </header>
    <!--/Header-->

    <!--Page Content-->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Profile Sidebar -->
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    <div class="profile-sidebar">
                        <div class="widget-profile pro-widget-content">
                            <div class="profile-info-widget">
                                <a href="#" class="booking-doc-img">
                                    <img src="assets/img/patients/<?=$patientImage?>" alt="Patient Image">
                                </a>
                                <div class="profile-det-info">
                                    <h3><?=$patientDetails['user_name']?></h3>
                                    <div class="patient-details">

                                        <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?=$patientDetails['user_address']?>, Afghanistan</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-widget">
                            <nav class="dashboard-menu">
                                <ul>
                                    <li class="active">
                                        <a href="patient-dashboard.php">
                                            <i class="fas fa-columns"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="patient-chats.php">
                                            <i class="fas fa-comments"></i>
                                            <span>Message</span>
                                            <small class="unread-msg"><?=$counter?></small>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="patient-profile-setting.php">
                                            <i class="fas fa-user-cog"></i>
                                            <span>Profile Settings</span>
                                        </a>
                                    </li>
                                    <li id="patientPassword">
                                        <a href="patient-change-password.php">
                                            <i class="fas fa-lock"></i>
                                            <span>Change Password</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="patient-delete-account.php">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Delete Account</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="logout.php?patient">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
                <!-- / Profile Sidebar -->
                <!--Dashboard Tab-->
                <div class="col-md-7 col-lg-8 col-xl-9" id="patDashboard">
                    <h4 class="mb-4">Dashboard<small class="float-right btn btn-sm bg-success-light <?php if (!isset($_REQUEST['autologin'])){echo 'd-none'; } ?>">Welcome to dashboard, now your account is approved</small></h4>
                    <div class="card">
                        <div class="card-body pt-0">
                            <!-- Tab Menu -->
                            <nav class="user-tabs mb-4">
                                <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#pat_appointments" data-toggle="tab">Appointments</a>
                                    </li>


                                </ul>
                                <div class="mt-2 ml-2 mb-0 <?php if (!isset($_REQUEST['deleted'])){ echo 'd-none';} ?>">
                                    <span class="btn btn-sm bg-success-light">Deleted Successfully!</span>
                                </div>
                                <div class="mt-2 ml-2 mb-0 <?php if (!isset($_REQUEST['rescheduled'])){ echo 'd-none';} ?>">
                                    <span class="btn btn-sm bg-success-light">Appointment Rescheduled Successfully !</span>
                                </div>
                                <div class="mt-2 ml-2 mb-0 <?php if (!isset($_REQUEST['send'])){ echo 'd-none';} ?>">
                                    <span class="btn btn-sm bg-success-light">Message Sent !</span>
                                </div>
                                <div class="mt-2 ml-2 mb-0 <?php if (!isset($_REQUEST['notsend'])){ echo 'd-none';} ?>">
                                    <span class="btn btn-sm bg-danger-light">Message not sent, try again!</span>
                                </div>
                            </nav>

                            <!-- /Tab Menu -->

                            <!-- Tab Content -->
                            <div class="tab-content pt-0">
                                <!-- Appointment Tab -->
                                <div id="pat_appointments" class="tab-pane fade show active">
                                    <div class="card card-table mb-0">
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <table class="table table-hover table-center mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Doctor Details</th>
                                                        <th>Appointment Date</th>
                                                        <th>Appointment Time</th>
                                                        <th>Location</th>
                                                        <th>Status</th>

                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        while ($row=$appointments->fetch_array()) {
                                                            $doc_user_id=$row['doc_user_id'];
                                                            $doc_id=$con->query("select doc_id from users where user_id='$doc_user_id'")->fetch_array()['doc_id'];


                                                            $doctorDetails=$con->query("select * from doctor where doc_id='$doc_id'")->fetch_array();
                                                            $doctorImage=$con->query("select file_name from pictures where user_id='$doc_user_id'")->fetch_array()['file_name'];

                                                            if ($doc_id!=null){


                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <h2 class="table-avatar">
                                                                        <a href="doctor-profile.php?doc_id=<?=$doctorDetails['doc_id']?>"
                                                                           class="avatar avatar-sm mr-2">
                                                                            <img class="avatar-img rounded-circle"
                                                                                 src="assets/img/doctors/<?=$doctorImage?>"
                                                                                 alt="User Image">
                                                                        </a>
                                                                        <a href="doctor-profile.php?doc_id=<?=$doctorDetails['doc_id']?>">Dr. <?php echo $doctorDetails['doc_firstName']." ".$doctorDetails['doc_lastName']; ?> <span><?=$doctorDetails['doc_specialization']?></span></a>
                                                                    </h2>
                                                                </td>
                                                                <td><?=$row['date']?>
                                                                </td>
                                                                <td><?=$row['time']?></td>
                                                                <td><?=$doctorDetails['doc_location']?></td>
                                                                <td>
                                                                    <span class="badge badge-pill
                                                                            <?php
                                                                        if ($row['status']=='unapproved'){
                                                                            echo "bg-primary-light";
                                                                        }elseif ($row['status']=='deleted')   {
                                                                            echo "bg-danger-light";
                                                                        }elseif ($row['status']=='approved')    {
                                                                            echo "bg-success-light";
                                                                        }
                                                                    ?>
                                                                    "> <?php echo $row['status'] ?></span>
                                                                </td>
                                                                <td class="text-right">
                                                                    <div class="table-action">
                                                                        <a href="patient-dashboard.php?rs=<?=$row['id']?>&doc_user_id=<?=$doc_user_id?>"
                                                                           class="btn btn-sm bg-primary-light <?php if ($row['status']=='deleted'){echo 'disabled';} ?>">
                                                                            <i class="fas fa-clock"></i> Reschedule
                                                                        </a>
                                                                        <a href="patient-dashboard.php?msg&doc_user_id=<?=$doc_user_id?>"
                                                                           class="btn btn-sm bg-success-light">
                                                                            <i class="fas fa-envelope"></i> Message
                                                                        </a>
                                                                        <a href="patient-dashboard.php?delete=<?=$row['id']?>"
                                                                           class="btn btn-sm bg-danger-light">
                                                                            <i class="fas fa-trash"></i> Delete
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <?php
                                                        }else{
                                                                $outside_doc_id=$row['doc_user_id'];
                                                                $email=$con->query("select user_username from users where user_id='$outside_doc_id'")->fetch_array()['user_username'];


                                                                $doctorDetails=$con->query("select * from outsidedoctor where email='$email'")->fetch_array();

                                                                ?>

                                                                <tr>
                                                                    <td>
                                                                        <h2 class="table-avatar">
                                                                            <a href="outside-doctor-profile.php?username=<?=$doctorDetails['email']?>"
                                                                               class="avatar avatar-sm mr-2">
                                                                                <img class="avatar-img rounded-circle"
                                                                                     src="assets/img/doctors/<?=$doctorImage?>"
                                                                                     alt="User Image">
                                                                            </a>
                                                                            <a href="outside-doctor-profile.php?username=<?=$doctorDetails['email']?>">Dr. <?php echo $doctorDetails['firstname']." ".$doctorDetails['lastname']; ?> <span><?=$doctorDetails['specialization']?></span></a>
                                                                        </h2>
                                                                    </td>
                                                                    <td><?=$row['date']?>
                                                                    </td>
                                                                    <td><?=$row['time']?></td>
                                                                    <td><?=$doctorDetails['location']?></td>
                                                                    <td>
                                                                    <span class="badge badge-pill
                                                                            <?php
                                                                    if ($row['status']=='unapproved'){
                                                                        echo "bg-primary-light";
                                                                    }elseif ($row['status']=='deleted')   {
                                                                        echo "bg-danger-light";
                                                                    }elseif ($row['status']=='approved')    {
                                                                        echo "bg-success-light";
                                                                    }
                                                                    ?>
                                                                    "> <?php echo $row['status'] ?></span>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <div class="table-action">
                                                                            <a href="patient-dashboard.php?rs=<?=$row['id']?>&doc_user_id=<?=$doc_user_id?>"
                                                                               class="btn btn-sm bg-primary-light <?php if ($row['status']=='deleted'){echo 'disabled';} ?>">
                                                                                <i class="fas fa-clock"></i> Reschedule
                                                                            </a>
                                                                            <a href="patient-dashboard.php?msg&doc_user_id=<?=$doc_user_id?>"
                                                                               class="btn btn-sm bg-success-light">
                                                                                <i class="fas fa-envelope"></i> Message
                                                                            </a>
                                                                            <a href="patient-dashboard.php?delete=<?=$row['id']?>"
                                                                               class="btn btn-sm bg-danger-light">
                                                                                <i class="fas fa-trash"></i> Delete
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                    <?php


                                                            }

                                                        }
                                                    ?>

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--/Appointment Tab-->




                            </div>
                            <!--/Tab Content-->

                        </div>

                    </div>


                </div>
                <!--/Dashboard Tab-->

                <!--Favourites Tab-->
                <div class="col-md-7 col-lg-8 col-xl-9" id="favouritesTab" style="display: none;">
                    <h4>Favourites</h4>
                    <div class="row row-grid">
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="profile-widget">
                                <div class="doc-img">
                                    <a href="doctor-profile.html">
                                        <img class="img-fluid" alt="User Image" src="assets/img/doctors/doctor-01.jpg">
                                    </a>
                                    <a href="javascript:void(0)" class="fav-btn">
                                        <i class="far fa-bookmark"></i>
                                    </a>
                                </div>
                                <div class="pro-content">
                                    <h3 class="title">
                                        <a href="doctor-profile.html">Muhhamd Sami</a>
                                        <i class="fas fa-check-circle verified"></i>
                                    </h3>
                                    <p class="speciality">MDS - Periodontology </p>

                                    <ul class="available-info">
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i> Kabul, Afghanistan
                                        </li>
                                        <li>
                                            <i class="far fa-clock"></i> Available on Fri, 22 Mar
                                        </li>
                                        <li>
                                            <i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Fees"></i>
                                        </li>
                                    </ul>
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <a href="doctor-profile.html" class="btn view-btn">View Profile</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="appointmentBooking.php" class="btn book-btn">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!--/Favourites Tab-->





            </div>

        </div>
    </div>

    <!---/Page Content-->

</div>
<!--/Main Wrapper-->

<!--Modal-->
<!--Doctor Register Modal Body-->
<div class="modal fade"  id="reschedule">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content loginModal">
            <div class="login-close">
                <button type="button" class="close"  data-dismiss="modal" onclick="loginBody();"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <!--Doctor Register Content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 ">


                                <div class="account-content">
                                    <div class="row align-items-center justify-content-center">

                                        <div class="col-md-12 col-lg-9 login-right">
                                            <div class="login-header">
                                                <h3>Reschedule Appointment</h3>
                                            </div>

                                            <!--Doctor Register Form -->
                                            <form action="patient-dashboard.php" method="post">

                                                <div class="form-group form-focus">
                                                    <input type="hidden"  name="id" value="<?=$id?>">
                                                    <input type="hidden" id="doctorID" name="doctor_user_id" value="<?php if (isset($_REQUEST['rs'])){echo $_REQUEST['doc_user_id'];}elseif (isset($_REQUEST['update'])){echo $_REQUEST['doctor_user_id'];}  ?>">
                                                    <input type="hidden" name="oldDate" value="<?php if (isset($_REQUEST['rs'])){echo $rsAppointment['date'];}elseif (isset($_REQUEST['update'])){echo $_REQUEST['oldDate'];} ?>">
                                                    <input type="date" id="date" onchange="getTime(this.value);" name="date" required class="form-control floating" value="<?php if (isset($_REQUEST['update'])){echo $_REQUEST['date'];} ?>">
                                                    <label class="focus-label">Appointment Date</label>
                                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgDate==false){echo 'd-none';} ?>">No previous date accepted</small>
                                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgToday==false){echo 'd-none';} ?>">This date is already selected</small>

                                                </div>
                                                <div class="form-group form-focus">
                                                    <select id="time" name="time" class="form-control select">
                                                        <option>Select a time</option>
                                                        <option <?php if (isset($_REQUEST['update'])){echo "selected";} ?>><?php if (isset($_REQUEST['update'])){echo $_REQUEST['time'];}?></option>
                                                    </select>
                                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgBook==false){echo 'd-none';} ?>">This slot is already booked</small>
                                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgPre==false){echo 'd-none';} ?>">You can't select previous time slot</small>
                                                    <small class="mt-1 ml-2 bg-danger-light <?php if ($msgS==false){echo 'd-none';} ?>">Select a proper slot for your appointment</small>

                                                </div>



                                                <button class="btn btn-primary btn-block btn-lg login-btn" name="update" type="submit">Reschedule</button>


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

<!--/Modal-->

<!--Message Modal Body-->
<div class="modal fade"  id="messageModal">
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
                                                <h3>Message</h3>
                                                <p class="small text-muted">Your message here</p>
                                            </div>

                                            <!-- Forgot Password Form -->
                                            <form action="patient-dashboard.php" method="post">

                                                <input type="hidden" name="touser" value="<?php echo $_REQUEST['doc_user_id']?>">

                                                <div class="form-group">
                                                    <textarea id="review_desc" rows="5" placeholder="type message here" name="message" maxlength="500" class="form-control" required></textarea>

                                                    <div class="d-flex justify-content-between mt-3"><small class="text-muted"><span id="chars">500</span> characters only</small></div>
                                                </div>

                                                <button class="btn btn-primary btn-block btn-lg login-btn" type="submit" name="sendmessage">Send Message</button>
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

            <!---Message Modal Body-->
        </div>

    </div>

</div>

<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>



<!-- Select2 JS -->
<script src="assets/plugins/select2/js/select2.min.js"></script>

<!-- Datetimepicker JS -->
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>





<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>
<script type="text/javascript">
    function getTime(dd) {
        var select = document.getElementById("time");
        var length = select.options.length;
        for (var i = length-1; i >= 0; i--) {
            select.options[i] = null;
        }

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data=this.responseText;


                var newd=data.split(',');
                var x=document.getElementById("time");


                if (newd.length==1){
                    var option=document.createElement("option");
                    option.text="No Slots avaliable";
                    x.add(option);
                }else{
                    for (var i=0;i<newd.length-1;i++){
                        var option=document.createElement("option");
                        option.text=newd[i];
                        x.add(option);
                    }
                }


            }
        };


        var doc_id=document.getElementById("doctorID").value;
        xmlhttp.open("GET", "getTime.php?date="+dd+"&doc_id="+doc_id, true);
        xmlhttp.send();

    }
</script>


<?php
if ($showRS==true) {
    echo "<script>
        $( '#reschedule' ).modal('show');
      </script> ";
}elseif (isset($_REQUEST['update'])) {
    echo "<script>
        $( '#reschedule' ).modal('show');
      </script> ";
}elseif ($messageModal==true){


    echo "<script>
        $( '#messageModal').modal('show');
      </script> ";
}


?>


</body>
</html>