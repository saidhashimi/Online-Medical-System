<?php
    require_once ("database-connection.php");
    session_start();


    $loginUserNotAvaliable=false;
    $doctorNotAprroved=false;
    $invalidEmail=false;
    $invalidPassword=false;


/*    Login Request          */
if (isset($_REQUEST['login'])){
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];

    $getLoginDetails="select doc_id,user_username,user_password,user_type,user_status from users where user_username='$username'";
    $getPassword=
    $checkAvaliable=mysqli_num_rows($con->query($getLoginDetails));
    $getLogin=$con->query($getLoginDetails)->fetch_array();

    if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$username)){
        $invalidEmail=true;
    }if (strlen($password)<8){
        $invalidPassword=true;
    } elseif ($checkAvaliable==0){
        $loginUserNotAvaliable=true;

    }elseif (($getLogin['user_username']==$username) && (password_verify($password,$getLogin['user_password'])) ){
        if ($getLogin['user_type']=='patient') {
            setcookie("username",$username);
            header("location:patient-dashboard.php");
            return;
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
        }elseif ($getLogin['user_type']=='super admin'){
            setcookie("username",$username);
            header("location:./super admin/index.php");
            return;
        }

    }

    else{
        $loginUserNotAvaliable=true;
    }


}


?>


<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Health Guide - Login</title>

    <link href="assets/img/favicon.png" rel="icon">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper login-body">
    <div class="login-wrapper">
        <div class="container">
            <div class="loginbox">
                <div class="login-left">
                   <a href="index.php"> <img class="img-fluid" src="assets/img/logo.png" alt="Logo"> </a>
                </div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <h1>Login</h1>
                        <p class="account-subtitle">Access to your dashboard</p>

                        <!-- Form -->
                        <form action="login.php" method="post">
                            <div class="form-group">
                                <input class="form-control <?php if ($invalidEmail==true){echo "bg-danger-light";} ?>" type="text" name="username" placeholder="Email / Phone Number" value="<?php if (isset($_REQUEST['username'])){echo $_REQUEST['username']; }  ?>" required>
                                <small class="bg-danger-light ml-1 <?php if ($invalidEmail==false){echo "d-none";} ?>">Type a valid email</small>
                            </div>
                            <div class="form-group">
                                <input class="form-control <?php if ($invalidPassword==true){echo "bg-danger-light"; } ?>" type="password" name="password" placeholder="Password" value="<?php if (isset($_REQUEST['password'])){echo $_REQUEST['password']; }  ?>" required>
                                <small class="bg-danger-light ml-1 <?php if ($invalidPassword==false){echo "d-none";} ?>">Type a valid password</small>


                            </div>
                            <div style="margin-left: 35px;display: <?php if ($loginUserNotAvaliable==false){ echo 'none'; }   ?>;"><h5 style="color:red;" >invalid username and password</h5></div>
                            <div style="margin-left: 60px; display: <?php if ($doctorNotAprroved==false){echo 'none';}  ?>">
                                <span style="color: darkred" class="forgot-link"> <i class="fas fa-door-closed" style="margin-right: 3px"></i> You are not approved yet! </span>

                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" name="login" type="submit" >Login</button>
                            </div>
                        </form>
                        <!-- /Form -->

                        <div class="text-center forgotpass"><a href="index.php?forgotpassword">Forgot Password?</a></div>
                        <div class="login-or">
                            <span class="or-line"></span>
                            <span class="span-or">or</span>
                        </div>



                        <div class="text-center dont-have">Don’t have an account? <a href="patient-signup.php">Register</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Main Wrapper -->

<!-- jQuery -->
<script src="assets/js/jquery-3.2.1.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>

</body>

</html>