<?php
 if (isset($_GET['msg'])){
     $msg = $_GET['msg'];
 }else{
     $msg = null;
 }
?>
<?php require_once "helpers/sessionHelper.php"?>
<?php
$ses = new sessionHelper();
$ses->isLogged();
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
    
     
    <div class="d-flex justify-content-center pt-5">
        <div class="card reg-form col-md-5 border-0 bg-danger form-main mb-5">
            <div class="forms pb-3 pl-5 pr-5">
                 <h5 class="text-light text-center pt-1 pb-3">REGISTER</h5>   
               
                 <?php
                if ($msg != null){
                    echo "<p class='text-light'>$msg</p>";
                }else{
                    echo " <p class=\"text-light\">Get registered by filling out the form</p>";
                }
                ?>
                <form method="post" action="route/route.php">
                    <div class="form-group">

                        <input id="fname" class="form-control form-in" type="text" name="fname" placeholder="First name" required>

                    </div>
                    <div class="form-group">

                        <input id="lname" class="form-control" type="text" name="lname" placeholder="Last name" required>

                    </div>

                    <div class="form-group">
                        <label for="gender" class="text-light">Gender</label>
                        <select id="gender" class="form-control" name="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                   
                    <div class="form-group">
                        <input id="email" class="form-control" type="email" name="email" placeholder="email" required>
                    </div>
                    <div class="form-group">
                        <input id="email" class="form-control" type="text" name="username" placeholder="username" required>
                    </div>
                  
                 
                    <div class="form-group">

                        <input type="password" class="form-control" name="password" id="" placeholder="Password">
                    </div>
                    <div class="form-group">

                        <input type="password" class="form-control" name="re_pass" id="" placeholder="Confirm password">
                    </div>
                    <div class="d-flex justify-content-center">
                    <input type="submit" name="admin_reg" class="btn btn-light text-danger" value="SingUp">
                    </div>
                    
                </form>
            </div>
        </div>
        
    </div>
</div>
</body>
</html>