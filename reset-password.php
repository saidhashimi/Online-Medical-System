<?php
require_once ("database-connection.php");
$wrongConfirmPassword=false;

$speCharacter=true;
$strength=false;
$checkWrong=false;
$checkMatch=false;
$checkStrngth=false;


    if (!isset($_REQUEST['reset'])){
        header("location:index.php?forgotpassword");
        return;
    }elseif ((isset($_REQUEST['newPassword'])) && (isset($_REQUEST['confirmPassword'])) && (isset($_REQUEST['reset']))){

    $username=$_COOKIE['resetusername'];
    $newPassword=$_REQUEST['newPassword'];
    $confirmPassword=$_REQUEST['confirmPassword'];



    $selectOldPassword=$con->query("select user_password from users where user_username='$username'")->fetch_array()['user_password'];

        $uppercase=preg_match("@[A-Z]@",$newPassword);
        $lowercase=preg_match("@[a-z]@",$newPassword);
        $number=preg_match("@[0-9]@",$newPassword);
        $specialCharacters=preg_match("@[^\w]@",$newPassword);


    if ($newPassword!==$confirmPassword){
        $wrongConfirmPassword=true;
    }elseif ($newPassword!=null){
        if (strlen($newPassword)<8){
            $length=false;
            $checkStrngth=true;
        }if (!$uppercase){
            $upCase=false;
            $checkStrngth=true;
        }if (!$lowercase){
            $lowCase=false;
            $checkStrngth=true;
        }if (!$number){
            $num=false;
            $checkStrngth=true;

        }if (!$specialCharacters){
            $speCharacter=false;
            $checkStrngth=true;
        }
        $strength=true;
    }if (($checkStrngth==false) && ($wrongConfirmPassword==false)){
        $newPassword=password_hash($newPassword,PASSWORD_DEFAULT);
        mysqli_query($con,"update users set user_password='$newPassword' where user_username='$username'");
        setcookie("resetusername", "", time() - 10);
        header("location:index.php?haveaccount");
        return;
    }



}else{
        setcookie("resetusername",$_REQUEST['username']);
    }

?>


<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Health Guide - Reset Password</title>

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
                    <img class="img-fluid" src="assets/img/logo.png" alt="Logo">
                </div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <h1>Reset Your Password</h1>

                        <!-- Change Password Form -->
                        <form action="reset-password.php" method="post">

                            <div class="form-group">

                                <input type="password" name="newPassword" class="form-control" placeholder="Enter New Password" value="<?php if (isset($_REQUEST['newPassword'])){echo $_REQUEST['newPassword']; } ?>" required>

                            </div>
                            <div class="form-group">

                                <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password" value="<?php if (isset($_REQUEST['confirmPassword'])){echo $_REQUEST['confirmPassword']; } ?>" required>
                                <label class="mt-1 ml-2 bg-danger-light" style="font-size: 12px;display:<?php if ($wrongConfirmPassword==false){ echo "none"; }  ?>;">Password doesn't match</label>

                                <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($length==false){echo "bg-danger-light";}elseif($length==true){echo "bg-success-light";} ?>">Password should be at least 8 characters in length</small><br>
                                <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($upCase==false){echo "bg-danger-light";}elseif($upCase==true){echo "bg-success-light";} ?>">Password should include at least one upper case letter</small><br>
                                <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($num==false){echo "bg-danger-light";}elseif($num==true){echo "bg-success-light";} ?>">Password should include at least one number</small><br>
                                <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($speCharacter==false){echo "bg-danger-light";}elseif($speCharacter==true){echo "bg-success-light";} ?>">Password should include at least one special character</small><br>

                            </div>

                            <!-- /Change Password Form -->
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" name="reset" type="submit" >Reset My Password</button>
                            </div>
                        </form>



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