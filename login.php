<?php require_once "helpers/sessionHelper.php"?>
<?php
$ses = new sessionHelper();
$ses->isLogged();
?>
<?php

if (isset($_GET['msg'])){
    $msg = $_GET['msg'];
}else{
    $msg = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/st.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-danger bg-danger fixed-top">
    
    <div id="my-nav" class="collapse navbar-collapse">
          <!--
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link text-light" href="#">Home |<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="#" tabindex="-1" aria-disabled="true">About |</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="#" tabindex="-1" aria-disabled="true">Support </a>
            </li>
        </ul>
-->
    </div>
    <div>
        <a href="admin_login.php" class="admin-logo"><img src="images/user-cog.svg" alt="" srcset=""></a>
        <ul class="navbar-nav">
            
            <li class="nav-item">
                <a href="login.php" class="nav-link text-light">Login |</a>
            </li>
            <li>
                <a href="register.php" class="nav-link text-light">Register</a>
            </li>
            <li>
                
            </li>
        </ul>
        
    </div>
</nav>
<h1 class="text-center text-light bg-lr pb-1">BLOOD BANK</h1>
<div class="d-flex justify-content-center flex-column container">
    
    <div class="d-flex justify-content-around pt-5">
        <div class="card log-card border-0 bg-danger form-main mb-5">
            <div>
                <img class="log-img" src="images/BB Logo 2.png" alt="" srcset="">
            </div>
            <div class="forms log-form pb-3 pl-5 pr-5">
                <?php
                if ($msg != null){
                    echo "<p class='text-danger'>$msg</p>";
                }else{
                    echo "  <p class=\"pb-2 text-primary\">Enter your login credentials</p>";
                }
                ?>
                <form method="post" action="route/route.php">
                    <div class="form-group">
                        <input id="username" class="form-control text-danger" type="text" name="username" placeholder="Email or phone number" required>
                    </div>

                    <div class="form-group">

                        <input type="password" class="form-control text-danger" name="password" id="" placeholder="Password">
                    </div>
                    <div class="d-flex justify-content-center">
                        <input type="submit" name="login" class="btn btn-light text-danger" value="Login">
                    </div>
                    <p class="text-light pt-3">Dont have an account?<a href="register.php" class="text-light">Register</a></p>
                </form>
            </div>
        </div>
        
    </div>
</div>
</body>
</html>