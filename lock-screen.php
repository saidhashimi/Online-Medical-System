<?php
    require_once ("database-connection.php");
    session_start();

    $type=null;
    $username=null;
    $wrongPassword=false;
    $user=null;

    if (isset($_SESSION['username'])){
        $username=$_SESSION['username'];
        setcookie("user",$username);
        unset($_SESSION['username']);
        setcookie("username", "", time() - 10);
    }

    if (isset($_COOKIE['user'])){
    $username=$_COOKIE['user'];}

    $userDetails=$con->query("select * from users where user_username='$username'")->fetch_array();
    $user_id=$userDetails['user_id'];
    $userImage=$con->query("select file_name from pictures where user_id='$user_id'")->fetch_array()['file_name'];


    if ($userDetails['user_type']=='doctor'){
        $type="doctors";
        $user='doctor';
    }elseif ($userDetails['user_type']=='moha'){
        $type='profiles';
        $user='moha';
    }elseif ($userDetails['user_type']=='super admin'){
        $type='profiles';
        $user='super admin';
    }

    if (isset($_REQUEST['enter'])){
        $password=$_REQUEST['password'];

        if (password_verify($password,$userDetails['user_password'])){
            setcookie("user", "", time() - 10);

            if ($user=='doctor'){

                setcookie("username",$username);
                header("location:doctor-dashboard.php");
                return;
            }elseif ($user=='moha'){
                setcookie("username",$username);
                header("location:moha-dashboard.php");
                return;

            }elseif ($user=='super admin'){
                setcookie("username",$username);
                header("location:./super admin/index.php");
                return;
            }
        }else{
            $wrongPassword=true;
        }




    }




?>


<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Health Guide - Lock Screen</title>

    <link href="assets/img/favicon.png" rel="icon">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">


</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper login-body">
    <div class="login-wrapper">
        <div class="container">
            <div class="loginbox">
                <div class="login-left">
                    <img class="img-fluid" src="assets/img/logo.png" alt="Logo">
                </div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <div class="lock-user">
                            <img class="rounded-circle" src="assets/img/<?=$type?>/<?=$userImage?>" alt="user image">
                            <h1><?=$userDetails['user_name']?></h1>
                        </div>

                        <!-- Form -->
                        <form action="lock-screen.php" method="post">
                            <div class="form-group">
                                <input class="form-control" type="password" name="password" placeholder="Password">
                                <small class="btn btn-sm bg-danger-light mt-2 ml-3 mb-0 <?php if ($wrongPassword==false){echo 'd-none'; }?>"><strong>Invalid Password, Plase try again !</strong></small>

                            </div>
                            <div class="form-group mb-0">
                                <button class="btn btn-primary btn-block" type="submit" name="enter">Enter</button>
                            </div>
                        </form>
                        <!-- /Form -->

                        <div class="text-center dont-have">Sign in as a different user? <a href="login.php">Login</a></div>
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