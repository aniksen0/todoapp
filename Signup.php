<?php
/**
 * Created by PhpStorm.
 * User: anik
 * Date: 12/8/2020
 * Time: 1:25 AM
 */
session_start();
require_once "conn.php";

if(isset($_POST['email'])&&isset($_POST['psw'])&& isset($_POST['psw-repeat'])&& isset($_POST['name']) )
{
    if (!preg_match("/@/i", $_POST['email'])) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location:login.php");
        return;
    }
    else if ($_POST['psw']!=$_POST['psw-repeat'])
    {
        $_SESSION['error'] = "Password not matched";
        header("Location:login.php");

    }
    else
    {

        $salt='XyZzy12*_';
        $pw= hash('md5',$salt.$_POST['psw']);
        $check='anik';

        $sql="INSERT INTO info VALUES ( :id, :name , :email, :pass)";
        $data=$conn->prepare($sql);
        $data->execute(array(
            ':id'=>null,
            ':name'=>$_POST['name'],
            ':email'=>$_POST['email'],
            ':pass'=>$pw
        ));
        $_SESSION['success'] = "Now login";
        header("Location:index.php");
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link href="cssforsignup.css" rel="stylesheet">
</head>
<body>
<form method="post" style="border:1px solid #ccc">
    <div class="container">
        <h1>Sign Up</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>
        <label for="name"><b>Name</b></label>
        <input type="text" placeholder="Enter Name" name="name" required>
        <hr>
        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email(ইমেইল দ)" name="email" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password(ইয়ত পাসওয়ার্ড  দ )" name="psw" required>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password (আবার দ)" name="psw-repeat" required>



        <p>Your data is protected -_- kidding. <strong>Don't use any Password which you are already using for another website.এই সাইডত সিকিউরিটি হম । বুইজ্জনা? </strong></p>

        <div class="clearfix">
            <button type="button" class="cancelbtn">Cancel</button>
            <button type="submit" class="signupbtn">Sign Up</button>
        </div>
    </div>
</form>
</body>
</html>



