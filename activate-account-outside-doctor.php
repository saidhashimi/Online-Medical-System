<?php
/**
 * Created by PhpStorm.
 * User: Said Muqeem Halimi
 * Date: 13-Aug-20
 * Time: 6:01 PM
 */

require_once ("database-connection.php");
session_start();


if (isset($_REQUEST['username'])){
    $username=$_REQUEST['username'];
    setcookie("username",$username);
}
if (!isset($_COOKIE['username'])){
    header("location:index.php");
    return;
}if (isset($_REQUEST['username'])){
    $username=$_REQUEST['username'];
    $checkCounter=mysqli_num_rows($con->query("select * from users where user_username='$username'"));

    if ($checkCounter>0){
        header("location:doctor-dashboard.php");
        return;
    }
}


$wrongConfirmPassword=false;

$length=true;
$upCase=true;
$lowCase=true;
$num=true;
$speCharacter=true;
$strength=false;
$checkWrong=false;
$checkMatch=false;
$checkStrngth=false;

if ((isset($_REQUEST['newPassword'])) && (isset($_REQUEST['confirmPassword'])) && (isset($_REQUEST['reset']))){

    $username=$_COOKIE['username'];
    $newPassword=$_REQUEST['newPassword'];
    $confirmPassword=$_REQUEST['confirmPassword'];

    $uppercase=preg_match("@[A-Z]@",$newPassword);
    $lowercase=preg_match("@[a-z]@",$newPassword);
    $number=preg_match("@[0-9]@",$newPassword);
    $specialCharacters=preg_match("@[^\w]@",$newPassword);


    if ($newPassword!==$confirmPassword){
        $wrongConfirmPassword=true;
        $checkMatch=true;
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
    }  if (($checkWrong==false) && ($checkMatch==false) && ($checkStrngth==false)){
        $newPassword=password_hash($newPassword,PASSWORD_DEFAULT);

        $username=$_COOKIE['username'];

        $doctorDetails=$con->query("select * from outsidedoctor where email='$username'")->fetch_array();


        $user_name=$doctorDetails['firstname'].' '.$doctorDetails['lastname'];
        $user_username=$doctorDetails['email'];
        $user_address=$doctorDetails['location'];
        $user_contact=$doctorDetails['contact'];




        mysqli_query($con,"insert into users values ('','$user_name','$user_username','$newPassword','$user_address','$user_contact','outside doctor','approved',null )");
        setcookie("username",$username);
        header("location:outside-doctor-dashboard.php");
        return;


    }



}

?>



<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Password - Health Guide</title>

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
                    <a href="index.php">
                    <img class="img-fluid" src="assets/img/logo.png" alt="Logo"></a>
                </div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <h1 class="bg-success-light">Congrats</h1><small class="bg-primary-light mb-1">Your account has been created, now enter your password's for your account</small>

                        <!-- Change Password Form -->
                        <form action="activate-account-outside-doctor.php" method="get">

                            <div class="form-group mt-3">

                                <input type="password" name="newPassword" class="form-control" placeholder="Enter New Password" value="<?php if (isset($_REQUEST['newPassword'])){echo $_REQUEST['newPassword']; } ?>" required>

                            </div>
                            <div class="form-group">

                                <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password" value="<?php if (isset($_REQUEST['confirmPassword'])){echo $_REQUEST['confirmPassword']; } ?>" required>
                                <label class="mt-1 ml-2 bg-danger-light" style="font-size: 12px;display:<?php if ($wrongConfirmPassword==false){ echo "none"; }  ?>;">Password doesn't match</label>
                                <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($length==false){echo "bg-danger-light";}elseif($length==true){echo "bg-success-light";} ?>">Password should be at least 8 characters in length</small><br>
                                <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($upCase==false){echo "bg-danger-light";}elseif($upCase==true){echo "bg-success-light";} ?>">Password should include at least 1 uppercase letter</small><br>
                                <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($num==false){echo "bg-danger-light";}elseif($num==true){echo "bg-success-light";} ?>">Password should include at least 1 number</small><br>
                                <small class="mt-2 <?php if ($strength==false){echo "d-none";}elseif($speCharacter==false){echo "bg-danger-light";}elseif($speCharacter==true){echo "bg-success-light";} ?>">Password should include at least 1 special character</small><br>



                            </div>

                            <!-- /Change Password Form -->
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" name="reset" type="submit" >Save</button>
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
