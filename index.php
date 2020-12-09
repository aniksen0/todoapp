<?php

require "conn.php";

session_start();

if ( isset($_POST['email']) && isset($_POST['pw'])  ) {

    $salt='XyZzy12*_';
    $pw= hash('md5',$salt.$_POST['pw']);
    $check='anik';
   

    $sql = "SELECT * FROM info
        WHERE email = :email AND pw = :pw";


    $stmt=$conn->prepare($sql);
    $stmt->execute(array(
        ':email' => $_POST['email'],
        ':pw' => $pw
    ));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $count = $stmt->rowCount();
     if($_POST['pw']=null){
            $_SESSION['error']="Incorrect password";
             header("Location: index.php");
             return;

        }
        else if (!preg_match("/@/i", $_POST['email'])) {
            $_SESSION['error']= "id must have an at-sign (@)";
            header("Location: index.php");
            return;
        }
        else
        {
            if ( $count !=1 ) {

                $_SESSION['error']="Incorrect Password";

                error_log("Login fail ".$_POST['email']." $pw");
                header("Location: index.php");
                return;
                //echo $pw."\n";
                //echo $check;
            }
            else if ($count==1) {
                $_SESSION['name'] = $row['name'];
                 $_SESSION['addid']=$row['id'];
                $_SESSION['success']="Log In success";
                 header("Location: MainPage.php");
                error_log("Login success ".$_POST['email']);
                return;


            }
        }


}
?>
<!Doctype html>
<html>
<head>
    <title> Todo App::Login</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="logincss.css" rel="stylesheet">
</head>
<body>
<!------ Include the above in your HEAD tag ---------->
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->


        <!-- Login Form -->
        <p style="color: #000;"><?php
            if(isset($_SESSION['error']))
            {
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
            if(isset($_SESSION['success']))
            {
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            }
            ?>
        </p>
        <form method="post">
            <input type="text" id="login" class="fadeIn second" name="email" placeholder="login">
            <input type="text" id="password" class="fadeIn third" name="pw" placeholder="password">
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">

            <a class="underlineHover" href="Signup.php">New HERE? <button class="btn btn-success">Sign up </button></a>
        </div>

    </div>
</div>
</body>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


</html>
